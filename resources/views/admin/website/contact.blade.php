@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Contact Section</h2>
        <p class="text-gray-600">Edit the contact section displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}#contact" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        <i class="fas fa-external-link-alt mr-1"></i> View Section
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
// Fallback content if the $content variable is not set due to database issues
$fallbackContent = [
    'title' => 'Contact Us',
    'subtitle' => 'Get in touch with Danie de Villiers',
    'address' => '123 Main Street, Pretoria, South Africa, 0001',
    'email' => 'info@daniedevilliers.co.za',
    'phone' => '+27 123 456 789',
    'hours_title' => 'Operating Hours',
    'hours_weekdays' => 'Monday - Friday: 8:00 AM - 6:00 PM',
    'hours_saturday' => 'Saturday: 9:00 AM - 2:00 PM',
    'hours_sunday' => 'Sunday: Closed',
    'form_title' => 'Send a Message',
    'form_subtitle' => 'Fill out the form below and we will get back to you as soon as possible.',
    'form_button_text' => 'Send Message',
    'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14345.060030342745!2d28.19360515!3d-25.7478676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e95619cbec65033%3A0xf66a9ebebbceae77!2sPretoria%2C%20South%20Africa!5e0!3m2!1sen!2sus!4v1621500458031!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
    'booking_title' => 'Book an Appointment',
    'booking_text' => 'Ready to schedule your consultation? Click the button below to book your appointment.',
    'booking_button_text' => 'Book Appointment'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<form action="{{ route('admin.website.contact.update') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Section Headers</h3>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Section Title*</label>
                <input type="text" id="title" name="title" value="{{ old('title', $displayContent['title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Section Subtitle*</label>
                <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $displayContent['subtitle']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-4">Contact Information</h3>
            
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                <input type="text" id="address" name="address" value="{{ old('address', $displayContent['address']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                <input type="email" id="email" name="email" value="{{ old('email', $displayContent['email']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $displayContent['phone']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
        
        <!-- Operating Hours -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Operating Hours</h3>
            
            <div class="mb-4">
                <label for="hours_title" class="block text-sm font-medium text-gray-700 mb-1">Hours Section Title*</label>
                <input type="text" id="hours_title" name="hours_title" value="{{ old('hours_title', $displayContent['hours_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="hours_weekdays" class="block text-sm font-medium text-gray-700 mb-1">Weekday Hours*</label>
                <input type="text" id="hours_weekdays" name="hours_weekdays" value="{{ old('hours_weekdays', $displayContent['hours_weekdays']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="hours_saturday" class="block text-sm font-medium text-gray-700 mb-1">Saturday Hours*</label>
                <input type="text" id="hours_saturday" name="hours_saturday" value="{{ old('hours_saturday', $displayContent['hours_saturday']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="hours_sunday" class="block text-sm font-medium text-gray-700 mb-1">Sunday Hours*</label>
                <input type="text" id="hours_sunday" name="hours_sunday" value="{{ old('hours_sunday', $displayContent['hours_sunday']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-700 mt-6 mb-4">Appointment Booking</h3>
            
            <div class="mb-4">
                <label for="booking_title" class="block text-sm font-medium text-gray-700 mb-1">Booking Title*</label>
                <input type="text" id="booking_title" name="booking_title" value="{{ old('booking_title', $displayContent['booking_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="booking_text" class="block text-sm font-medium text-gray-700 mb-1">Booking Text*</label>
                <textarea id="booking_text" name="booking_text" rows="2" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('booking_text', $displayContent['booking_text']) }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="booking_button_text" class="block text-sm font-medium text-gray-700 mb-1">Booking Button Text*</label>
                <input type="text" id="booking_button_text" name="booking_button_text" value="{{ old('booking_button_text', $displayContent['booking_button_text']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Contact Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Contact Form</h3>
            
            <div class="mb-4">
                <label for="form_title" class="block text-sm font-medium text-gray-700 mb-1">Form Title*</label>
                <input type="text" id="form_title" name="form_title" value="{{ old('form_title', $displayContent['form_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="form_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Form Subtitle*</label>
                <textarea id="form_subtitle" name="form_subtitle" rows="2" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('form_subtitle', $displayContent['form_subtitle']) }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="form_button_text" class="block text-sm font-medium text-gray-700 mb-1">Form Button Text*</label>
                <input type="text" id="form_button_text" name="form_button_text" value="{{ old('form_button_text', $displayContent['form_button_text']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
        
        <!-- Google Map -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Google Map</h3>
            
            <div class="mb-4">
                <label for="map_embed" class="block text-sm font-medium text-gray-700 mb-1">Map Embed Code*</label>
                <textarea id="map_embed" name="map_embed" rows="6" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono text-sm" required>{{ old('map_embed', $displayContent['map_embed']) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Paste your Google Maps embed code here. Make sure to include the full iframe tag.</p>
            </div>
            
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Map Preview</h4>
                <div class="border border-gray-300 rounded overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        {!! $displayContent['map_embed'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-save mr-1"></i> Update Contact Section
        </button>
    </div>
</form>
@endsection 