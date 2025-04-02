@extends('layouts.app')

@section('content')
<div id="app">
    <services-component :content="{{ json_encode($servicesContent) }}"></services-component>
</div>
@endsection 