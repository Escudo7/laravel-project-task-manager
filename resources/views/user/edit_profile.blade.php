@extends('layouts.app')

@section('header')
{{ __('users.edit.header', ['name' => $user->name]) }}
@endsection

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
                <div class="card-header bg-secondary text-white text-center pt-3 pb-1">
                    <h5>
                        {{ __('Please fill in the following form') }}
                    </h5>    
                </div>

                <div class="card-body">
                    {{ Form::model($user, [
                        'url' => route('users.update', $user),
                        'method' => 'PATCH']) }}
                        {{ Form::hidden('type', 'updateProfile') }}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Login (NicName)') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small id="nameHelpBlock" class="form-text text-muted">
                                    {{ __('Required field') }}
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small id="emailHelpBlock" class="form-text text-muted">
                                    {{ __('Required field') }}е
                                </small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') ?? $user->firstname }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') ?? $user->lastname }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('Sex') }}</label>
                            <div class="col-md-6">
                            <select class="form-control" id="sex" name="sex">
                                <option value="">{{ __('not selected') }}</option>
                                    @if ($user->sex == 'male')
                                        <option selected value="male">{{ __('male') }}</option>
                                        <option value="female">{{ __('female') }}</option>
                                    @elseif ($user->sex == 'female')
                                        <option value="male">{{ __('male') }}</option>
                                        <option selected value="female">{{ __('female') }}</option>
                                    @else
                                        <option value="male">{{ __('male') }}</option>
                                        <option value="female">{{ __('female') }}</option>
                                    @endif
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Birthday') }}</label>

                            <div class="col-md-2">
                                <input id="birth_day" type="text" class="form-control" name="birth_day" value="{{ old('birth_day') ?? $user->birth_day }}" placeholder="{{ __('Day') }}">
                                @error('birth_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                            <div class="col-md-2">
                                <input id="birth_month" type="text" class="form-control" name="birth_month" value="{{ old('birth_month') ?? $user->birth_month }}" placeholder="{{ __('Month') }}">
                            </div>
                            <div class="col-md-2">
                                <input id="birth_year" type="text" class="form-control" name="birth_year" value="{{ old('birth_year') ?? $user->birth_year }}" placeholder="{{ __('Year') }}">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="country" value="{{ old('country') ?? $user->country }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" value="{{ old('city') ?? $user->city }}">
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-secondary">
                                    {{ __('Save changes') }}
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