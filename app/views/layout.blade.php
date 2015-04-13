<!DOCTYPE html>
<html class="ui-mobile">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Site</title>

        @section('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/script/bootstrapvalidator/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="/public/script/jquerygrowl/stylesheets/jquery.growl.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="/public/script/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
        <!-- DataTables JS -->
        {{ HTML::script(URL::asset('script/jquery-2.1.1.js')) }}
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

        <script type="text/javascript" src="/public/script/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>

        <script type="text/javascript" src="/public/script/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="/public/script/bootstrapvalidator/src/js/language/ru_RU.js"></script>
        <script type="text/javascript" src="/public/script/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
        {{ HTML::script(URL::asset('script/bootstrap-table.js')) }}
        {{ HTML::script(URL::asset('script/jquerygrowl/javascripts/jquery.growl.js')) }}

        {{ HTML::script(URL::asset('script/tooltip.js')) }}
        {{ HTML::script(URL::asset('script/bootstrap-confirmation.js')) }}
        {{ HTML::script(URL::asset('script/jquery.popconfirm.js')) }}
        {{ HTML::script(URL::asset('script/tik.js')) }}
        {{ HTML::script(URL::asset('script/mask.js')) }}


        <script>
            var check="{{ route('index') }}";
        </script>
    </head>

    <body class="ui-mobile-viewport ui-overlay-a">
    <div class="ui-header ui-bar-a ui-header-fixed slidedown ui-panel-fixed-toolbar" data-theme="a" data-position="fixed" data-role="header" role="banner">
        <h1 class="ui-title" role="heading" aria-level="1">Site</h1>
        @if(Auth::check())
            <a class="ui-link ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-shadow ui-corner-all" data-iconpos="notext" data-icon="bars" href="#nav-panel" data-role="button" role="button">Menu</a>
        @endif
            <a class="ui-link ui-btn-right ui-btn ui-icon-gear ui-btn-icon-notext ui-shadow ui-corner-all" data-iconpos="notext" data-icon="gear" href="#add-form" data-role="button" role="button">Add</a>
        </div>

        <div id="nav-panel"
             class="ui-panel ui-panel-position-left ui-panel-display-overlay ui-body-b ui-panel-animate ui-panel-closed" data-theme="b" data-display="overlay" data-role="panel">
            <div class="ui-panel-inner">
                <ul class="ui-listview" data-role="listview">
                    <li class="ui-first-child">
                        <a href="/">Сайт</a>
                    </li>
                    <li>
                        <a href="{{ action('ArticlesController@favorite') }}">Избранное</a>
                    </li>
                    <li>
                        <a href="{{ action('ArticlesController@show') }}">Прочитанное</a>
                    </li>
                    <li>
                        <a href="{{ action('SectionsController@index') }}">Добавить раздел</a>
                    </li>
                    </br>
                    <li data-icon="delete">
                        <a href="#" data-rel="close">Отмена</a>
                    </li>
                </ul>
            </div>
        </div>

        @if(Auth::check())
        <div data-role="panel" data-position="right" data-position-fixed="true" data-display="overlay" data-theme="a"
             id="add-form">
            <h3>{{ Auth::user()->username }}</h3>

            <form action="{{ action('UsersController@getLogout') }} " method="post"  data-ajax="false">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="ui-grid-a">
                    <div class="ui-block-a"><a href="#" data-rel="close"
                                               class="ui-btn ui-shadow ui-corner-all ui-btn-b ui">Отмена</a></div>
                    <div class="ui-block-b"><input type="submit" value="Выйти"
                                                   class="ui-btn ui-shadow ui-corner-all ui-btn-a ui-mini"/></div>
                </div>
            </form>
        </div>
        @endif

        @if(!Auth::check())
         <div data-role="panel" data-position="right" data-position-fixed="true" data-display="overlay" data-theme="a"
             id="add-form">
            <form action="{{ action('UsersController@login') }}" method="post" data-ajax="false">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3>Логин</h3>
                <label for="name">Имя:</label>
                <input name="username" id="name" value="" data-clear-btn="true" autocomplete="off" data-mini="true" type="text">
                <label for="password">Пароль:</label>
                <input name="password" id="password" value="" data-clear-btn="true" autocomplete="off" data-mini="true"
                       type="password">
                <label>
                    <input name="login" id="log" type="checkbox" value="1" data-mini="true">Запомнить?
                </label>

                <div class="ui-grid-a">
                    <div class="ui-block-a"><a href="#" data-rel="close"
                                               class="ui-btn ui-shadow ui-corner-all ui-btn-b ui">Отмена</a></div>
                    <div class="ui-block-b"><input id="loginMy" type="submit" value="Вход"
                                                   class="ui-btn ui-shadow ui-corner-all ui-btn-a ui-mini" /></div>
                </div>
            </form>
             <a href="{{ action('UsersController@registration') }}">Регистрация</a>
             <br />
             <form id="reg" action="{{ action('UsersController@loginWithGoogle') }}" data-ajax="false">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                 <a title="Войти с Гугла" href="#" onclick="$('#reg').submit();">
                     <img src="/public/styles/google.png" style="height: 35px; width: 35px"/>
                 </a>
             </form>
        </div>
        @endif


    @yield('content')


    </body>
</html>