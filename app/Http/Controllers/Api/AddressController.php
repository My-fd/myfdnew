<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterInt;
use App\Openapi\Attributes\PathGet;
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

    #[PathGet('index', '/v1/addresses', 'Получение списка адресов', ['Адреса'], ['auth'])]
    #[ResponseSuccess(200, ref: AddressTransformer::class)]
    #[ResponseError(500, 'Ошибка сервера')]
    public function index(Request $request): JsonResponse
    {
        return $this->successResponse(AddressTransformer::manyToArray($request->user()->addresses));
    }

    #[PathGet('ac', '/v1/addresses/ac', 'Автодополнение адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ResponseSuccess(201, ref: AddressTransformer::class)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function ac(Request $request, AddressService $service): JsonResponse
    {
        return $this->successResponse($service->ac($request->get('q')));
    }

    #[PathPost('store', '/v1/addresses', 'Создание адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
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

    #[PathGet('show', '/v1/addresses/{address}', 'Получение адреса по ID', ['Адреса'], ['auth'])]
    #[ParameterInt('show', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
    #[ResponseSuccess(200, ref: AddressTransformer::class)]
    #[ResponseError(404, 'Адрес не найден', 'Not Found')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function show(Address $address): JsonResponse
    {
        return $this->successResponse(AddressTransformer::toArray($address));
    }

    #[PathPost('update', '/v1/addresses/{address}', 'Обновление адреса', ['Адреса'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[ParameterInt('update', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
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

    #[PathPost('delete', '/v1/addresses/{address}/delete', 'Удаление адреса', ['Адреса'], ['auth'])]
    #[ParameterInt('delete', Parameter::IN_PATH, 'address', 'ID адреса', 1, 1)]
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
