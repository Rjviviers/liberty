@extends('layouts.app')

@section('content')
<div id="app">
    <home-component :testimonials="{{ json_encode($testimonials) }}"></home-component>
</div>
@endsection 