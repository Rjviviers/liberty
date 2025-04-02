@extends('layouts.app')

@section('content')
<div id="app">
    <home-component 
        :testimonials="{{ json_encode($testimonials) }}"
        :hero-content="{{ json_encode($heroContent) }}"
        :about-content="{{ json_encode($aboutContent) }}"
        :features-content="{{ json_encode($featuresContent) }}"
        :services-content="{{ json_encode($servicesContent) }}"
        :testimonials-content="{{ json_encode($testimonialsContent) }}"
        :contact-content="{{ json_encode($contactContent) }}"
    ></home-component>
</div>
@endsection 