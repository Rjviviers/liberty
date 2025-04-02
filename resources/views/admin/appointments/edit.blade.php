@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Appointment</h2>
        <p class="text-gray-600">Update appointment details</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('admin.appointments.show', $appointment) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-eye mr-1"></i> View
        </a>
        <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
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

<div class="bg-white rounded-lg shadow-md p-6">
    <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Client Information</h3>
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name*</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $appointment->name) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $appointment->email) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $appointment->phone) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Appointment Details</h3>
                
                <div class="mb-4">
                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service*</label>
                    <select id="service" name="service" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="Biokinetic Assessment" {{ old('service', $appointment->service) === 'Biokinetic Assessment' ? 'selected' : '' }}>Biokinetic Assessment</option>
                        <option value="Rehabilitation" {{ old('service', $appointment->service) === 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                        <option value="Sports Performance" {{ old('service', $appointment->service) === 'Sports Performance' ? 'selected' : '' }}>Sports Performance</option>
                        <option value="Chronic Disease Management" {{ old('service', $appointment->service) === 'Chronic Disease Management' ? 'selected' : '' }}>Chronic Disease Management</option>
                        <option value="Physical Fitness Assessment" {{ old('service', $appointment->service) === 'Physical Fitness Assessment' ? 'selected' : '' }}>Physical Fitness Assessment</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date*</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $appointment->date->format('Y-m-d')) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time*</label>
                    <input type="time" id="time" name="time" value="{{ old('time', substr($appointment->time, 0, 5)) }}" 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status*</label>
                    <select id="status" name="status" 
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="pending" {{ old('status', $appointment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $appointment->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status', $appointment->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
            <textarea id="message" name="message" rows="4" 
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message', $appointment->message) }}</textarea>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <i class="fas fa-save mr-1"></i> Update Appointment
            </button>
        </div>
    </form>
</div>
@endsection 