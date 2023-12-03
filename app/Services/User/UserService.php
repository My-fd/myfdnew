<?php
namespace App\Services\User;

use App\Enums\LogoutFlagEnum;
use App\Models\User;
use App\Services\Exceptions\ApiAuthException;
use App\Services\Exceptions\UserSaveException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Серив для работы с пользователями
 */
class UserService
{
    /**
     * Регистрация пользователя
     *
     * @param User   $user
     * @param string $password
     * @return User
     * @throws UserSaveException
     */
    public function register(User $user, string $password): User
    {
        $user->password = Hash::make($password);

        if (!$user->save()) {
            Log::error('Не удалось сохранить пользователя при регистрации', [
                'user' => $user,
            ]);

            throw new UserSaveException('Ошибка сохранения при регистрации пользователя');
        }

        return $user;
    }

    /**
     * Авторизация в АПИ
     *
     * @param string $login
     * @param string $password
     * @return array
     * @throws ApiAuthException
     */
    public function authApi(string $login, string $password): array
    {
        /** @var User $user */
        $user = User::query()->where('email', $login)->orWhere('nickname', $login)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new ApiAuthException();
        }

        return $this->loginApi($user);
    }

    public function loginApi(User $user): array
    {
        $token = $user->createToken('auth-token')->plainTextToken;

        return [$user, $token];
    }

    public function logoutApi(User $user, LogoutFlagEnum $flag): int
    {
        return match ($flag) {
            LogoutFlagEnum::All   => $user->tokens()->delete(),
            LogoutFlagEnum::This  => (int)$user->currentAccessToken()->delete(),
            LogoutFlagEnum::Other => $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete(),
        };
    }
}
