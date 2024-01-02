<?php

namespace App\Http\Controllers\Api;

use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterInt;
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
use App\Http\Requests\ListingRequest;
use App\Models\Listing;

/**
 * Контроллер объявлений
 * class ListingsController
 * @package App\Http\Controllers\Api
 */
#[Controller]
#[Tag('Объявления')]
class ListingsController extends BaseApiController
{
    #[PathGet('listings', '/v1/listings', 'Получение списка объявлений', ['Объявления'])]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка запроса', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function index(Request $request): JsonResponse
    {
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
        $listing = Listing::create(array_merge($request->validated(), ['user_id' => $request->user()->id]));

        return $this->successResponse(ListingTransformer::toArray($listing), 201);
    }

    /**
     * Метод для получения информации об объявлении
     *
     * @param Listing $listing
     * @return JsonResponse
     */
    #[PathGet('show', '/v1/listings/{listing}', 'Получение информации об объявлении', ['Объявления'])]
    #[ParameterInt('show', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
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
    #[PathPost('update', '/v1/listings/{listing}/update', 'Обновление объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('update', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
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
        if ($listing->user_id != $request->user()->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        $listing->update($request->validated());

        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    /**
     * Метод для удаления объявления
     *
     * @param Request $request
     * @param Listing $listing
     * @return JsonResponse
     */
    #[PathPost('destroy', '/v1/listings/{listing}/delete', 'Удаление объявления', ['Объявления'], ['auth'])]
    #[ParameterInt('destroy', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[ResponseSuccess(204)]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function destroy(Request $request, Listing $listing): JsonResponse
    {
        if ($listing->user_id != $request->user()->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        $listing->delete();

        return $this->successResponse([]);
    }
}
