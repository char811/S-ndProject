@extends('layout')


@section('content')
<div data-role="main" class="ui-content">

<form action="{{action('SectionsController@store')}}" method="post" data-ajax="false">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table data-role="table" data-mode="columntoggle" class="ui-responsive ui-shadow">
                @foreach($temp_last as $key=>$val)
                @if($val['checked']==1)
                <label>
                    <input type="checkbox" name="link[{{$val['name']}}]" checked/>
                    {{$val['link']}}
                </label>
                @else
                <label>
                    <input type="checkbox" name="link[{{$val['name']}}]">
                    {{$val['link']}}
                </label>
                @endif
                @endforeach
            </table>


    <div style="text-align: center;">
        <input type="submit" value="Сохранить" class="btn"/>
    </div>

</form>


</div>

@stop