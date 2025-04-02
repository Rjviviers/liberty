<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $testimonials = Testimonial::approved()->latest()->take(3)->get();
        
        // Get hero section content from the database
        $heroContent = $this->getHeroContent();
        
        return view('home', [
            'testimonials' => $testimonials,
            'heroContent' => $heroContent
        ]);
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        // Get about section content from the database
        $aboutContent = $this->getAboutContent();
        
        return view('about', [
            'aboutContent' => $aboutContent
        ]);
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'service' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);
        
        // Create the appointment
        \App\Models\Appointment::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'service' => $validated['service'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Appointment booked successfully. We will contact you soon.'
        ]);
    }

    /**
     * Get the hero section content from the database.
     * 
     * @return array
     */
    private function getHeroContent()
    {
        // Default hero content values
        $defaultContent = [
            'heading' => 'Professional Biokinetics for Total Wellness',
            'subheading' => 'Restore Movement. Regain Life.',
            'description' => 'Danie de Villiers offers personalized biokinetic treatments to improve your movement, fitness, and quality of life. Experience the difference with evidence-based rehabilitation.',
            'image' => 'https://liberty.test/assets/Danie%20De%20Villiers.png',
            'button_text' => 'Book Appointment',
            'admin_button_text' => 'Admin Login'
        ];
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'hero')
                ->where('is_active', true)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })
                ->toArray();
                
            // Merge with defaults to ensure all keys exist
            return array_merge($defaultContent, $content);
        } catch (\Exception $e) {
            // If anything goes wrong, return the defaults
            return $defaultContent;
        }
    }

    /**
     * Get the about section content from the database.
     * 
     * @return array
     */
    private function getAboutContent()
    {
        // Default about content values
        $defaultContent = [
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
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'about')
                ->where('is_active', true)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })
                ->toArray();
                
            // Merge with defaults to ensure all keys exist
            return array_merge($defaultContent, $content);
        } catch (\Exception $e) {
            // If anything goes wrong, return the defaults
            return $defaultContent;
        }
    }
}
