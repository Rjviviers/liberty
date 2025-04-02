@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Testimonials Section</h2>
        <p class="text-gray-600">Edit the testimonials section displayed on the homepage</p>
    </div>
    <a href="{{ route('home') }}#testimonials" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
    'title' => 'What Our Patients Say',
    'view_all_text' => 'View All Testimonials',
    'avatar1' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
    'avatar2' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
    'avatar3' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
];

// Use content from the controller if available, otherwise use fallback
$displayContent = isset($content) ? $content : $fallbackContent;
@endphp

@if(!isset($content))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
        <p><strong>Note:</strong> Using fallback content because the website_contents table might not be available. Changes made here will not be saved until the database issue is resolved.</p>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Section: Settings -->
    <div>
        <form action="{{ route('admin.website.testimonials.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 mb-6">
            @csrf
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Testimonials Section Settings</h3>
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Section Title*</label>
                <input type="text" id="title" name="title" value="{{ old('title', $displayContent['title']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="view_all_text" class="block text-sm font-medium text-gray-700 mb-1">View All Text*</label>
                <input type="text" id="view_all_text" name="view_all_text" value="{{ old('view_all_text', $displayContent['view_all_text']) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mt-6">
                <h4 class="font-medium text-gray-700 mb-2">Avatar Images</h4>
                <p class="text-sm text-gray-600 mb-3">These images will be rotated for testimonials. Upload square images for best results.</p>
                
                <!-- Avatar 1 -->
                <div class="mb-4">
                    <label for="avatar1" class="block text-sm font-medium text-gray-700 mb-1">Avatar 1</label>
                    <div class="flex items-center space-x-3">
                        <img src="{{ $displayContent['avatar1'] }}" alt="Avatar 1" class="w-12 h-12 rounded-full object-cover">
                        <input type="file" id="avatar1" name="avatar1" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="current_avatar1" value="{{ $displayContent['avatar1'] }}">
                    </div>
                </div>
                
                <!-- Avatar 2 -->
                <div class="mb-4">
                    <label for="avatar2" class="block text-sm font-medium text-gray-700 mb-1">Avatar 2</label>
                    <div class="flex items-center space-x-3">
                        <img src="{{ $displayContent['avatar2'] }}" alt="Avatar 2" class="w-12 h-12 rounded-full object-cover">
                        <input type="file" id="avatar2" name="avatar2" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="current_avatar2" value="{{ $displayContent['avatar2'] }}">
                    </div>
                </div>
                
                <!-- Avatar 3 -->
                <div class="mb-4">
                    <label for="avatar3" class="block text-sm font-medium text-gray-700 mb-1">Avatar 3</label>
                    <div class="flex items-center space-x-3">
                        <img src="{{ $displayContent['avatar3'] }}" alt="Avatar 3" class="w-12 h-12 rounded-full object-cover">
                        <input type="file" id="avatar3" name="avatar3" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="current_avatar3" value="{{ $displayContent['avatar3'] }}">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end mt-6">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    <i class="fas fa-save mr-1"></i> Update Settings
                </button>
            </div>
        </form>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Add New Testimonial</h3>
            <a href="{{ route('admin.testimonials.create') }}" class="block w-full py-2 px-4 bg-green-500 text-white text-center rounded hover:bg-green-600">
                <i class="fas fa-plus mr-1"></i> Add New Testimonial
            </a>
        </div>
    </div>
    
    <!-- Right Section: Testimonials Management -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Manage Testimonials</h3>
            
            @if(isset($testimonials) && count($testimonials) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-left">
                                <th class="py-2 px-4 font-semibold">#</th>
                                <th class="py-2 px-4 font-semibold">Name</th>
                                <th class="py-2 px-4 font-semibold">Detail</th>
                                <th class="py-2 px-4 font-semibold">Status</th>
                                <th class="py-2 px-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $index => $testimonial)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $index + 1 }}</td>
                                    <td class="py-2 px-4">{{ $testimonial->name }}</td>
                                    <td class="py-2 px-4">{{ Str::limit($testimonial->detail, 30) }}</td>
                                    <td class="py-2 px-4">
                                        <span class="px-2 py-1 rounded text-xs text-white
                                            {{ $testimonial->is_approved ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            {{ $testimonial->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-comment-slash text-4xl mb-3"></i>
                    <p>No testimonials found. Add your first testimonial to showcase what patients say about your service.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 