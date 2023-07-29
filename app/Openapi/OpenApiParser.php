<?php
namespace App\Openapi;

use App\Openapi\Attributes\Additional\Component;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Info;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\Path;
use App\Openapi\Attributes\Property;
use App\Openapi\Attributes\PropertyArray;
use App\Openapi\Attributes\PropertyObject;
use App\Openapi\Attributes\Request;
use App\Openapi\Attributes\Response;
use App\Openapi\Attributes\Security;
use App\Openapi\Attributes\SecurityHttp;
use App\Openapi\Attributes\Server;
use App\Openapi\Attributes\Tag;
use App\Openapi\Exceptions\AttributeException;
use App\Openapi\Parsers\FormRequestParser;
use Illuminate\Foundation\Http\FormRequest;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Основной парсер спецификации
 */
class OpenApiParser
{
    /**
     * Объект Open API спецификации
     *
     * @var OpenApiSpecification
     */
    protected OpenApiSpecification $spec;

    /**
     * Сканер классов
     *
     * @var ClassFinder
     */
    protected ClassFinder $finder;

    /**
     * Массив объектов в которых не удалось разрешить виртуальные ссылки
     *
     * @var array
     */
    protected array $unresolvedVirtualRefs = [];

    /**
     * Конструктор
     *
     * @param string $autoloadFilePath
     */
    public function __construct(string $autoloadFilePath)
    {
        $this->spec   = new OpenApiSpecification();
        $this->finder = new ClassFinder($autoloadFilePath);
    }

    /**
     * Парсит указанный namespace и собирает Open API спецификацию на основе найденных классов
     *
     * @param array $namespaces
     * @return OpenApiSpecification
     * @throws AttributeException
     * @throws Exceptions\ParseException
     * @throws ReflectionException
     */
    public function build(array $namespaces): OpenApiSpecification
    {
        foreach ($namespaces as $namespace) {
            foreach ($this->finder->getClassesByNamespace($namespace) as $class) {
                $reflector = new ReflectionClass($class);
                $this->parseInfoAttributes($reflector->getAttributes(Info::class));
                $this->parseServerAttributes($reflector->getAttributes(Server::class));
                $this->parseTagsAttributes($reflector->getAttributes(Tag::class));
                $this->parseSecurityAttributes($reflector->getAttributes(SecurityHttp::class));

                if ($reflector->getAttributes(Component::class)) {
                    $this->parseComponent($reflector);
                }

                if ($reflector->getAttributes(Controller::class)) {
                    foreach ($reflector->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        // Игнорируем методы объявленные в родительских классах или трейтах
                        if ($method->class !== $reflector->name) continue;

                        $this->parsePath($method);
                    }
                }
            }
        }

        foreach ($this->unresolvedVirtualRefs as $attr) {
            $this->resolveVirtualRef($attr, false);
        }

        return $this->spec;
    }

    /**
     * Парсит атрибуты общей информации об АПИ сервисе
     *
     * @param ReflectionAttribute[] $attributes
     */
    protected function parseInfoAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            /** @var Info $attr */
            $attr = $attribute->newInstance();

