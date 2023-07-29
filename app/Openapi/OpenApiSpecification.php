<?php
namespace App\Openapi;

use App\Openapi\Attributes\Info;
use App\Openapi\Attributes\Path;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\Security;
use App\Openapi\Attributes\Server;
use App\Openapi\Attributes\Tag;

/**
 * Объект (дерево) собранной спецификации
 */
class OpenApiSpecification
{
    /**
     * Версия Open API спецификации
     *
     * @var string
     */
    private string $specificationVersion = '3.0.0';

    /**
     * Общая информация об АПИ
     *
     * @var Info|null
     */
    private Info|null $info;

    /**
     * Массив АПИ хостов
     *
     * @var Server[]|null
     */
    private array|null $servers = null;

    /**
     * Массив АПИ методов
     *
     * @var Path[]|null
     */
    private array|null $paths = null;

    /**
     * Массив схем безопасности (мидлвары/авторизация)
     *
     * @var Security[]|null
     */
    private array|null $securities = null;

    /**
     * Массив схем объектов
     *
     * @var PropertyObject[]|null
     */
    private array|null $schemas = null;

    /**
     * Массив тэгов
     *
     * @var Tag[]|null
     */
    private array|null $tags = null;

    /**
     * Общая информация об АПИ
     *
     * @param Info $info
     * @return OpenApiSpecification
     */
    public function setInfo(Info $info): static
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Добавляет хост АПИ сервиса
     *
     * @param Server $server
     * @return OpenApiSpecification
     */
    public function addServer(Server $server): static
    {
        $this->servers[] = $server;

        return $this;
    }

    /**
     * Добавляет роут АПИ сервиса
     *
     * @param Path $path
     * @return $this
     */
    public function addPath(Path $path): static
    {
        $this->paths[$path->name][$path->getHttpMethod()] = $path;

        return $this;
    }

    /**
     * Возвращает роут по его имени и http методу
     *
     * @param string $name
     * @param string $httpMethod
     * @return Path|null
     */
    public function getPath(string $name, string $httpMethod): Path|null
    {
        return $this->paths[$name][$httpMethod] ?? null;
    }

    /**
     * Добавляет описание схемы безопасности
     *
     * @param Security $security
     * @return $this
     */
    public function addSecurity(Security $security): static
    {
        $this->securities[$security->securityName] = $security;

        return $this;
    }

    /**
     * Добавляет объект в документацию
     * На добавленные объекты можно делать ссылки по имени $ref="#/components/schemas/{$name}"
     *
     * @param string         $name
     * @param PropertyObject $object
     * @return $this
     */
    public function addSchema(string $name, PropertyObject $object): static
    {
        $this->schemas[$name] = $object;

        return $this;
    }

    /**
     * Возвращает объект из документации
     *
     * @param string $name
     * @return PropertyObject|null
     */
    public function getSchema(string $name): PropertyObject|null
    {
        return $this->schemas[$name] ?? null;
    }

    /**
     * Добавляет тег
     *
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag): static
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Трансформирует спецификацию в массив
     *
     * @return array
     * @throws Exceptions\AttributeException
     */
    public function toArray(): array
    {
        $spec = [
            'openapi' => $this->specificationVersion,
            'info'    => [
                'title'   => $this->info->title,
                'version' => $this->info->version,
            ],
        ];

        if ($this->info->description) {
            $spec['info']['description'] = $this->info->description;
        }

        foreach ($this->servers as $server) {
            $spec['servers'][] = [
                'url'         => $server->url,
                'description' => $server->description,
            ];
        }

        foreach ($this->paths as $name => $pathMyMethods) {
            foreach ($pathMyMethods as $method => $path) {
                $spec['paths'][$path->path][$path->getHttpMethod()] = $path->toArray();
            }
        }

        foreach ($this->securities as $security) {
            $spec['components']['securitySchemes'][$security->securityName] = $security->toArray();
        }

        foreach ($this->schemas as $schema) {
            $spec['components']['schemas'][$schema->name] = $schema->toArray();
        }

        foreach ($this->tags as $tag) {
            $spec['tags'][] = [
                'name'        => $tag->name,
                'description' => $tag->description,
            ];
        }

        return $spec;
    }

    /**
     * Трансформирует спецификацию в json строку
     *
     * @return string
     * @throws Exceptions\AttributeException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
