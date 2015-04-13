@extends('layout')


@section('content')
<div class="kit"></div>


@if(!Auth::check())
    {{ Form::open(array('url' => action('UsersController@login'), 'method' => 'get')) }}

    {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Имя')) }}

    {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}

    {{ Form::checkbox('remember-me', 1) }} Запомнить!

    {{ Form::submit('Вход', array('class' => 'btn btn-lg btn-primary btn-block')) }}

    {{Form::close()}}
    <a href="{{ action('UsersController@registration') }}">Регистрация</a>

@endif

@stop