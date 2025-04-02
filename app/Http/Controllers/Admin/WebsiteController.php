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
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.features', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all features section contents
            $featuresContents = WebsiteContent::section('features')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $featuresDefaults = [
                'title' => 'Why Choose Danie de Villiers',
                'image' => 'https://images.unsplash.com/photo-1522898467493-49726bf28798?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'cta_title' => 'Ready to experience exceptional biokinetic care?',
                'cta_description' => 'Schedule your consultation today and take the first step towards better movement and health.',
                'cta_button_text' => 'Get Started',
                'feature1_title' => 'Patient-Centered Care',
                'feature1_description' => 'Danie prioritizes your unique needs and preferences in every aspect of your biokinetic treatment plan.',
                'feature1_icon' => 'fa-user-check',
                'feature2_title' => 'Advanced Techniques',
                'feature2_description' => 'Using cutting-edge exercise therapy techniques and equipment for effective rehabilitation and performance enhancement.',
                'feature2_icon' => 'fa-laptop-medical',
                'feature3_title' => 'Experienced Professional',
                'feature3_description' => 'With over 15 years of experience, Danie brings specialized knowledge in biokinetics to your treatment.',
                'feature3_icon' => 'fa-user-md',
                'feature4_title' => 'Holistic Approach',
                'feature4_description' => 'Addressing all aspects of your movement and physical wellbeing, not just isolated symptoms or conditions.',
                'feature4_icon' => 'fa-hospital-user'
            ];
                
            // Merge defaults with existing content
            $content = array_merge($featuresDefaults, $featuresContents);
                
            return view('admin.website.features', compact('content'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.features', [
                'content' => null
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update the features section content.
     */
    public function updateFeatures(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.features.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|max:2048',
                'cta_title' => 'required|string|max:255',
                'cta_description' => 'required|string',
                'cta_button_text' => 'required|string|max:50',
                'feature1_title' => 'required|string|max:255',
                'feature1_description' => 'required|string',
                'feature1_icon' => 'required|string|max:50',
                'feature2_title' => 'required|string|max:255',
                'feature2_description' => 'required|string',
                'feature2_icon' => 'required|string|max:50',
                'feature3_title' => 'required|string|max:255',
                'feature3_description' => 'required|string',
                'feature3_icon' => 'required|string|max:50',
                'feature4_title' => 'required|string|max:255',
                'feature4_description' => 'required|string',
                'feature4_icon' => 'required|string|max:50',
            ]);
            
            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/assets');
                $validated['image'] = Storage::url($path);
            }
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'features', 'key' => $key],
                    ['value' => $value, 'type' => $key === 'image' ? 'image' : 'text']
                );
            }
            
            return redirect()->route('admin.website.features.edit')
                ->with('success', 'Features section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.features.edit')
                ->with('error', 'Failed to update features section: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the services section edit page.
     */
    public function editServices()
    {
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.services', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all services section contents
            $servicesContents = WebsiteContent::section('services')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $servicesDefaults = [
                'title' => 'Our Services',
                'button_text' => 'View All Services',
                'service1_title' => 'Rehabilitation',
                'service1_description' => 'Customized biokinetic rehabilitation for injuries, post-surgery recovery, and chronic conditions to restore optimal movement.',
                'service1_icon' => 'fa-walking',
                'service2_title' => 'Sports Performance',
                'service2_description' => 'Specialized training programs to enhance athletic performance, prevent injuries, and optimize recovery for athletes.',
                'service2_icon' => 'fa-running',
                'service3_title' => 'Chronic Disease Management',
                'service3_description' => 'Exercise therapy regimens for managing chronic conditions such as diabetes, hypertension, and cardiovascular disease.',
                'service3_icon' => 'fa-heartbeat',
                'service4_title' => 'Postural Assessment',
                'service4_description' => 'Comprehensive analysis of body alignment and posture to identify imbalances and create corrective programs.',
                'service4_icon' => 'fa-user-check',
                'service5_title' => 'Orthopedic Therapy',
                'service5_description' => 'Specialized treatment for musculoskeletal issues including joint pain, muscle strains, and mobility limitations.',
                'service5_icon' => 'fa-bone',
                'service6_title' => 'Wellness Programs',
                'service6_description' => 'Personalized exercise plans focused on improving overall health, strength, flexibility, and quality of life.',
                'service6_icon' => 'fa-dumbbell'
            ];
                
            // Merge defaults with existing content
            $content = array_merge($servicesDefaults, $servicesContents);
                
            return view('admin.website.services', compact('content'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.services', [
                'content' => null
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update the services section content.
     */
    public function updateServices(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.services.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'button_text' => 'required|string|max:50',
                'service1_title' => 'required|string|max:255',
                'service1_description' => 'required|string',
                'service1_icon' => 'required|string|max:50',
                'service2_title' => 'required|string|max:255',
                'service2_description' => 'required|string',
                'service2_icon' => 'required|string|max:50',
                'service3_title' => 'required|string|max:255',
                'service3_description' => 'required|string',
                'service3_icon' => 'required|string|max:50',
                'service4_title' => 'required|string|max:255',
                'service4_description' => 'required|string',
                'service4_icon' => 'required|string|max:50',
                'service5_title' => 'required|string|max:255',
                'service5_description' => 'required|string',
                'service5_icon' => 'required|string|max:50',
                'service6_title' => 'required|string|max:255',
                'service6_description' => 'required|string',
                'service6_icon' => 'required|string|max:50',
            ]);
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'services', 'key' => $key],
                    ['value' => $value, 'type' => 'text']
                );
            }
            
            return redirect()->route('admin.website.services.edit')
                ->with('success', 'Services section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.services.edit')
                ->with('error', 'Failed to update services section: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the testimonials section edit page.
     */
    public function editTestimonials()
    {
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.testimonials', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all testimonials section contents
            $testimonialsContents = WebsiteContent::section('testimonials')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $testimonialsDefaults = [
                'title' => 'What Our Patients Say',
                'view_all_text' => 'View All Testimonials',
                'avatar1' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
                'avatar2' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
                'avatar3' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
            ];
                
            // Merge defaults with existing content
            $content = array_merge($testimonialsDefaults, $testimonialsContents);
            
            // Get all testimonials
            $testimonials = [];
            if (Schema::hasTable('testimonials')) {
                $testimonials = \App\Models\Testimonial::latest()->paginate(10);
            }
                
            return view('admin.website.testimonials', compact('content', 'testimonials'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.testimonials', [
                'content' => null,
                'testimonials' => []
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }
    
    /**
     * Update the testimonials section content.
     */
    public function updateTestimonials(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.testimonials.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'view_all_text' => 'required|string|max:255',
                'avatar1' => 'nullable|image|max:2048',
                'avatar2' => 'nullable|image|max:2048',
                'avatar3' => 'nullable|image|max:2048',
            ]);
            
            // Handle image uploads if provided
            foreach (['avatar1', 'avatar2', 'avatar3'] as $avatarField) {
                if ($request->hasFile($avatarField)) {
                    $path = $request->file($avatarField)->store('public/assets/testimonials');
                    $validated[$avatarField] = Storage::url($path);
                } elseif ($request->has('current_'.$avatarField)) {
                    // Keep the current image if no new one was uploaded
                    $validated[$avatarField] = $request->input('current_'.$avatarField);
                }
            }
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'testimonials', 'key' => $key],
                    ['value' => $value, 'type' => in_array($key, ['avatar1', 'avatar2', 'avatar3']) ? 'image' : 'text']
                );
            }
            
            return redirect()->route('admin.website.testimonials.edit')
                ->with('success', 'Testimonials section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.testimonials.edit')
                ->with('error', 'Failed to update testimonials section: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the contact section edit page.
     */
    public function editContact()
    {
        try {
            // Check if table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return view('admin.website.contact', [
                    'content' => null
                ])->with('error', 'Website content table not available. Run database migrations to create the table.');
            }
            
            // Get all contact section contents
            $contactContents = WebsiteContent::section('contact')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();
                
            // Default values if not set
            $contactDefaults = [
                'title' => 'Contact Us',
                'subtitle' => 'Get in touch with Danie de Villiers',
                'address' => '123 Main Street, Pretoria, South Africa, 0001',
                'email' => 'info@daniedevilliers.co.za',
                'phone' => '+27 123 456 789',
                'hours_title' => 'Operating Hours',
                'hours_weekdays' => 'Monday - Friday: 8:00 AM - 6:00 PM',
                'hours_saturday' => 'Saturday: 9:00 AM - 2:00 PM',
                'hours_sunday' => 'Sunday: Closed',
                'form_title' => 'Send a Message',
                'form_subtitle' => 'Fill out the form below and we will get back to you as soon as possible.',
                'form_button_text' => 'Send Message',
                'map_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14345.060030342745!2d28.19360515!3d-25.7478676!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e95619cbec65033%3A0xf66a9ebebbceae77!2sPretoria%2C%20South%20Africa!5e0!3m2!1sen!2sus!4v1621500458031!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'booking_title' => 'Book an Appointment',
                'booking_text' => 'Ready to schedule your consultation? Click the button below to book your appointment.',
                'booking_button_text' => 'Book Appointment'
            ];
                
            // Merge defaults with existing content
            $content = array_merge($contactDefaults, $contactContents);
                
            return view('admin.website.contact', compact('content'));
        } catch (\Exception $e) {
            // Return the view with an error message
            return view('admin.website.contact', [
                'content' => null
            ])->with('error', 'Could not retrieve website content due to a database error: ' . $e->getMessage());
        }
    }

    /**
     * Update the contact section content.
     */
    public function updateContact(Request $request)
    {
        try {
            // Check if table exists before updating
            if (!Schema::hasTable('website_contents')) {
                return redirect()->route('admin.website.contact.edit')
                    ->with('error', 'Cannot save content: Website content table not available. Run database migrations to create the table.');
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:50',
                'hours_title' => 'required|string|max:255',
                'hours_weekdays' => 'required|string|max:255',
                'hours_saturday' => 'required|string|max:255',
                'hours_sunday' => 'required|string|max:255',
                'form_title' => 'required|string|max:255',
                'form_subtitle' => 'required|string',
                'form_button_text' => 'required|string|max:50',
                'map_embed' => 'required|string',
                'booking_title' => 'required|string|max:255',
                'booking_text' => 'required|string',
                'booking_button_text' => 'required|string|max:50',
            ]);
            
            // Update or create each content entry
            foreach ($validated as $key => $value) {
                WebsiteContent::updateOrCreate(
                    ['section' => 'contact', 'key' => $key],
                    ['value' => $value, 'type' => 'text']
                );
            }
            
            return redirect()->route('admin.website.contact.edit')
                ->with('success', 'Contact section updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.website.contact.edit')
                ->with('error', 'Failed to update contact section: ' . $e->getMessage());
        }
    }
}
