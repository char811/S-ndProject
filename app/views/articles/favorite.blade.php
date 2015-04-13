@extends('layout')


@section('content')

<div class="ui-content" role="main">
    @if(count($messages))
    @foreach($messages as $message)
    <div style="text-align:center;">
        <p><b>{{ $message }}</b></p>
    </div>
    @endforeach
    @endif

    <form action="{{ action('ArticlesController@delFavForm') }}" method="post" data-ajax="false">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <ul id="list" class="ui-listview" data-autodividers="true" data-inset="true">
    @foreach($articles as $article=>$val)
        <li id="{{$val['id']}}" class="{{$val['id']}} ui-li-has-alt">
           <label>
            <a style="width: 100%" class="ui-btn" href="http://habrahabr.ru/{{$article}}/" data-info="{{$val['id']}}" target="_blank">
                {{{ $r=$val['name'] }}}
            </a>

                <input type="checkbox" name="fav[{{$val['id']}}]"/>
            </label>
             </li>
    @endforeach
    </ul>
    <br />
      @if(isset($r))
    <button style="width: 100%" type="submit">Удалить</button>
        @endif
    </form>

</div>



@stop