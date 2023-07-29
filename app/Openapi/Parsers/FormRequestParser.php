<?php
namespace App\Openapi\Parsers;

use App\Openapi\Attributes\Validator;
use App\Openapi\Elements\Validation;
use App\Openapi\Exceptions\ParseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Stringable;
use ReflectionObject;

/**
 * Парсер request классов
 */
class FormRequestParser
{
    /**
     * Анализирует правила валидации в классе валидации ларавеля
     *
     * @param FormRequest $request
     * @return Validation[]
     * @throws ParseException
     */
    public static function parse(FormRequest $request): array
    {
        $validations = [];

        // TODO https://gitlab.com/kostylworks/dabster-api/-/issues/21
        if (method_exists($request, 'rules')) {
            foreach ($request->rules() as $field => $rules) {
                $validations[] = new Validation($field, self::parseRules($rules));
            }
        }

        return $validations;
    }

    /**
     * Парсит валидацию в строчное описание
     *
     * @param array|string $rules
     * @return array
     * @throws ParseException
     */
    private static function parseRules(array|string $rules): array
    {
        $descriptions = [];

        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        foreach ($rules as $rule) {
            $descriptions[] = self::getRuleDescription($rule);
        }

        return $descriptions;
    }

    /**
     * Возвращает описание правила валидации
     *
     * @param $rule
     * @return string
     * @throws ParseException
     */
    private static function getRuleDescription($rule): string
    {
        if (is_string($rule)) {
            return $rule;
        }

        if ($rule instanceof Stringable) {
            return (string)$rule;
        }

        if (is_object($rule)) {
            $reflector = new ReflectionObject($rule);

            if ($attributes = $reflector->getAttributes(Validator::class)) {
                /** @var Validator $validator */
                $validator = $attributes[0]->newInstance();

                return $validator->description;
            }

            if ($reflector->hasMethod('__toString')) {
                return (string)$rule;
            }

            return $reflector->name;
        }

        throw new ParseException('Не удалось распарсить плавило валидации - ' . (string)$rule);
    }
}
