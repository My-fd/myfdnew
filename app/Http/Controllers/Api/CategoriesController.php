<?php
namespace App\Http\Controllers\Api;

use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\Tag;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;
use App\Transformers\ListingTransformer;
use Illuminate\Http\JsonResponse;

/**
 * API Контроллер для категорий
 *
 * @package App\Http\Controllers\Api
 */
#[Controller]
#[Tag('Категории')]
class CategoriesController extends BaseApiController
{
    /**
     * Получить список всех категорий
     *
     * @return JsonResponse
     */
    #[PathGet('index', '/v1/categories', 'Получение списка категорий', ['Категории'])]
    #[ResponseSuccess(200, vRef: Cate::class)]
    #[ResponseError(400, 'Ошибка запроса', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function index(): JsonResponse
    {
        $categories = Category::all();
        $transformedCategories = [];

        foreach ($categories as $category) {
            $transformedCategories[] = CategoryTransformer::toArray($category);
        }

        return $this->successResponse($transformedCategories);
    }
}
