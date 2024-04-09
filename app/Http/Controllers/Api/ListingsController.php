<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AttachImageRequest;
use App\Http\Requests\DetachImageRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Attribute;
use App\Models\User;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterInt;
use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\PathPost;
use App\Openapi\Attributes\PropertyArray;
use App\Openapi\Attributes\PropertyFloat;
use App\Openapi\Attributes\PropertyInt;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\RequestFormEncoded;
use App\Openapi\Attributes\Tag;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;
use App\Transformers\ListingTransformer;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreListingRequest;
use App\Models\Listing;
use Illuminate\Http\Request;

/**
 * Контроллер объявлений
 * class ListingsController
 * @package App\Http\Controllers\Api
 */
#[Controller]
#[Tag('Объявления')]
class ListingsController extends BaseApiController
{
    #[PathGet('listings.index', '/v1/listings', 'Получение списка объявлений', ['Объявления'])]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'category_id', 'ID категории')]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'user_id', 'ID пользователя')]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'search', 'Поиск по объявления')]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'from', 'Поиск по объявления после даты YYYY-MM-DD')]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'before', 'Поиск по объявления до даты YYYY-MM-DD')]
    #[ParameterInt('listings.index', Parameter::IN_QUERY, 'city', 'Поиск по городу')]
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

        if ($request->filled('user_id')) {
            if (!User::query()->where('id', '=', $request->get('user_id'))->exists()) {
                return $this->errorResponse('Такого пользователя не существует.', 404);
            }

            $query->where('user_id', '=', $request->get('user_id'));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }

        if ($request->filled('before')) {
            $query->whereDate('created_at', '<=', $request->get('before'));
        }

        if ($request->filled('city')) {
            $city = $request->input('city');

            $query->whereHas('address', function ($q) use ($city) {
                $q->where('city', 'like', '%' . $city . '%');
            });
        }

        $listings = $query->paginate(25);

        return $this->successResponse([
            'data'     => ListingTransformer::manyToArray($listings->items()),
            'page'     => $listings->currentPage(),
            'lastPage' => $listings->lastPage(),
        ]);
    }

    #[PathGet('listings.my', '/v1/listings/my', 'Получение списка моих объявлений', ['Объявления'], ['auth'])]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка запроса', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function my(Request $request): JsonResponse
    {
        $categoryId = $request->input('category_id');
        $query      = Listing::query()->where('user_id', '=', $request->user()->id);

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

    #[PathPost('store', '/v1/listings', 'Создание объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('title', 'Название объявления', 'Мой товар', parent: 'request')]
    #[PropertyString('description', 'Описание объявления', 'Описание товара', parent: 'request')]
    #[PropertyFloat('price', 'Цена', 100.0, parent: 'request')]
    #[PropertyInt('category_id', 'ID категории', 1, parent: 'request')]
    #[PropertyString('attributes[1]', 'Пара ID -> значение атрибута', 'Тональный крем', parent: 'request')]
    #[PropertyString('images[0]', 'Изображение', '/home/user/image.png', parent: 'request')]
    #[ResponseSuccess(201, ref: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function store(StoreListingRequest $request): JsonResponse
    {
        /** @var Listing $listing */
        /** @var User $user */
        $user    = $request->user();
        $listing = Listing::create(array_merge($request->validated(), ['user_id' => $user->id]));

        if ($request->filled('attributes')) {
            $attributes = $request->get('attributes');
            foreach ($attributes as $key => $attribute) {
                if (Attribute::query()->where('id', '=', $key)->exists()) {
                    $listing->attributes()->attach($key, ['value' => $attribute]);
                }
            }
        }

        if ($request->filled('address_id')) {
            if ($user->addresses->contains($request->get('address_id'))) {
                $listing->address_id = $request->get('address_id');
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $listing->images()->create(['path' => $path]);
            }
        }

        $listing->save();

        return $this->successResponse(ListingTransformer::toArray($listing), 201);
    }

    #[PathGet('show', '/v1/listings/{listing}', 'Получение информации об объявлении', ['Объявления'])]
    #[ParameterInt('show', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function show(Listing $listing): JsonResponse
    {
        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    #[PathPost('update', '/v1/listings/{listing}/update', 'Обновление объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('update', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[PropertyString('title', 'Название объявления', 'Мой товар', parent: 'request')]
    #[PropertyString('description', 'Описание объявления', 'Описание товара', parent: 'request')]
    #[PropertyFloat('price', 'Цена', 100.0, parent: 'request')]
    #[PropertyInt('category_id', 'ID категории', 1, parent: 'request')]
    #[PropertyString('attributes[1]', 'Пара ID -> значение атрибута', 'Тональный крем', parent: 'request')]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function update(UpdateListingRequest $request, Listing $listing): JsonResponse
    {
        /** @var Listing $listing */
        /** @var User $user */
        $user = $request->user();
        if ($listing->user_id != $user->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        $listing->update($request->validated());
        if ($request->filled('attributes')) {
            $attributes = $request->get('attributes');
            foreach ($attributes as $key => $attribute) {
                if (Attribute::query()->where('id', '=', $key)->exists()) {
                    $listing->attributes()->attach($key, ['value' => $attribute]);
                }
            }
        }

        if ($request->filled('address_id')) {
            if ($user->addresses->contains($request->get('address_id'))) {
                $listing->address_id = $request->get('address_id');
            }
        }

        $listing->save();

        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    #[PathPost('destroy', '/v1/listings/{listing}/delete', 'Удаление объявления', ['Объявления'], ['auth'])]
    #[ParameterInt('destroy', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[ResponseSuccess(204)]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function delete(Request $request, Listing $listing): JsonResponse
    {
        if ($listing->user_id != $request->user()->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        $listing->delete();

        return $this->successResponse([]);
    }

    #[PathPost('attach', '/v1/listings/{listing}/attach', 'Добавление изображений к объявлению', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('attach', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[PropertyString('images[0]', 'Изображение', '/home/user/image.png', parent: 'request')]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(403, 'Нет доступа', 'Forbidden')]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function attachImages(AttachImageRequest $request, Listing $listing): JsonResponse
    {
        if ($listing->user_id != $request->user()->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('listings', 'public');
                $listing->images()->create(['path' => $path]);
            }
        }

        return $this->successResponse(ListingTransformer::toArray($listing));
    }

    #[PathPost('detach', '/v1/listings/{listing}/detach', 'Удаление изображений из объявления', ['Объявления'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('detach', Parameter::IN_PATH, 'listing', 'ID объявления', 1, 1)]
    #[PropertyInt('image_ids[0]', 'Массив ID изображений для удаления', 1, parent: 'request')]
    #[ResponseSuccess(200, ref: ListingTransformer::class)]
    #[ResponseError(403, 'Нет доступа', 'Forbidden')]
    #[ResponseError(404, 'Объявление не найдено', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера', 'Internal Server Error')]
    public function detachImages(DetachImageRequest $request, Listing $listing): JsonResponse
    {
        if ($listing->user_id != $request->user()->id) {
            return $this->errorResponse('Нет доступа', 403);
        }

        $imageIds = $request->input('image_ids', []);
        if (!empty($imageIds)) {
            $listing->images()->whereIn('id', $imageIds)->delete();
        }

        return $this->successResponse(ListingTransformer::toArray($listing));
    }
}
