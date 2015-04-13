@extends('layout')


@section('content')

<div id="ajax_content2" class="modal-content">
    <div id="new"></div>
    <input type="hidden" id="count2" name="count2" value="{{ $count }}"/>
    <div id="authors2">
        <h4 align="center"> All advertisements: {{$count}} </h4></br>
        @foreach($authors as $author)
        <div class="container" style="border: 5px solid #9e9e9e;width: 85%;">
            <h4> Title: {{{ $author->title }}}
                <div style="overflow:auto;width: 95%;height: 13%;"> Description: {{{ $author->description }}}</div>
                Name: {{{ $author->users()->first()->username }}}
            </h4>
        </div>
        </br>
        @endforeach
    </div>
</div>

@stop