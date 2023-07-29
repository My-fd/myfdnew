<?php
namespace App\Openapi\Attributes;

use Attribute;

/**
 * Общая информация об АПИ сервисе
 */
#[Attribute]
class Info
{
    /**
     * Название сервиса
     *
     * @var string
     */
    public string $title;

    /**
     * Версия АПИ методов описанных в документации
     *
     * @var string
     */
    public string $version;

    /**
     * Описание сервиса
     *
     * @var string|null
     */
    public string|null $description = null;

    /**
     * Конструктор
     *
     * @param string      $title
     * @param string      $version
     * @param string|null $description
     */
    public function __construct(string $title, string $version, string|null $description = null)
    {
        $this->title       = $title;
        $this->version     = $version;
        $this->description = $description;
    }
}
