<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\Tag;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер категорий
 * class CategoriesController
 * @package App\Http\Controllers\Api
 */
#[\App\Openapi\Attributes\Additional\Controller]
#[Tag('Категории')]
class CategoriesController extends BaseApiController
{
    #[PathGet('categories', '/v1/categories', 'Получение списка категорий', ['Категории'])]
    #[ResponseSuccess(200, ref: CategoryTransformer::class)]
    #[ResponseError(400, 'Ошибка запроса', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function index(): JsonResponse
    {
        $categories            = Category::all();
        $transformedCategories = [];

        foreach ($categories as $category) {
            $transformedCategories[] = CategoryTransformer::toArray($category);
        }

        return $this->successResponse($transformedCategories);
    }
}