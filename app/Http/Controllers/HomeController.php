<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $testimonials = Testimonial::approved()->latest()->take(3)->get();
        
        return view('home', [
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Display the services page.
     */
    public function services(): View
    {
        return view('services');
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        return view('contact');
    }

    /**
     * Handle booking request.
     */
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required|string',
            'service' => 'required|string|max:100',
            'message' => 'nullable|string',
        ]);

        // Store the consultation request
        $consultationRequest = \App\Models\ConsultationRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'service' => $validated['service'],
            'message' => $validated['message'] ?? null,
            'status' => 'new',
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking request submitted successfully',
            'data' => [
                'name' => $validated['name'],
                'date' => $validated['date'],
                'time' => $validated['time'],
                'service' => $validated['service']
            ]
        ]);
    }
}
