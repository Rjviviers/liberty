@extends('admin.layout')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Testimonial</h2>
            <p class="text-gray-600">Update an existing testimonial</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name*</label>
                <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div>
                <label for="detail" class="block text-sm font-medium text-gray-700 mb-1">Detail/Position*</label>
                <input type="text" name="detail" id="detail" value="{{ old('detail', $testimonial->detail) }}" 
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       placeholder="e.g. Patient, CEO of Company, etc." required>
            </div>
        </div>
        
        <div class="mb-6">
            <label for="text" class="block text-sm font-medium text-gray-700 mb-1">Testimonial Text*</label>
            <textarea name="text" id="text" rows="5" 
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('text', $testimonial->text) }}</textarea>
        </div>
        
        <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status*</label>
            <select name="status" id="status" 
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="pending" {{ old('status', $testimonial->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status', $testimonial->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status', $testimonial->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Update Testimonial
            </button>
        </div>
    </form>
</div>
@endsection 