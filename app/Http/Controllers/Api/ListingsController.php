<?php

namespace App\Http\Controllers\Api;

use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\PathPost;
use App\Openapi\Attributes\PropertyFloat;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\RequestFormEncoded;
use App\Openapi\Attributes\Tag;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;
use App\Transformers\ListingTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Models\Listing;

#[Controller]
#[Tag('Объявления')]
class ListingsController extends BaseApiController
{
    #[PathGet('index', '/v1/listings', 'Получение списка объявлений', ['Объявления'])]
    #[ResponseSuccess(200, vRef: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка запроса', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function index(Request $request): JsonResponse
    {
        // Получение списка объявлений, возможно с фильтрацией
        $categoryId = $request->input('category_id');
        $query      = Listing::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $listings = $query->paginate(25);

        return $this->successResponse([
            'data'     => ListingTransformer::manyToArray($listings->items()),
            'page'     => $listings->currentPage(),
            'lastPage' => $listings->lastPage(),
        ]);
    }

    /**
     * Метод для создания объявления
     *
     * @param ListingRequest $request
     * @return JsonResponse
     */
    #[PathPost('store', '/v1/listings', 'Создание объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('title', 'Название объявления', 'Мой товар', parent: 'request')]
    #[PropertyString('description', 'Описание объявления', 'Описание товара', parent: 'request')]
    #[PropertyFloat('price', 'Цена', 100.0, parent: 'request')]
    #[PropertyInt('category_id', 'ID категории', 1, parent: 'request')]
    #[ResponseSuccess(201, vRef: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function store(ListingRequest $request): JsonResponse
    {
        $listing = Listing::create($request->validated());

        return $this->successResponse(ListingTransformer::toArray($listing), 201);
    }

    /**
     * Метод для получения информации об объявлении
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    #[PathGet('show', '/v1/listings/{listing}', 'Получение информации об объявлении', ['Объявления'])]
    #[ResponseSuccess(200, vRef: ListingTransformer::class)]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function show(Listing $listing): JsonResponse
    {
        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    /**
     * Метод для обновления объявления
     *
     * @param ListingRequest $request
     * @param Listing        $listing
     * @return JsonResponse
     */
    #[PathPost('update', '/v1/listings/{listing}', 'Обновление объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('title', 'Название объявления', 'Мой товар', parent: 'request')]
    #[PropertyString('description', 'Описание объявления', 'Описание товара', parent: 'request')]
    #[PropertyFloat('price', 'Цена', 100.0, parent: 'request')]
    #[PropertyInt('category_id', 'ID категории', 1, parent: 'request')]
    #[ResponseSuccess(200, vRef: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function update(ListingRequest $request, Listing $listing): JsonResponse
    {
        $listing->update($request->validated());

        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    /**
     * Метод для удаления объявления
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    #[PathPost('destroy', '/v1/listings/{listing}', 'Удаление объявления', ['Объявления'], ['auth'])]
    #[ResponseSuccess(204)]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function destroy(Listing $listing): JsonResponse
    {
        $listing->delete();

        return $this->successResponse([]);
    }
}