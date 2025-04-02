<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class WebsiteController extends Controller
{
    /**
     * Show the hero section edit page.
     */
    public function editHero()
    {
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.hero', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all hero section contents
            $heroContents = WebsiteContent::section('hero')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $heroDefaults = [
                'heading' => 'Professional Biokinetics for Total Wellness',
                'subheading' => 'Restore Movement. Regain Life.',
                'description' => 'Danie de Villiers offers personalized biokinetic treatments to improve your movement, fitness, and quality of life. Experience the difference with evidence-based rehabilitation.',
                'image' => 'https://liberty.test/assets/Danie%20De%20Villiers.png',
                'button_text' => 'Book Appointment',
                'admin_button_text' => 'Admin Login'
            ];
                
            // Merge defaults with existing content
            $content = array_merge($heroDefaults, $heroContents);
                
            return view('admin.website.hero', compact('content'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.hero', [
                'content' => null
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update the hero section content.
     */
    public function updateHero(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.hero.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'heading' => 'required|string|max:255',
                'subheading' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|max:2048',
                'button_text' => 'required|string|max:50',
                'admin_button_text' => 'required|string|max:50',
            ]);
            
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/assets');
                $validated['image'] = Storage::url($path);
            }
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'hero', 'key' => $key],
                    ['value' => $value, 'type' => $key === 'image' ? 'image' : 'text']
                );
            }
            
            return redirect()->route('admin.website.hero.edit')
                ->with('success', 'Hero section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.hero.edit')
                ->with('error', 'Failed to update hero section: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the about section edit page.
     */
    public function editAbout()
    {
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.about', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all about section contents
            $aboutContents = WebsiteContent::section('about')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $aboutDefaults = [
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
                
            // Merge defaults with existing content
            $content = array_merge($aboutDefaults, $aboutContents);
                
            return view('admin.website.about', compact('content'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.about', [
                'content' => null
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update the about section content.
     */
    public function updateAbout(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.about.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'paragraph1' => 'required|string',
                'paragraph2' => 'required|string',
                'image' => 'nullable|image|max:2048',
                'years_experience' => 'required|string|max:20',
                'experience_text' => 'required|string|max:100',
                'highlight1_title' => 'required|string|max:50',
                'highlight1_icon' => 'required|string|max:50',
                'highlight2_title' => 'required|string|max:50',
                'highlight2_icon' => 'required|string|max:50',
                'highlight3_title' => 'required|string|max:50',
                'highlight3_icon' => 'required|string|max:50',
                'highlight4_title' => 'required|string|max:50',
                'highlight4_icon' => 'required|string|max:50',
            ]);
            
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/assets');
                $validated['image'] = Storage::url($path);
            }
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'about', 'key' => $key],
                    ['value' => $value, 'type' => $key === 'image' ? 'image' : 'text']
                );
            }
            
            return redirect()->route('admin.website.about.edit')
                ->with('success', 'About section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.about.edit')
                ->with('error', 'Failed to update about section: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the features section edit page.
     */
    public function editFeatures()
    {
        // Implementation for features section
        return view('admin.website.features');
    }
    
    /**
     * Show the services section edit page.
     */
    public function editServices()
    {
        // Implementation for services section
        return view('admin.website.services');
    }
    
    /**
     * Show the testimonials section edit page.
     */
    public function editTestimonials()
    {
        // Implementation for testimonials section
        return view('admin.website.testimonials');
    }
    
    /**
     * Show the contact section edit page.
     */
    public function editContact()
    {
        // Implementation for contact section
        return view('admin.website.contact');
    }
}
