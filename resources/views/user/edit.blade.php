@extends('layouts.app')

@section('header', 'редактирование профиля')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white text-center big-text">Заполните, пожалуйста, следующую форму</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Login (псевдоним)</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Ваш пароль должен состоять из не менее чем 8 символов.
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">Имя</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Пол</label>

                            <div class="form-check form-check-inline col-md-2">
                                <input class="form-check-input" type="radio" name="sex" id="sex1" value="мужской">
                                <label class="form-check-label" for="sex1">Мужской</label>
                            </div>
                            <div class="form-check form-check-inline col-md-2">
                                <input class="form-check-input" type="radio" name="sex" id="sex2" value="женский">
                                <label class="form-check-label" for="sex2">Женский</label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Дата рождения</label>

                            <div class="col-md-2">
                                <input id="birth_day" type="text" class="form-control" name="birth_day" value="{{ old('birth_day') }}" placeholder="День">
                            </div>
                            <div class="col-md-2">
                                <input id="birth_month" type="text" class="form-control" name="birth_month" value="{{ old('birth_month') }}" placeholder="Месяц">
                            </div>
                            <div class="col-md-2">
                                <input id="birth_year" type="text" class="form-control" name="birth_year" value="{{ old('birth_year') }}" placeholder="Год">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">Страна</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="country" value="{{ old('country') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">Город</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Зарегистрировать
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection