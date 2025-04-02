<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'detail' => 'required|string|max:255',
                'text' => 'required|string',
                'status' => 'required|string|in:pending,approved,rejected',
            ]);
            
            Testimonial::create($validated);
            
            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            // Database error handling
            return redirect()->back()
                ->withInput()
                ->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'text' => 'required|string',
            'status' => 'required|string|in:pending,approved,rejected',
        ]);
        
        $testimonial->update($validated);
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
