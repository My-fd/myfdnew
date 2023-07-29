<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogoutFlagEnum;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Openapi\Attributes\Additional\Controller;
use App\Openapi\Attributes\Parameter;
use App\Openapi\Attributes\ParameterString;
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
use Illuminate\Support\Facades\Log;

#[Controller]
#[Tag('Пользователи')]
class UserController extends BaseApiController
{
    /**
     * Метод для авторизации пользователя
     *
     * @param AuthRequest $request
     * @param UserService $service
     * @return JsonResponse
     */
    #[PathPost('login', '/v1/login', 'Метод авторизации пользователя', ['Пользователи'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('login', 'Эл. адрес пользователя', 'pupkin@kostylworks.ru', parent: 'request')]
    #[PropertyString('password', 'Пароль', 'myGoodPassword', parent: 'request')]
    #[PropertyString('invitation_token', 'Токен приглашения', 'xdloswoiosdiklskls', true, parent: 'request')]
    #[ResponseSuccess(200, vRef: UserTransformer::class)]
    #[PropertyString('token', 'Токен авторизации', '1|someToken', parent: 'success.data')]
    #[ResponseError(400, 'Ошибка пользователя', 'Bad Request')]
    #[ResponseError(423, 'Ресурс заблокирован', 'Locked')]
    #[ResponseError(500, 'Ошибка сервера')]
    public function login(AuthRequest $request, UserService $service): JsonResponse
    {
        try {
            [$user, $token] = $service->authApi($request->get('email'), $request->get('password'));
        } catch (ApiAuthException) {
            return $this->errorResponse('Неверный логин или пароль.', 400);
        }

        return $this->successResponse(LoginTransformer::toArray($user, $token));
    }

    /**
     * Метод для выхода пользователя (удаление токена)
     *
     * @param Request     $request
     * @param UserService $service
     * @return JsonResponse
     */
    #[PathPost('logout', '/v1/logout', 'Выход пользователя из системы', ['Пользователи'], ['auth'])]
    #[ParameterString('auth.logout', Parameter::IN_QUERY, 'flag', 'Способ выхода', 'all', 'this', false, enum: LogoutFlagEnum::VALUES)]
    #[ResponseSuccess(200)]
    public function logout(Request $request, UserService $service): JsonResponse
    {
        $flag = $request->get('flag', LogoutFlagEnum::This->value);

        $service->logoutApi($request->user(), LogoutFlagEnum::from($flag));

        return $this->successResponse([]);
    }

    /**
     * Метод для регистрации нового пользователя
     *
     * @param RegisterRequest $request
     * @param UserService     $service
     * @return JsonResponse
     */
    #[PathPost('register', '/v1/register', 'Метод регистрации нового пользователя', ['Пользователи'])]
    #[RequestFormEncoded('request')]
    #[PropertyString('nickname', 'Имя пользователя', 'John Doe', parent: 'request')]
    #[PropertyString('email', 'Эл. адрес пользователя', 'johndoe@example.com', parent: 'request')]
    #[PropertyString('password', 'Пароль', 'myGoodPassword', parent: 'request')]
    #[PropertyString('password_confirmation', 'Подтверждение пароля', 'myGoodPassword', parent: 'request')]
    #[ResponseSuccess(200)]
    #[ResponseError(400, 'Ошибка валидации', 'Bad Request')]
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
            [$user, $token] = $service->authApi($user, $request->get('password'));
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
