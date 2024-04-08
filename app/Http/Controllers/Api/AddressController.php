<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterInt;
use App\Openapi\Attributes\ParameterString;
use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\Tag;
use App\Services\Address\AddressService;
use App\Transformers\AddressTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Openapi\Attributes\PathPost;
use App\Openapi\Attributes\RequestFormEncoded;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;

#[Controller]
#[Tag('Адреса')]
class AddressController extends BaseApiController
{
    private AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    #[PathGet('address.index', '/v1/addresses', 'Получение списка адресов', ['Адреса'], ['auth'])]
    #[ResponseSuccess(200, ref: AddressTransformer::class)]
    #[ResponseError(500, 'Ошибка сервера')]
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(AddressTransformer::manyToArray($request->user()->addresses));
    }

    #[PathPost('address.ac', '/v1/addresses/ac', 'Автодополнение адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterString('address.ac', Parameter::IN_QUERY, 'q', 'Адрес строкой', 'Москва, Ленина 23')]
    #[ResponseSuccess(201, ref: AddressTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function ac(Request $request, AddressService $service): JsonResponse
    {
        return $this->successResponse($service->ac($request->get('q')));
    }

    #[PathPost('address.store', '/v1/addresses/store', 'Создание адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('country', 'Страна', 'Россия', parent: 'request')]
    #[PropertyString('city', 'Город', 'Москва', parent: 'request')]
    #[PropertyString('street', 'Улица', 'Примерная', parent: 'request')]
    #[PropertyString('house_number', 'Номер дома', '1', parent: 'request')]
    #[PropertyString('floor', 'Этаж', '5', false, parent: 'request')]
    #[PropertyString('zip', 'Почтовый индекс', '123456', parent: 'request')]
    #[PropertyString('additional_info', 'Дополнительная информация', 'Квартира 10', false, parent: 'request')]
    #[ResponseSuccess(201, ref: AddressTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function store(AddressRequest $request): JsonResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        $address = $this->addressService->create($data);

        return $this->successResponse(AddressTransformer::toArray($address), 201);
    }

    #[PathGet('address.show', '/v1/addresses/{address}', 'Получение адреса по ID', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('address.show', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
    #[ResponseSuccess(200, ref: AddressTransformer::class)]
    #[ResponseError(404, 'Адрес не найден', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function show(Address $address): JsonResponse
    {
        return $this->successResponse(AddressTransformer::toArray($address));
    }

    #[PathPost('address.update', '/v1/addresses/{address}/update', 'Обновление адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('address.update', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
    #[PropertyString('country', 'Страна', 'Россия', parent: 'request')]
    #[PropertyString('city', 'Город', 'Москва', parent: 'request')]
    #[PropertyString('street', 'Улица', 'Примерная', parent: 'request')]
    #[PropertyString('house_number', 'Номер дома', '1', parent: 'request')]
    #[PropertyString('floor', 'Этаж', '5', false, parent: 'request')]
    #[PropertyString('zip', 'Почтовый индекс', '123456', parent: 'request')]
    #[PropertyString('additional_info', 'Дополнительная информация', 'Квартира 10', false, parent: 'request')]
    #[ResponseSuccess(200, ref: AddressTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(404, 'Адрес не найден', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function update(AddressRequest $request, Address $address): JsonResponse
    {
        if ($address->user_id = $request->user()->id) {
            $updatedAddress = $this->addressService->update($address, $request->validated());
        } else {
            return $this->errorResponse('Не доступно.', 403);
        }

        return $this->successResponse(AddressTransformer::toArray($updatedAddress));
    }

    #[PathPost('address.delete', '/v1/addresses/{address}/delete', 'Удаление адреса', ['Адреса'], ['auth'])]
    #[ParameterInt('address.delete', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
    #[ResponseSuccess(204)]
    #[ResponseError(404, 'Адрес не найден', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function delete(Request $request, Address $address): JsonResponse
    {
        if ($address->user_id = $request->user()->id) {
            $this->addressService->delete($address);
        } else {
            return $this->errorResponse('Не доступно.', 403);
        }

        return $this->successResponse([],204);
    }
}
