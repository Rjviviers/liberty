@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Hero Section</h2>
        <p class="text-gray-600">Edit the hero section content displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        <i class="fas fa-external-link-alt mr-1"></i> View Website
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
    'heading' => 'Professional Biokinetics for Total Wellness',
    'subheading' => 'Restore Movement. Regain Life.',
    'description' => 'Danie de Villiers offers personalized biokinetic treatments to improve your movement, fitness, and quality of life. Experience the difference with evidence-based rehabilitation.',
    'image' => '/assets/Danie De Villiers.png',
    'button_text' => 'Book Appointment',
    'admin_button_text' => 'Admin Login'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Preview -->
        <div class="w-full md:w-2/5">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Preview</h3>
            <div class="border rounded-lg p-4 bg-gray-50 relative overflow-hidden" style="min-height: 400px;">
                <div class="mb-3">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $displayContent['heading'] }}</h1>
                    <h2 class="text-xl text-gray-700 mb-2">{{ $displayContent['subheading'] }}</h2>
                    <p class="text-gray-600 mb-4">{{ $displayContent['description'] }}</p>
                    
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-1 bg-blue-500 text-white rounded">{{ $displayContent['button_text'] }}</button>
                        <button class="px-4 py-1 border border-gray-300 text-gray-700 rounded">{{ $displayContent['admin_button_text'] }}</button>
                    </div>
                </div>
                
                <div class="mt-4">
                    <img src="{{ $displayContent['image'] }}" 
                         alt="Hero image" 
                         class="max-w-full h-auto rounded object-cover"
                         style="max-height: 200px;">
                </div>
            </div>
        </div>
        
        <!-- Edit Form -->
        <div class="w-full md:w-3/5">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit Content</h3>
            
            <form action="{{ route('admin.website.hero.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="heading" class="block text-sm font-medium text-gray-700 mb-1">Heading*</label>
                    <input type="text" id="heading" name="heading" value="{{ old('heading', $displayContent['heading']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="subheading" class="block text-sm font-medium text-gray-700 mb-1">Subheading*</label>
                    <input type="text" id="subheading" name="subheading" value="{{ old('subheading', $displayContent['subheading']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $displayContent['description']) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Hero Image</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ $displayContent['image'] }}" alt="Current hero image" class="h-16 w-auto rounded">
                        <input type="file" id="image" name="image" 
                               class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image. Maximum size: 2MB.</p>
                </div>
                
                <div class="mb-4">
                    <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Main Button Text*</label>
                    <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $displayContent['button_text']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="admin_button_text" class="block text-sm font-medium text-gray-700 mb-1">Admin Button Text*</label>
                    <input type="text" id="admin_button_text" name="admin_button_text" value="{{ old('admin_button_text', $displayContent['admin_button_text']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        <i class="fas fa-save mr-1"></i> Update Hero Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- About how content is managed -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-blue-800 mb-2">About Content Management</h3>
    <p class="text-blue-600">
        Changes made here will be reflected on the website's homepage. The system stores each piece of content separately, 
        making it easy to update specific sections without affecting others. All content is versioned and can be reverted if needed.
    </p>
</div>
@endsection 