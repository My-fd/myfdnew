<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Хелпер для генерации различных токенов/кодов и прочего
 *
 * Class GenerateHelper
 * @package App\Helpers
 */
class GenerateHelper
{
    /**
     * Возвращает валидный для MySQL и HTML токен
     *
     * @param int $length
     * @return string
     */
    public static function newToken(int $length = 15): string
    {
        return substr(str_replace(["/", "?", "&", ".", "_", "\\", "#", '$'], "", Hash::make(Str::random())), 0, $length);
    }

    /**
     * Генерирует СМС код
     *
     * @param int $length
     * @return string
     */
    public static function newSmsCode(int $length = 4): string
    {
        if (env('SMS_MOCK_MODE', true)) {
            return str_repeat('1', $length);
        }

        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= rand(0, 9);
        }

        return $code;
    }
}
