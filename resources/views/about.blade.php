@extends('layouts.app')

@section('content')
<div id="app">
    <about-component :about-content="{{ json_encode($aboutContent) }}"></about-component>
</div>
@endsection 