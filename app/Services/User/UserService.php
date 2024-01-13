<?php
namespace App\Services\User;

use App\Enums\LogoutFlagEnum;
use App\Helpers\GenerateHelper;
use App\Helpers\RedisHelper;
use App\Mail\EmailVerify;
use App\Models\User;
use App\Services\Exceptions\ApiAuthException;
use App\Services\Exceptions\UserSaveException;
use App\Services\User\Exceptions\UserAlreadyVerifiedException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Серив для работы с пользователями
 */
class UserService
{
    private RedisHelper $redis;

    public function __construct(RedisHelper $redis)
    {
        $this->redis = $redis;
    }

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

        $this->beginVerifyEmail($user);

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

        $token = $user->createToken('auth-token')->plainTextToken;

        return [$user, $token];
    }

    /**
     * Выход из системы
     *
     * @param User           $user
     * @param LogoutFlagEnum $flag
     * @return int
     */
    public function logoutApi(User $user, LogoutFlagEnum $flag): int
    {
        return match ($flag) {
            LogoutFlagEnum::All   => $user->tokens()->delete(),
            LogoutFlagEnum::This  => (int)$user->currentAccessToken()->delete(),
            LogoutFlagEnum::Other => $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete(),
        };
    }

    /**
     * Начало подтверждения email
     *
     * @param User $user
     * @return void
     */
    public function beginVerifyEmail(User $user): void
    {
        $token = GenerateHelper::newToken();

        $this->redis->set($token, $user->id, 3600);

        Mail::to($user->email)->send(new EmailVerify($user, $token));
    }

    /**
     * Подтверждение email
     *
     * @param string $token
     * @return bool
     * @throws NotFoundResourceException|UserAlreadyVerifiedException
     */
    public function endVerifyEmail(string $token): bool
    {
        /** @var User $user */
        $user = User::query()->where('id', '=', $this->redis->get($token))->first();

        if (!$user) return throw new NotFoundResourceException();
        if ($user->email_verified_at) return throw new UserAlreadyVerifiedException();

        $user->email_verified_at = Carbon::now();

        return $user->save();
    }
}
