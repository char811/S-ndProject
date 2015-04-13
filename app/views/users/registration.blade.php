@extends('layout')


@section('content')
<div class="ui-content" data-role="main">

    <div id="add-form">
    {{Form::open(array('url'=>action('UsersController@store'), 'role'=>'form', 'method'=>'post',
    'class' => 'form-horizontal registrationForm', 'data-ajax' => "false")) }}

    @if(Session::has('message'))
    <script type="text/javascript">
        $.growl.notice({message: "Данные успешно занесены в базу данных..." });
    </script>
    @endif

    <div class="form-group">
        <label for="username">Имя</label>
            {{ Form::text('username', null, array('class' => 'form-control','placeholder' => 'Имя')) }}
    </div>
    @if (!$errors->isEmpty())
    @if($errors->first('username'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('username') }}</p>
    </div>
    @endif
    @endif
    <div class="form-group">
        <label for="email">Эмейл</label>
            {{ Form::email('email', null, array('class' => 'form-control','placeholder' => 'Эмейл')) }}
    </div>
    @if (!$errors->isEmpty())
    @if($errors->first('email'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('email') }}</p>
    </div>
    @endif
    @endif
    <div class="form-group">
        <label for="password">Пароль</label>
            {{ Form::password('password', array('class' => 'form-control','placeholder' => 'Пароль')) }}
    </div>
    @if (!$errors->isEmpty())
    @if($errors->first('password'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('password') }}</p>
    </div>
    @endif
    @endif
    <div class="form-group">
        <label for="password_confirmation">Повторите ваш </br> пароль</label>
            {{ Form::password('password_confirmation', array('class' => 'form-control','placeholder' => 'Пароль')) }}
    </div>
    @if (!$errors->isEmpty())
    @if($errors->first('password_confirmation'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('password_confirmation') }}</p>
    </div>
    @endif
    @endif
    <div class="form-group">
            {{ Form::submit('Отправить', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div>
    {{Form::close()}}
</div>
</div>
@stop