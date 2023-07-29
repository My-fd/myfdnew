<?php
namespace App\Openapi;

/**
 * Класс для поиска классов в указанной директории
 */
final class ClassFinder
{
    /**
     * Composer autoloader
     *
     * @var mixed|null
     */
    private mixed $autoloader = null;

    /**
     * Массив классов
     *
     * @var array
     */
    private array $classes = [];

    /**
     * Конструктор
     *
     * @param string $autoloaderFilePath
     */
    public function __construct(string $autoloaderFilePath)
    {
        $this->autoloader = require $autoloaderFilePath;

        if (!empty($this->autoloader)) {
            $this->classes = array_keys($this->autoloader->getClassMap());
        }
    }

    /**
     * Возвращает все зарегистрированные классы
     *
     * @return array
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Возвращает классы по неймспейсу
     *
     * @param $namespace
     * @return array
     */
    public function getClassesByNamespace($namespace): array
    {
        $termUpper = strtoupper($namespace);

        return array_filter($this->getClasses(), function ($class) use ($termUpper) {
            $className = strtoupper($class);

            if (str_starts_with($className, $termUpper)) {
                return $class;
            }

            return false;
        });
    }
}
