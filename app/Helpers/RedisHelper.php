<?php
namespace App\Helpers;

use Redis;

/**
 * Хелпер для работы с редисом
 *
 * Class RedisHelper
 * @package App\Helpers
 */
class RedisHelper
{
    /**
     * Редис клиент
     *
     * @var Redis
     */
    private $redis;

    /**
     * Префикс окружения
     *
     * @var string
     */
    private $environmentPrefix = '';

    /**
     * Конструктор
     *
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis             = $redis;
        $this->environmentPrefix = env('APP_ENV', 'local');
    }

    /**
     * Сохраняет запись в редис
     *
     * @param string   $key
     * @param string   $value
     * @param int|null $timeoutSeconds
     * @return bool
     */
    public function set(string $key, string $value, int $timeoutSeconds = null): bool
    {
        return $this->redis->set(sprintf('%s::%s', $this->environmentPrefix, $key), $value, $timeoutSeconds);
    }

    /**
     * Возвращает значение ключа
     *
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        $value = $this->redis->get(sprintf('%s::%s', $this->environmentPrefix, $key));

        if ($value === false) {
            return null;
        }

        return (string)$value;
    }

    /**
     * Удаляет значение
     *
     * @param string $key
     * @return int Количество удаленных ключей
     */
    public function del(string $key): int
    {
        return $this->redis->del(sprintf('%s::%s', $this->environmentPrefix, $key));
    }

    /**
     * Создаёт запись в редисе с ключом в виде уникального хэша и возвращает хэш, если успешно
     *
     * @param string   $value
     * @param int $timeoutSeconds
     * @return string|null
     */
    public function setTokenKey(string $value, int $timeoutSeconds = 60): ?string
    {
        $token = GenerateHelper::newToken(30);

        while ($this->get($token)) {
            $token = GenerateHelper::newToken(30);
        }

        if (!$this->set($token, $value, $timeoutSeconds)) {
            return null;
        }

        return $token;
    }
}
