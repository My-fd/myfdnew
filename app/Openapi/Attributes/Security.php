<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;

/**
 * Класс описывающий схему безопасности
 * Базовая авторизация/Api Token/Access Token/Bearer Token и т.д.
 */
abstract class Security
{
    /**
     * Типы схем
     */
    protected const TYPE_HTTP            = 'http';
    protected const TYPE_API_KEY         = 'apiKey';
    protected const TYPE_OAUTH2          = 'oauth2';
    protected const TYPE_OPEN_ID_CONNECT = 'openIdConnect';

    /**
     * Конструктор
     *
     * @param string $securityName
     * @param string $description
     */
    public function __construct(public string $securityName, public string $description)
    {
    }

    /**
     * Возвращает тип схемы
     *
     * @return string
     */
    abstract public function getType(): string;

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        return [
            'type'        => $this->getType(),
            'description' => $this->description,
        ];
    }
}
