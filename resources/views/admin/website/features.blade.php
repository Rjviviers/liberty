@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Features Section</h2>
        <p class="text-gray-600">Edit the "Why Choose Danie de Villiers" section displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}#features" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
    'title' => 'Why Choose Danie de Villiers',
    'image' => 'https://images.unsplash.com/photo-1522898467493-49726bf28798?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    'cta_title' => 'Ready to experience exceptional biokinetic care?',
    'cta_description' => 'Schedule your consultation today and take the first step towards better movement and health.',
    'cta_button_text' => 'Get Started',
    'feature1_title' => 'Patient-Centered Care',
    'feature1_description' => 'Danie prioritizes your unique needs and preferences in every aspect of your biokinetic treatment plan.',
    'feature1_icon' => 'fa-user-check',
    'feature2_title' => 'Advanced Techniques',
    'feature2_description' => 'Using cutting-edge exercise therapy techniques and equipment for effective rehabilitation and performance enhancement.',
    'feature2_icon' => 'fa-laptop-medical',
    'feature3_title' => 'Experienced Professional',
    'feature3_description' => 'With over 15 years of experience, Danie brings specialized knowledge in biokinetics to your treatment.',
    'feature3_icon' => 'fa-user-md',
    'feature4_title' => 'Holistic Approach',
    'feature4_description' => 'Addressing all aspects of your movement and physical wellbeing, not just isolated symptoms or conditions.',
    'feature4_icon' => 'fa-hospital-user'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<form action="{{ route('admin.website.features.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Section Header</h3>
        
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Section Title*</label>
            <input type="text" id="title" name="title" value="{{ old('title', $displayContent['title']) }}" 
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Features -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Feature Cards</h3>
            
            <!-- Feature 1 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                <h4 class="font-medium text-gray-700 mb-2">Feature 1</h4>
                
                <div class="mb-3">
                    <label for="feature1_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="feature1_title" name="feature1_title" value="{{ old('feature1_title', $displayContent['feature1_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-3">
                    <label for="feature1_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                    <textarea id="feature1_description" name="feature1_description" rows="2" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('feature1_description', $displayContent['feature1_description']) }}</textarea>
                </div>
                
                <div class="mb-2">
                    <label for="feature1_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="feature1_icon" name="feature1_icon" value="{{ old('feature1_icon', $displayContent['feature1_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="fas {{ $displayContent['feature1_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                <h4 class="font-medium text-gray-700 mb-2">Feature 2</h4>
                
                <div class="mb-3">
                    <label for="feature2_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="feature2_title" name="feature2_title" value="{{ old('feature2_title', $displayContent['feature2_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-3">
                    <label for="feature2_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                    <textarea id="feature2_description" name="feature2_description" rows="2" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('feature2_description', $displayContent['feature2_description']) }}</textarea>
                </div>
                
                <div class="mb-2">
                    <label for="feature2_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="feature2_icon" name="feature2_icon" value="{{ old('feature2_icon', $displayContent['feature2_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="fas {{ $displayContent['feature2_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-4">
                <h4 class="font-medium text-gray-700 mb-2">Feature 3</h4>
                
                <div class="mb-3">
                    <label for="feature3_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="feature3_title" name="feature3_title" value="{{ old('feature3_title', $displayContent['feature3_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-3">
                    <label for="feature3_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                    <textarea id="feature3_description" name="feature3_description" rows="2" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('feature3_description', $displayContent['feature3_description']) }}</textarea>
                </div>
                
                <div class="mb-2">
                    <label for="feature3_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="feature3_icon" name="feature3_icon" value="{{ old('feature3_icon', $displayContent['feature3_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="fas {{ $displayContent['feature3_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-2">Feature 4</h4>
                
                <div class="mb-3">
                    <label for="feature4_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="feature4_title" name="feature4_title" value="{{ old('feature4_title', $displayContent['feature4_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-3">
                    <label for="feature4_description" class="block text-sm font-medium text-gray-700 mb-1">Description*</label>
                    <textarea id="feature4_description" name="feature4_description" rows="2" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('feature4_description', $displayContent['feature4_description']) }}</textarea>
                </div>
                
                <div class="mb-2">
                    <label for="feature4_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="feature4_icon" name="feature4_icon" value="{{ old('feature4_icon', $displayContent['feature4_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="fas {{ $displayContent['feature4_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Image and CTA -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Section Image</h3>
                
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Features Image*</label>
                    <div class="flex flex-col space-y-2">
                        <img src="{{ $displayContent['image'] }}" alt="Features image preview" class="w-full h-auto rounded mb-2 max-h-60 object-cover">
                        <input type="file" id="image" name="image" 
                               class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="current_image" value="{{ $displayContent['image'] }}">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image. Maximum size: 2MB.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Call-to-Action</h3>
                
                <div class="mb-4">
                    <label for="cta_title" class="block text-sm font-medium text-gray-700 mb-1">CTA Title*</label>
                    <input type="text" id="cta_title" name="cta_title" value="{{ old('cta_title', $displayContent['cta_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="cta_description" class="block text-sm font-medium text-gray-700 mb-1">CTA Description*</label>
                    <textarea id="cta_description" name="cta_description" rows="2" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('cta_description', $displayContent['cta_description']) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="cta_button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text*</label>
                    <input type="text" id="cta_button_text" name="cta_button_text" value="{{ old('cta_button_text', $displayContent['cta_button_text']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-save mr-1"></i> Update Features Section
        </button>
    </div>
</form>

<!-- Icon Reference -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="text-lg font-semibold text-blue-800 mb-2">FontAwesome Icon Reference</h3>
    <p class="text-blue-600 mb-3">
        You can use any FontAwesome 5 icon by specifying its class. Here are some commonly used icons:
    </p>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-user-check"></i>
            <span class="text-sm">fa-user-check</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-laptop-medical"></i>
            <span class="text-sm">fa-laptop-medical</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-user-md"></i>
            <span class="text-sm">fa-user-md</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-hospital-user"></i>
            <span class="text-sm">fa-hospital-user</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-stethoscope"></i>
            <span class="text-sm">fa-stethoscope</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-heartbeat"></i>
            <span class="text-sm">fa-heartbeat</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-brain"></i>
            <span class="text-sm">fa-brain</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-chart-line"></i>
            <span class="text-sm">fa-chart-line</span>
        </div>
    </div>
    <p class="text-blue-600 mt-3">
        For more icons, visit <a href="https://fontawesome.com/v5/search" target="_blank" class="underline">FontAwesome</a>.
    </p>
</div>
@endsection 