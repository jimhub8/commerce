@extends('layouts.temp') 
@section('content') @auth
<my-nav :user="{{ json_encode($auth_user) }}"></my-nav>
<transition name="fade">
    <router-view :user="{{ json_encode($auth_user) }}"></router-view>
</transition>
@endauth @guest
<my-nav></my-nav>
<transition name="fade">
    <router-view></router-view>
</transition>

@endguest
<my-footer></my-footer>
@endsection