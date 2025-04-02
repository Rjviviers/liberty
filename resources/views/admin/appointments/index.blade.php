@extends('admin.layout')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Appointments</h2>
    <a href="{{ route('admin.appointments.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        <i class="fas fa-plus mr-1"></i> New Appointment
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<!-- Filter Controls -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <div class="flex flex-wrap items-center gap-4">
        <div>
            <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status-filter" class="border border-gray-300 rounded px-3 py-2 w-40">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        
        <div>
            <label for="date-filter" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" id="date-filter" class="border border-gray-300 rounded px-3 py-2">
        </div>
        
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" id="search" placeholder="Search name or email" class="border border-gray-300 rounded px-3 py-2 w-64">
        </div>
    </div>
</div>

<style>
    .status-pending { background-color: #FEF3C7; }
    .status-confirmed { background-color: #DCFCE7; }
    .status-cancelled { background-color: #FEE2E2; }
</style>

<!-- Appointments Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($appointments as $appointment)
                <tr class="appointment-row" 
                    data-status="{{ $appointment->status }}" 
                    data-date="{{ $appointment->date->format('Y-m-d') }}" 
                    data-search="{{ strtolower($appointment->name . ' ' . $appointment->email) }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $appointment->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $appointment->name }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->email }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->phone }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $appointment->service }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $appointment->date->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $appointment->time }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.appointments.update-status', $appointment) }}" method="POST" class="status-form">
                            @csrf
                            @method('PATCH')
                            <select name="status" 
                                   class="status-select text-sm rounded px-2 py-1 status-{{ $appointment->status }}" 
                                   onchange="this.form.submit()">
                                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No appointments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const dateFilter = document.getElementById('date-filter');
        const searchInput = document.getElementById('search');
        const rows = document.querySelectorAll('.appointment-row');
        
        // Combined filter function
        function applyFilters() {
            const statusValue = statusFilter.value.toLowerCase();
            const dateValue = dateFilter.value;
            const searchValue = searchInput.value.toLowerCase();
            
            rows.forEach(row => {
                const rowStatus = row.dataset.status;
                const rowDate = row.dataset.date;
                const rowSearch = row.dataset.search;
                
                const statusMatch = !statusValue || rowStatus === statusValue;
                const dateMatch = !dateValue || rowDate === dateValue;
                const searchMatch = !searchValue || rowSearch.includes(searchValue);
                
                if (statusMatch && dateMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Add event listeners to all filter controls
        statusFilter.addEventListener('change', applyFilters);
        dateFilter.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);
        
        // Color status selects based on value
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                // Remove previous classes
                this.classList.remove('status-pending', 'status-confirmed', 'status-cancelled');
                // Add new class based on selected value
                this.classList.add('status-' + this.value);
            });
        });
    });
</script>
@endsection 