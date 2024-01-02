<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogoutFlagEnum;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterString;
use App\Openapi\Attributes\PathGet;
use App\Openapi\Attributes\Tag;
use App\Services\Exceptions\ApiAuthException;
use App\Services\Exceptions\UserSaveException;
use App\Services\User\UserService;
use App\Transformers\LoginTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Openapi\Attributes\PathPost;
use App\Openapi\Attributes\PropertyString;
use App\Openapi\Attributes\RequestFormEncoded;
use App\OpenapiCustom\ResponseError;
use App\OpenapiCustom\ResponseSuccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

#[Controller]
#[Tag('Пользователи')]
class UserController extends BaseApiController
{
    #[PathPost('login', '/v1/login', 'Метод авторизации пользователя', ['Пользователи'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('login', 'Эл. адрес пользователя', 'johndoe@mail.ru', parent: 'request')]
    #[PropertyString('password', 'Пароль', 'password', parent: 'request')]
    #[ResponseSuccess(200, vRef: UserTransformer::class)]
    #[PropertyString('token', 'Токен авторизации', '1|someToken', parent: 'success.data')]
    #[ResponseError(400, 'Ошибка пользователя', 'Bad Request')]
    #[ResponseError(423, 'Ресурс заблокирован', 'Locked')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function login(AuthRequest $request, UserService $service): JsonResponse
    {
        try {
            [$user, $token] = $service->authApi($request->get('login'), $request->get('password'));
        } catch (ApiAuthException) {
            return $this->errorResponse('Неверный логин или пароль.', 400);
        }

        return $this->successResponse(LoginTransformer::toArray($user, $token));
    }

    #[PathGet('profile', '/v1/profile', 'Профиль пользователя', ['Пользователи'], ['auth'])]
    #[ResponseSuccess(200, vRef: UserTransformer::class)]
    #[ResponseError(404, 'Не найден', 'Not found')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function profile(Request $request): JsonResponse
    {
        return $this->successResponse(UserTransformer::toArray($request->user()));
    }

    #[PathPost('changeProfile', '/v1/changeProfile', 'Смена профиля пользователя', ['Пользователи'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('email', 'Эл. адрес пользователя', 'johndoe@mail.ru', parent: 'request')]
    #[PropertyString('name', 'Имя', 'Иван', parent: 'request')]
    #[PropertyString('surname', 'Фамилия', 'Иванович', parent: 'request')]
    #[PropertyString('patronymic', 'Отчество', 'Иванов', parent: 'request')]
    #[PropertyString('about', 'О себе', 'Родился в селе Дураков', parent: 'request')]
    #[PropertyString('phone', 'Телефон', '9876543210', parent: 'request')]
    #[PropertyString('country_code', 'Код страны', '+7', parent: 'request')]
    #[ResponseSuccess(200, vRef: UserTransformer::class)]
    #[PropertyString('token', 'Токен авторизации', '1|someToken', parent: 'success.data')]
    #[ResponseError(400, 'Ошибка пользователя', 'Bad Request')]
    #[ResponseError(423, 'Ресурс заблокирован', 'Locked')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function changeProfile(ChangeProfileRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $user->email        = $request->get('email', $user->email);
        $user->name         = $request->get('name', $user->name);
        $user->surname      = $request->get('surname', $user->surname);
        $user->patronymic   = $request->get('patronymic', $user->patronymic);
        $user->about        = $request->get('about', $user->about);
        $user->phone        = $request->get('phone', $user->phone);
        $user->country_code = $request->get('country_code', $user->country_code);

        if ($user->save()) {
            return $this->successResponse(UserTransformer::toArray($user));
        }

        return $this->errorResponse('Не удалось сохранить пользователя', 500);
    }

    #[PathPost('changePassword', '/v1/changePassword', 'Смена пароля', ['Пользователи'], ['auth'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('password', 'Пароль', 'password', parent: 'request')]
    #[PropertyString('password_confirmation', 'Пароль', 'password', parent: 'request')]
    #[ResponseSuccess(200, vRef: UserTransformer::class)]
    #[PropertyString('token', 'Токен авторизации', '1|someToken', parent: 'success.data')]
    #[ResponseError(400, 'Ошибка пользователя', 'Bad Request')]
    #[ResponseError(422, 'Неверный пароль', 'Validation error')]
    #[ResponseError(423, 'Ресурс заблокирован', 'Locked')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (Hash::check($request->get('password'), $user->password)) {
            $user->password = Hash::make($request->get('password'));

            if ($user->save()) {
                return $this->successResponse(UserTransformer::toArray($user));
            }
        } else {
            return $this->errorResponse('Неверный пароль', 422);
        }

        return $this->errorResponse('Не удалось сохранить пользователя', 500);
    }

    #[PathPost('logout', '/v1/logout', 'Выход пользователя из системы', ['Пользователи'], ['auth'])]
    #[ParameterString('auth.logout', Parameter::IN_QUERY, 'flag', 'Способ выхода', 'all', 'this', false, enum: LogoutFlagEnum::VALUES)]
    #[ResponseSuccess(200)]
    public function logout(Request $request, UserService $service): JsonResponse
    {
        $flag = $request->get('flag', LogoutFlagEnum::This->value);

        $service->logoutApi($request->user(), LogoutFlagEnum::from($flag));

        return $this->successResponse([]);
    }

    #[PathPost('register', '/v1/register', 'Метод регистрации нового пользователя', ['Пользователи'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('nickname', 'Имя пользователя', 'John Doe', parent: 'request')]
    #[PropertyString('email', 'Эл. адрес пользователя', 'johndoe@mail.ru', parent: 'request')]
    #[PropertyString('password', 'Пароль', 'password', parent: 'request')]
    #[PropertyString('password_confirmation', 'Подтверждение пароля', 'password', parent: 'request')]
    #[ResponseSuccess(200)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
    #[ResponseError(422, 'Ошибка валидации', 'Validation Request')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function register(RegisterRequest $request, UserService $service): JsonResponse
    {
        $user           = new User();
        $user->nickname = $request->get('nickname');
        $user->email    = $request->get('email');

        try {
            $service->register($user, $request->get('password'));
        } catch (UserSaveException $e) {
            Log::error('Не удалось зарегистрировать пользователя.', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
                'user'    => $user->toArray(),
            ]);

            return $this->errorResponse('Ошибка при регистрации. Попробуйте позже.', 500);
        }

        try {
            [$user, $token] = $service->authApi($user->email, $request->get('password'));
        } catch (ApiAuthException $e) {
            Log::error('Не удалось авторизовать пользователя после регистрации.', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTrace(),
                'user'    => $user->toArray(),
            ]);

            return $this->errorResponse('Регистрация успешна, но войти не удалось. Попробуйте позже.', 500);
        }

        return $this->successResponse(LoginTransformer::toArray($user, $token));
    }
}
