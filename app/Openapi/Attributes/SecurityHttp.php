<?php
namespace App\Openapi\Attributes;

use App\Openapi\Exceptions\AttributeException;
use Attribute;

#[Attribute]
class SecurityHttp extends Security
{
    /**
     * Схема http авторизации
     *
     * @var string
     */
    public string $scheme = 'bearer';

    /**
     * Конструктор
     *
     * @param string $securityName
     * @param string $description
     * @param string $scheme
     */
    public function __construct(string $securityName, string $description, string $scheme = 'bearer')
    {
        $this->scheme = $scheme;

        parent::__construct($securityName, $description);
    }

    /**
     * Возвращает тип схемы
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_HTTP;
    }

    /**
     * Преобразуется в массив совместимый с форматом OPENAPI
     *
     * @return array
     * @throws AttributeException
     */
    public function toArray(): array
    {
        $schema           = parent::toArray();
        $schema['scheme'] = $this->scheme;

        return $schema;
    }
}
