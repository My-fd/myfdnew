<?php

namespace App\Transformers;

trait BaseTransformer
{
    /**
     * Трансформация массива
     *
     * @param $array
     * @return array
     */
    public static function manyToArray($array): array
    {
        $data = [];
        foreach ($array as $value) {
            $data[] = self::toArray($value);
        }

        return $data;
    }
}