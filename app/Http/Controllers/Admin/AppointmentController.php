<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::latest()->get();
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        Appointment::create($request->all());

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        return view('admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment->update($request->all());

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully');
    }
    
    /**
     * Update appointment status.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Appointment status updated.');
    }
}
