@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">About Section</h2>
        <p class="text-gray-600">Edit the about section content displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}#about" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
    'title' => 'About Danie de Villiers',
    'subtitle' => 'Dedicated to Your Well-being',
    'paragraph1' => 'As a professional biokineticist, Danie de Villiers believes that everyone deserves personalized care that respects their unique needs and circumstances. For over 15 years, he\'s been providing exceptional biokinetic services to the community.',
    'paragraph2' => 'With extensive experience in exercise therapy, Danie is committed to offering comprehensive care that addresses both immediate concerns and long-term health goals. He combines medical expertise with a compassionate approach to ensure that every patient feels heard, supported, and empowered.',
    'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
    'years_experience' => '15+',
    'experience_text' => 'of excellence in biokinetics',
    'highlight1_title' => 'Expert Care',
    'highlight1_icon' => 'fas fa-user-md',
    'highlight2_title' => 'Personalized Treatment',
    'highlight2_icon' => 'fas fa-heartbeat',
    'highlight3_title' => 'Modern Techniques',
    'highlight3_icon' => 'fas fa-clinic-medical',
    'highlight4_title' => 'Patient Community',
    'highlight4_icon' => 'fas fa-users'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<form action="{{ route('admin.website.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Main Content</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left column - Text content -->
            <div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Section Title*</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $displayContent['title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtitle*</label>
                    <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $displayContent['subtitle']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="paragraph1" class="block text-sm font-medium text-gray-700 mb-1">Paragraph 1*</label>
                    <textarea id="paragraph1" name="paragraph1" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('paragraph1', $displayContent['paragraph1']) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="paragraph2" class="block text-sm font-medium text-gray-700 mb-1">Paragraph 2*</label>
                    <textarea id="paragraph2" name="paragraph2" rows="4" 
                              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('paragraph2', $displayContent['paragraph2']) }}</textarea>
                </div>
            </div>
            
            <!-- Right column - Image and badge -->
            <div>
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">About Image*</label>
                    <div class="flex flex-col space-y-2">
                        <img src="{{ $displayContent['image'] }}" alt="About image preview" class="w-full h-auto rounded mb-2 max-h-60 object-cover">
                        <input type="file" id="image" name="image" 
                               class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="current_image" value="{{ $displayContent['image'] }}">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image. Maximum size: 2MB.</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="font-medium text-gray-700 mb-2">Experience Badge</h4>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-1">Years of Experience*</label>
                            <input type="text" id="years_experience" name="years_experience" value="{{ old('years_experience', $displayContent['years_experience']) }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="experience_text" class="block text-sm font-medium text-gray-700 mb-1">Experience Text*</label>
                            <input type="text" id="experience_text" name="experience_text" value="{{ old('experience_text', $displayContent['experience_text']) }}" 
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Highlights</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Highlight 1 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-2">Highlight 1</h4>
                
                <div class="mb-3">
                    <label for="highlight1_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="highlight1_title" name="highlight1_title" value="{{ old('highlight1_title', $displayContent['highlight1_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-2">
                    <label for="highlight1_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="highlight1_icon" name="highlight1_icon" value="{{ old('highlight1_icon', $displayContent['highlight1_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="{{ $displayContent['highlight1_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Highlight 2 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-2">Highlight 2</h4>
                
                <div class="mb-3">
                    <label for="highlight2_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="highlight2_title" name="highlight2_title" value="{{ old('highlight2_title', $displayContent['highlight2_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-2">
                    <label for="highlight2_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="highlight2_icon" name="highlight2_icon" value="{{ old('highlight2_icon', $displayContent['highlight2_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="{{ $displayContent['highlight2_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Highlight 3 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-2">Highlight 3</h4>
                
                <div class="mb-3">
                    <label for="highlight3_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="highlight3_title" name="highlight3_title" value="{{ old('highlight3_title', $displayContent['highlight3_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-2">
                    <label for="highlight3_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="highlight3_icon" name="highlight3_icon" value="{{ old('highlight3_icon', $displayContent['highlight3_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="{{ $displayContent['highlight3_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Highlight 4 -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-medium text-gray-700 mb-2">Highlight 4</h4>
                
                <div class="mb-3">
                    <label for="highlight4_title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                    <input type="text" id="highlight4_title" name="highlight4_title" value="{{ old('highlight4_title', $displayContent['highlight4_title']) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-2">
                    <label for="highlight4_icon" class="block text-sm font-medium text-gray-700 mb-1">Icon Class* <span class="text-xs text-gray-500">(FontAwesome)</span></label>
                    <div class="flex space-x-2">
                        <input type="text" id="highlight4_icon" name="highlight4_icon" value="{{ old('highlight4_icon', $displayContent['highlight4_icon']) }}" 
                               class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded">
                            <i class="{{ $displayContent['highlight4_icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Update About Section
            </button>
        </div>
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
            <i class="fas fa-user-md"></i>
            <span class="text-sm">fas fa-user-md</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-heartbeat"></i>
            <span class="text-sm">fas fa-heartbeat</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-clinic-medical"></i>
            <span class="text-sm">fas fa-clinic-medical</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-users"></i>
            <span class="text-sm">fas fa-users</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-stethoscope"></i>
            <span class="text-sm">fas fa-stethoscope</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-notes-medical"></i>
            <span class="text-sm">fas fa-notes-medical</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-dumbbell"></i>
            <span class="text-sm">fas fa-dumbbell</span>
        </div>
        <div class="flex items-center space-x-2 text-blue-700">
            <i class="fas fa-running"></i>
            <span class="text-sm">fas fa-running</span>
        </div>
    </div>
    <p class="text-blue-600 mt-3">
        For more icons, visit <a href="https://fontawesome.com/v5/search" target="_blank" class="underline">FontAwesome</a>.
    </p>
</div>
@endsection 