@extends('admin.layout')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Dashboard</h2>
    <p class="text-gray-600">Welcome to your admin dashboard.</p>
</div>

<!-- Dashboard Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Appointments</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Appointment::count() }}</h3>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-calendar-check text-blue-500 fa-2x"></i>
            </div>
        </div>
        <p class="text-green-600 text-sm mt-4">
            <i class="fas fa-arrow-up mr-1"></i> {{ \App\Models\Appointment::where('created_at', '>=', now()->subDays(7))->count() }} new this week
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Appointment::where('status', 'pending')->count() }}</h3>
            </div>
            <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fas fa-clock text-yellow-500 fa-2x"></i>
            </div>
        </div>
        <p class="text-yellow-600 text-sm mt-4">
            <i class="fas fa-exclamation-circle mr-1"></i> Requires attention
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Confirmed</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Appointment::where('status', 'confirmed')->count() }}</h3>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-check-circle text-green-500 fa-2x"></i>
            </div>
        </div>
        <p class="text-green-600 text-sm mt-4">
            <i class="fas fa-calendar mr-1"></i> Scheduled appointments
        </p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Today's Appointments</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Appointment::whereDate('date', today())->count() }}</h3>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="fas fa-calendar-day text-purple-500 fa-2x"></i>
            </div>
        </div>
        <p class="text-purple-600 text-sm mt-4">
            <i class="fas fa-calendar-check mr-1"></i> For {{ today()->format('d M Y') }}
        </p>
    </div>
</div>

<!-- Recent Appointments -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-800">Recent Appointments</h3>
        <a href="{{ route('admin.appointments.index') }}" class="text-blue-500 hover:text-blue-700">
            View All <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse(\App\Models\Appointment::latest()->take(5)->get() as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $appointment->name }}</div>
                            <div class="text-sm text-gray-500">{{ $appointment->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $appointment->service }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $appointment->date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $appointment->time }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                  ($appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No appointments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 