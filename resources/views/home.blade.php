@extends('layouts.page')

@section('title', 'AdminLTE')

@section('content')
    <div id="app">
        <shipments :shipments="{{json_encode($shipments)}}"></shipments>
    </div>
@stop