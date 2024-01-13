<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Подтверждение адреса электронной почты на сайте My-Fd</title>
</head>
<body>
<h1>Здравствуйте, {{ $user->name }}!</h1>

<p>Спасибо за регистрацию на нашем сайте. Пожалуйста, подтвердите свой адрес электронной почты, нажав на ссылку ниже. Ссылка действует 1 час.</p>

<a href="{{ sprintf(env('VERIFY_EMAIL_URL'), $token) }}">Подтвердить электронную почту</a>

<p>Если вы не создавали аккаунт на нашем сайте, просто проигнорируйте это письмо.</p>

<p>С уважением,<br>My-Fd</p>
</body>
</html>