            $this->spec->setInfo($attr);
        }
    }

    /**
     * Парсит атрибуты хостов АПИ сервиса
     *
     * @param ReflectionAttribute[] $attributes
     */
    protected function parseServerAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            /** @var Server $attr */
            $attr = $attribute->newInstance();

            $this->spec->addServer($attr);
        }
    }

    /**
     * Парсит атрибуты тега
     *
     * @param ReflectionAttribute[] $attributes
     */
    protected function parseTagsAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            /** @var Tag $attr */
            $attr = $attribute->newInstance();

            $this->spec->addTag($attr);
        }
    }

    /**
     * Парсит атрибуты схем безопасности
     *
     * @param ReflectionAttribute[] $attributes
     */
    protected function parseSecurityAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            /** @var Security $attr */
            $attr = $attribute->newInstance();

            $this->spec->addSecurity($attr);
        }
    }

    /**
     * Парсит класс содержащий атрибут компонента
     *
     * @param ReflectionClass $reflector
     * @throws Exceptions\AttributeException
     */
    protected function parseComponent(ReflectionClass $reflector): void
    {
        $schema = new PropertyObject(
            $reflector->getShortName(),
            $reflector->getShortName() ?? ''
        );

        foreach ($reflector->getAttributes() as $attribute) {
            $attr = $attribute->newInstance();

            // Пропускаем все что не является полем
            if (!$attr instanceof Property) continue;

            // Если поле является корневым, то сразу добавляем его в объект компонента
            if (!$attr->hasParent()) {
                $schema->addProperty($attr);

                continue;
            }

            $parents        = explode('.', $attr->parent);
            $parentProperty = $schema; // Корневым родителем назначаем сам компонент

            // Далее уже в компоненте пытаемся найти прямого родителя
            foreach ($parents as $parent) {
                if ($parentProperty instanceof PropertyObject) {
                    $parentProperty = $parentProperty->getProperty($parent);
                } elseif ($parentProperty instanceof PropertyArray) {
                    $parentProperty = $parentProperty->getItem();
                } else {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s (%s) не может быть родителем для поля %s, т.к. не является объектом или массивом',
                            $parent,
                            $attr->parent,
                            $attr->name,
                        )
                    );
                }

                if ($parentProperty == null) {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s ссылается на не объявленный объект %s (%s)',
                            $attr->name,
                            $parent,
                            $attr->parent,
                        )
                    );
                }
            }

            // В зависимости от типа родителя сетим дочерний объект
            if ($parentProperty instanceof PropertyObject) {
                $parentProperty->addProperty($attr);
            } elseif ($parentProperty instanceof PropertyArray) {
                $parentProperty->setItem($attr);
            } else {
                throw new AttributeException(
                    sprintf(
                        'Поле %s не может быть родителем для поля %s (%s), т.к. не является объектом или массивом',
                        $parentProperty->name,
                        $attr->name,
                        $attr->parent,
                    )
                );
            }

            if (($attr instanceof PropertyArray || $attr instanceof PropertyObject) && $attr->vRef) {
                $this->resolveVirtualRef($attr);
            }
        }

        $this->spec->addSchema($schema->name, $schema);
    }

    /**
     * Парсит метод класса содержащего атрибут контроллера
     *
     * @param ReflectionMethod $method
     * @throws AttributeException
     * @throws Exceptions\ParseException
     * @throws ReflectionException
     */
    protected function parsePath(ReflectionMethod $method): void
    {
        $path = null;

        foreach ($method->getAttributes() as $attribute) {
            $attr = $attribute->newInstance();

            if ($attr instanceof Path) {
                $path = $attr;

                continue;
            }

            if ($attr instanceof Parameter) {
                if (!$path) {
                    throw new AttributeException(
                        sprintf(
                            'Не удалось ассоциировать параметр %s с каким либо роутом. Объявите атрибут Path* раньше этого параметра',
                            $attr->name,
                        )
                    );
                }

                $path->addParameter($attr);

                continue;
            }

            if ($attr instanceof Response) {
                if (!$path) {
                    throw new AttributeException(
                        sprintf(
                            'Не удалось ассоциировать ответ %s с каким либо роутом. Объявите атрибут Path* раньше этого ответа',
                            $attr->name,
                        )
                    );
                }

                $path->addResponse($attr);

                if ($attr->vRef) {
                    $this->resolveVirtualRef($attr);
                }

                continue;
            }

            if ($attr instanceof Request) {
                if (!$path) {
                    throw new AttributeException(
                        sprintf(
                            'Не удалось ассоциировать запрос %s с каким либо роутом. Объявите атрибут Path* раньше этого запроса',
                            $attr->name,
                        )
                    );
                }

                $path->setRequest($attr);

                continue;
            }

            if ($attr instanceof Property) {
                if (!$attr->hasParent()) {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s должно иметь родителя (ответ/запрос/другое поле)',
                            $attr->name,
                        )
                    );
                }

                $parents  = explode('.', $attr->parent);
                $rootName = array_shift($parents); // Определяем имя абсолютного родителя для поля

                if (!$rootName) {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s размещено над методом, и должно быть закреплено за родителем, ответом или запросом',
                            $attr->name
                        )
                    );
                }

                // Определяем абсолютным родителем соответствующий ответ или запрос
                $parentProperty = $path->getResponse($rootName) ?? $path->getRequest();

                if (!$parentProperty) {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s ссылается на не объявленный объект %s, ожидается ссылка на уже объявленное тело запроса или ответ',
                            $attr->name,
                            $rootName,
                        )
                    );
                }

                foreach ($parents as $parent) {
                    if ($parentProperty instanceof Request) {
                        $parentProperty = $parentProperty->getProperty($parent);
                    } elseif ($parentProperty instanceof Response || $parentProperty instanceof PropertyObject) {
                        $this->resolvePropertiesVirtualRef($parentProperty);
                        $parentProperty = $parentProperty->getProperty($parent);
                    } elseif ($parentProperty instanceof PropertyArray) {
                        // $this->resolvePropertiesVirtualRef($parentProperty); Call to undefined method App\Openapi\Attributes\PropertyArray::getProperties()
                        $parentProperty = $parentProperty->getItem();
                    } else {
                        throw new AttributeException(
                            sprintf(
                                'Поле %s (%s) не может быть родителем для поля %s, т.к. не является объектом, массивом, запросом или ответом',
                                $parent,
                                $attr->parent,
                                $attr->name,
                            )
                        );
                    }

                    if ($parentProperty == null) {
                        throw new AttributeException(
                            sprintf(
                                'Поле %s ссылается на не объявленный объект %s (%s)',
                                $attr->name,
                                $parent,
                                $attr->parent
                            )
                        );
                    }
                }

                if ($parentProperty instanceof Request) {
                    $parentProperty->addProperty($attr);
                } elseif ($parentProperty instanceof Response) {
                    $parentProperty->addProperty($attr);
                } elseif ($parentProperty instanceof PropertyObject) {
                    $parentProperty->addProperty($attr);
                } elseif ($parentProperty instanceof PropertyArray) {
                    $parentProperty->setItem($attr);
                } else {
                    throw new AttributeException(
                        sprintf(
                            'Поле %s не может быть родителем для поля %s (%s), т.к. не является объектом, массивом, запросом или ответом',
                            $parentProperty->name,
                            $attr->name,
                            $attr->parent,
                        )
                    );
                }

                if (($attr instanceof PropertyArray || $attr instanceof PropertyObject) && $attr->vRef) {
                    $this->resolveVirtualRef($attr);
                }
            }
        }

        if ($path) {
            $this->spec->addPath($path);

            $this->parseFormRequest($method, $path);
        }
    }

    /**
     * Парсит laravel form request и добавляет поля валидации в описание параметров
     *
     * @param ReflectionMethod $method
     * @param Path              $path
     * @throws Exceptions\ParseException
     * @throws ReflectionException
     */
    protected function parseFormRequest(ReflectionMethod $method, Path $path): void
    {
        $validations = [];

        foreach ($method->getParameters() as $parameter) {
            if ($parameter->hasType() && !$parameter->getType()->isBuiltin() && $class = $parameter->getType()->getName()) {
                $reflector = new ReflectionClass($class);

                if ($reflector->hasMethod('rules') && $reflector->isSubclassOf(FormRequest::class)) {
                    $request = $reflector->newInstance();

                    if ($request instanceof FormRequest) {
                        $validations = array_merge($validations, FormRequestParser::parse($request));
                    }
                }
            }
        }

        foreach ($validations as $validation) {
            $parameter = $path->getParameter($validation->name) ?? $path->getRequest()?->getProperty($validation->name);

            if ($parameter) {
                if ($parameter instanceof Parameter) {
                    $parameter->description = sprintf('%s: %s', $parameter->description, implode(', ', $validation->descriptions));
                } elseif ($parameter instanceof Property) {
                    $parameter->description = sprintf('%s: %s', $parameter->description, implode(', ', $validation->descriptions));
                }
            }
        }
    }

    /**
     * Обрабатывает виртуальную ссылку объекта
     *
     * @param Response|PropertyObject|PropertyArray $attr
     * @param bool                                  $saveUnresolved
     * @throws AttributeException
     */
    protected function resolveVirtualRef(Response|PropertyObject|PropertyArray $attr, bool $saveUnresolved = true): void
    {
        $object = $this->spec->getSchema($attr->vRef);

        if ($object) {
            if ($attr instanceof PropertyArray) {
                $attr->setItem($object);
            } else {
                foreach ($object->getProperties() as $property) {
                    $attr->addProperty($property);
                }
            }

            return;
        }

        if ($saveUnresolved) {
            $this->unresolvedVirtualRefs[] = $attr;
        }
    }

    /**
     * Обрабатывает vRef в properties
     *
     * @param $parentProperty
     * @return void
     */
    protected function resolvePropertiesVirtualRef($parentProperty): void
    {
        foreach ($parentProperty->getProperties() as $property) {
            if ($property instanceof PropertyObject || $property instanceof PropertyArray) {
                if ($property->vRef) {
                    $this->resolveVirtualRef($property);
                }
            }
        }
    }
}
