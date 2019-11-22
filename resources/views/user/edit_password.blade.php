@extends('layouts.app')

@section('header', 'изменение пароля')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white text-center big-text">Заполните, пожалуйста, следующую форму</div>

                <div class="card-body">
                    {{ Form::model($user, [
                        'url' => route('users.update_password', $user),
                        'method' => 'PATCH']) }}
                    
                        @csrf

                        
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Новый пароль</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Обязательное поле. Ваш пароль должен состоять из не менее чем 8 символов
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    Обязательное поле
                                </small>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection