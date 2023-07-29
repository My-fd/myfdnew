<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;

/**
 * Роут АПИ сервиса
 */
abstract class Path
{
    /**
     * Типы http методов
     */
    const METHOD_GET     = 'get';
    const METHOD_POST    = 'post';
    const METHOD_PUT     = 'put';
    const METHOD_DELETE  = 'delete';
    const METHOD_OPTIONS = 'options';
    const METHOD_HEAD    = 'head';
    const METHOD_PATH    = 'patch';
    const METHOD_TRACE   = 'trace';

    /**
     * Имя роута
     * Данное поле является техническим и в документации эти данные не отображаются
     * Поле нужно лишь для построения правленого дерева роута
     *
     * @var string
     */
    public string $name;

    /**
     * URI путь АПИ метода (должно продолжать ссылку из блока "servers")
     *
     * @var string
     */
    public string $path;

    /**
     * Описание роута
     *
     * @var string
     */
    public string $description;

    /**
     * Тэги роута
     * Тэг служит для группировки роутов на странице документации
     *
     * @var array
     */
    public array $tags = [];

    /**
     * Массив схем безопасности роута (авторизация и т.д.)
     *
     * @var array
     */
    public array $security = [];

    /**
     * Массив параметров
     *
     * @var Parameter[]
     */
    protected array $parameters = [];

    /**
     * Массив ответов
     *
     * @var Response[]
     */
    protected array $responses = [];

    /**
     * Тело запроса
     *
     * @var Request|null
     */
    protected Request|null $request = null;

    /**
     * Конструктор
     *
     * @param string $name
     * @param string $path
     * @param string $description
     * @param array  $tags
     * @param array  $security
     */
    public function __construct(string $name, string $path, string $description, array $tags = [], array $security = [])
    {
        $this->name        = $name;
        $this->path        = $path;
        $this->description = $description;
        $this->tags        = $tags;
        $this->security    = $security;
    }

    /**
     * Возвращает http метод роута
     *
     * @return string
     */
    abstract public function getHttpMethod(): string;

    /**
     * Добавляет параметр в роут
     *
     * @param Parameter $parameter
     * @throws AttributeException
     */
    public function addParameter(Parameter $parameter)
    {
        if (isset($this->parameters[$parameter->name])
            && $this->parameters[$parameter->name]->in === $parameter->in
        ) {
            throw new AttributeException(
                sprintf(
                    'Роут %s (%s: %s) уже содержит параметр с именем %s в секции %s',
                    $this->name,
                    $this->getHttpMethod(),
                    $this->path,
                    $parameter->name,
                    $parameter->in,
                )
            );
        }

        $this->parameters[$parameter->name] = $parameter;
    }

    /**
     * Возвращает параметр по имени
     *
     * @param string $name
     * @return Parameter|null
     */
    public function getParameter(string $name): Parameter|null
    {
        return $this->parameters[$name] ?? null;
    }

    /**
     * Добавляет ответ в роут
     *
     * @param Response $response
     * @throws AttributeException
     */
    public function addResponse(Response $response)
    {
        if (isset($this->responses[$response->name])
            && $this->responses[$response->name]->status === $response->status
            && $this->responses[$response->name]->getType() === $response->getType()
        ) {
            throw new AttributeException(
                sprintf(
                    'Роут %s (%s: %s) уже содержит ответ с именем %s (%s: %s)',
                    $this->name,
                    $this->getHttpMethod(),
                    $this->path,
                    $response->name,
                    $response->getType(),
                    $response->status,
                )
            );
        }

        $this->responses[$response->name] = $response;
    }

    /**
     * Возвращает ответ роута по имени ключевому ответа
     *
     * @param string $name
     * @return Response|null
     */
    public function getResponse(string $name): Response|null
    {
        return $this->responses[$name] ?? null;
    }

    /**
     * Возвращает запрос роута
     *
     * @return Request|null
     */
    public function getRequest(): Request|null
    {
        return $this->request;
    }

    /**
     * Устанавливает тело запроса в роут
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $scheme = [
            'tags'        => $this->tags,
            'description' => $this->description,
        ];

        foreach ($this->security as $security) {
            $scheme['security'][] = [$security => []];
        }

        foreach ($this->parameters as $parameter) {
            $scheme['parameters'][] = $parameter->toArray();
        }

        if ($this->request) {
            $scheme['requestBody'] = $this->request->toArray();
        }

        foreach ($this->responses as $response) {
            $scheme['responses'][$response->status] = $response->toArray();
        }

        return $scheme;
    }
}
