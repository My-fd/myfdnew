<!-- resources/views/index.blade.php -->

@extends('web.base')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form name="register" id="register" class="form-publish" action="https://my-fd.ru/index.php" method="post">
                        <input type="hidden" name="octoken" value="soevqmk7mzaj">
                        <input type="hidden" name="page" value="register">
                        <input type="hidden" name="action" value="register_post">

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input id="name" type="text" name="s_name" value="" placeholder="Имя *" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" name="s_email" value="" placeholder="E-mail *" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" name="s_password" value="" placeholder="Пароль *" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" name="s_password2" value="" placeholder="Повторите пароль *" class="form-control">
                        </div>

                        <div class="hybrid_login">
                            <a href="https://my-fd.ru/index.php?login=Vkontakte" class="hybrid_btn Vkontakte"><i class="fa fa-vk"></i></a>
                            <a href="https://my-fd.ru/index.php?login=Yandex" class="hybrid_btn Yandex"><i class="fa fa-envelope"></i></a>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <div class="h-captcha" data-sitekey="47616d76-01d8-4769-b99a-3fe9ec9a2aea">
                                    <iframe src="https://newassets.hcaptcha.com/captcha/v1/fd00b2a/static/hcaptcha.html#frame=checkbox&amp;id=0vbz8g2bvot&amp;host=my-fd.ru&amp;sentry=true&amp;reportapi=https%3A%2F%2Faccounts.hcaptcha.com&amp;recaptchacompat=true&amp;custom=false&amp;hl=ru&amp;tplinks=on&amp;sitekey=47616d76-01d8-4769-b99a-3fe9ec9a2aea&amp;theme=light&amp;origin=https%3A%2F%2Fmy-fd.ru" tabindex="0" frameborder="0" scrolling="no" title="Виджет с флажком для проверки безопасности hCaptcha" data-hcaptcha-widget-id="0vbz8g2bvot" data-hcaptcha-response="" style="width: 303px; height: 78px; overflow: hidden;"></iframe>
                                    <textarea id="g-recaptcha-response-0vbz8g2bvot" name="g-recaptcha-response" style="display: none;"></textarea>
                                    <textarea id="h-captcha-response-0vbz8g2bvot" name="h-captcha-response" style="display: none;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
