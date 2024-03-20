@extends('adminlte::page')

@section('title', 'Dashboard')

@section('usermenu_header')
    <h1>H</h1>
@stop

@section('usermenu_body')
    <h1>Dev</h1>
@stop

@section('content_top_nav_left')
    <h1>H</h1>
@stop

@section('content_top_nav_right')
    <h1>Dev</h1>
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <div className="alert alert-success " id="example"></div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

    @vitereactrefresh
    @vite(['resources/sass/app.scss', 'resources/js/app.ccs', 'resources/js/app.js'])
{{--    @livewireStyles--}}

@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
