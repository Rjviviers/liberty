@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Services Section</h2>
        <p class="text-gray-600">Edit the services displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}#services" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
    'title' => 'Our Services',
    'button_text' => 'View All Services',
    'service1_title' => 'Rehabilitation',
    'service1_description' => 'Customized biokinetic rehabilitation for injuries, post-surgery recovery, and chronic conditions to restore optimal movement.',
    'service1_icon' => 'fa-walking',
    'service2_title' => 'Sports Performance',
    'service2_description' => 'Specialized training programs to enhance athletic performance, prevent injuries, and optimize recovery for athletes.',
    'service2_icon' => 'fa-running',
    'service3_title' => 'Chronic Disease Management',
    'service3_description' => 'Exercise therapy regimens for managing chronic conditions such as diabetes, hypertension, and cardiovascular disease.',
    'service3_icon' => 'fa-heartbeat',
    'service4_title' => 'Postural Assessment',
    'service4_description' => 'Comprehensive analysis of body alignment and posture to identify imbalances and create corrective programs.',
    'service4_icon' => 'fa-user-check',
    'service5_title' => 'Orthopedic Therapy',
    'service5_description' => 'Specialized treatment for musculoskeletal issues including joint pain, muscle strains, and mobility limitations.',
    'service5_icon' => 'fa-bone',
    'service6_title' => 'Wellness Programs',
    'service6_description' => 'Personalized exercise plans focused on improving overall health, strength, flexibility, and quality of life.',
    'service6_icon' => 'fa-dumbbell'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<form action="{{ route('admin.website.services.update') }}" method="POST">
    @csrf
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Section Header</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Section Title*</label>
                <input type="text" id="title" name="title" value="{{ old('title', $displayContent['title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text*</label>
                <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $displayContent['button_text']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Service 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 1</h4>
            
            <div class="mb-3">
                <label for="service1_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service1_title" name="service1_title" value="{{ old('service1_title', $displayContent['service1_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service1_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service1_description" name="service1_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service1_description', $displayContent['service1_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service1_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service1_icon" name="service1_icon" value="{{ old('service1_icon', $displayContent['service1_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service1_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Service 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 2</h4>
            
            <div class="mb-3">
                <label for="service2_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service2_title" name="service2_title" value="{{ old('service2_title', $displayContent['service2_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service2_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service2_description" name="service2_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service2_description', $displayContent['service2_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service2_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service2_icon" name="service2_icon" value="{{ old('service2_icon', $displayContent['service2_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service2_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Service 3 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 3</h4>
            
            <div class="mb-3">
                <label for="service3_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service3_title" name="service3_title" value="{{ old('service3_title', $displayContent['service3_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service3_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service3_description" name="service3_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service3_description', $displayContent['service3_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service3_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service3_icon" name="service3_icon" value="{{ old('service3_icon', $displayContent['service3_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service3_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Service 4 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 4</h4>
            
            <div class="mb-3">
                <label for="service4_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service4_title" name="service4_title" value="{{ old('service4_title', $displayContent['service4_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service4_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service4_description" name="service4_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service4_description', $displayContent['service4_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service4_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service4_icon" name="service4_icon" value="{{ old('service4_icon', $displayContent['service4_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service4_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Service 5 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 5</h4>
            
            <div class="mb-3">
                <label for="service5_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service5_title" name="service5_title" value="{{ old('service5_title', $displayContent['service5_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service5_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service5_description" name="service5_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service5_description', $displayContent['service5_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service5_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service5_icon" name="service5_icon" value="{{ old('service5_icon', $displayContent['service5_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service5_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Service 6 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="font-medium text-gray-700 mb-4">Service 6</h4>
            
            <div class="mb-3">
                <label for="service6_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                <input type="text" id="service6_title" name="service6_title" value="{{ old('service6_title', $displayContent['service6_title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-3">
                <label for="service6_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                <textarea id="service6_description" name="service6_description" rows="3" 
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('service6_description', $displayContent['service6_description']) }}</textarea>
            </div>
            
            <div class="mb-2">
                <label for="service6_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                <div class="flex space-x-2">
                    <input type="text" id="service6_icon" name="service6_icon" value="{{ old('service6_icon', $displayContent['service6_icon']) }}" 
                           class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                        <i class="fas {{ $displayContent['service6_icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-save mr-1"></i> Update Services Section
        </button>
    </div>
</form>

<!-- Icon Reference -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-blue-800 mb-2">FontAwesome Icon Reference</h3>
    <p class="text-blue-600 mb-3">
        You can use any FontAwesome 5 icon by specifying its class. Here are some commonly used icons for services:
    </p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-walking"></i>
            <span class="text-sm">fa-walking</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-running"></i>
            <span class="text-sm">fa-running</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-heartbeat"></i>
            <span class="text-sm">fa-heartbeat</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-user-check"></i>
            <span class="text-sm">fa-user-check</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-bone"></i>
            <span class="text-sm">fa-bone</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-dumbbell"></i>
            <span class="text-sm">fa-dumbbell</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-stethoscope"></i>
            <span class="text-sm">fa-stethoscope</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-notes-medical"></i>
            <span class="text-sm">fa-notes-medical</span>
        </div>
    </div>
    <p class="text-blue-600 mt-3">
        For more icons, visit <a href="https://fontawesome.com/v5/search" target="_blank" class="underline">FontAwesome</a>.
    </p>
</div>
@endsection 