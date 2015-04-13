@extends('layout')


@section('content')
<div class="ui-content" data-role="main">
@if(count($messages))
@foreach($messages as $message)
    <div style="text-align:center;">
       <p><b>{{ $message }}</b></p>
    </div>
@endforeach
@endif

    <ul id="progress" class="ui-listview" data-autodividers="true" data-inset="true">
        @foreach($sections as $section=>$val)
        <li>
            <a class="ui-btn ui-icon-plus" href="#" onclick="article('{{$section}}')">
                <span id="{{$section}}" class="arta glyphicon glyphicon-arrow-down"></span>
                {{{ $val }}}
              </a>
            <span data-info="{{$section}}" class="for_show ui-li-count ui-body-inherit" style="display: none">
        <span class="badge badge-info" style="align: right" data-info="{{$section}}"></span>
</span>
        </li>
        <p id="{{$section}}" class="article_show">

        </p>
        @endforeach
    </ul>
</div>
@stop