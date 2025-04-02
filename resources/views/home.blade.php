@extends('layouts.app')

@section('content')
<div id="app">
    <home-component 
        :testimonials="{{ json_encode($testimonials) }}"
        :hero-content="{{ json_encode($heroContent) }}"
    ></home-component>
</div>
@endsection 