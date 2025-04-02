@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Appointment Details</h2>
        <p class="text-gray-600">View appointment information</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            <i class="fas fa-edit mr-1"></i> Edit
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

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $appointment->name }}</h3>
                <p class="text-gray-600 mb-1">
                    <i class="fas fa-envelope mr-2"></i> {{ $appointment->email }}
                </p>
                @if($appointment->phone)
                <p class="text-gray-600 mb-1">
                    <i class="fas fa-phone mr-2"></i> {{ $appointment->phone }}
                </p>
                @endif
            </div>
            
            <div>
                <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full 
                    {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                      ($appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
        </div>
        
        <hr class="my-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-3">Appointment Details</h4>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Service</p>
                    <p class="text-base text-gray-800">{{ $appointment->service }}</p>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Date & Time</p>
                    <p class="text-base text-gray-800">
                        {{ $appointment->date->format('d M Y') }} at {{ $appointment->time }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Created On</p>
                    <p class="text-base text-gray-800">{{ $appointment->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-3">Additional Information</h4>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Message</p>
                    <div class="p-3 bg-gray-50 rounded mt-1">
                        <p class="text-base text-gray-800">
                            {{ $appointment->message ?? 'No additional message provided.' }}
                        </p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-700 mb-3">Update Status</h4>
                    
                    <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="flex space-x-2">
                            <select name="status" class="border border-gray-300 rounded px-3 py-2">
                                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
    
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-base font-semibold text-gray-800">Delete this appointment</h4>
                <p class="text-sm text-gray-600">Once deleted, this appointment will be permanently removed</p>
            </div>
            
            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Delete Appointment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 