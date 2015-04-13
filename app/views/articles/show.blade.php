@extends('layout')


@section('content')
<div class="ui-content" data-role="main">
@if(count($messages))
@foreach($messages as $message)
<div style="text-align:center;">
    {{ $message }}
</div>
@endforeach
@endif
<div style="text-align:center;">
    <p><b>Прочитанные статьи как по волшебству пропадают спустя сутки...избежать чего можно добавив в избранное</b></p>
    </br>
</div>
    <ul class="ui-listview" data-autodividers="true" data-inset="true">
        @foreach($sections as $section=>$val)
        <li>
            <a id="paddling" class="ui-btn ui-icon-plus" href="#" onclick="articleRead('{{$section}}')">
                <span id="{{$section}}" class="sect glyphicon glyphicon-arrow-down"></span>
                {{{ $val }}}
            </a>
        </li>
        <div id="arts_show" class="{{$section}}">
    @foreach($articles as $article=>$val_art)
        @if($val_art['section']==$section)
<li class="ui-li-has-alt">
<a id="art_link" href="http://habrahabr.ru/{{$article}}/" class="ui-btn" data-info="{{$val_art['id']}}" target="_blank" >
    {{{ $val_art['name'] }}}
</a>
<a id="favorite" href="" class="ui-btn" title="Добавить в избранное"  onclick="tab({{$val_art['id']}})">
<span id="{{$val_art['id']}}sec" style="text-align: center" class="glyphicon glyphicon-star-empty"></span>
    </a>
</li>
       @endif
@endforeach
        </div>
        @endforeach
    </ul>
    </div>

@stop