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
        try {
            // Only query testimonials if the table exists
            if (Schema::hasTable('testimonials')) {
                $testimonials = Testimonial::approved()->latest()->take(3)->get();
            } else {
                $testimonials = collect();
            }
        } catch (\Exception $e) {
            // If there's an error, use an empty collection
            $testimonials = collect();
        }
        
        // Get hero section content from the database
        $heroContent = $this->getHeroContent();
        
        // Get about section content from the database
        $aboutContent = $this->getAboutContent();
        
        // Get features section content from the database
        $featuresContent = $this->getFeaturesContent();
        
        // Get services section content from the database
        $servicesContent = $this->getServicesContent();
        
        // Get testimonials section content from the database
        $testimonialsContent = $this->getTestimonialsContent();
        
        // Get contact section content from the database
        $contactContent = $this->getContactContent();
        
        return view('home', [
            'testimonials' => $testimonials,
            'heroContent' => $heroContent,
            'aboutContent' => $aboutContent,
            'featuresContent' => $featuresContent,
            'servicesContent' => $servicesContent,
            'testimonialsContent' => $testimonialsContent,
            'contactContent' => $contactContent
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
        // Get services section content from the database
        $servicesContent = $this->getServicesContent();
        
        return view('services', [
            'servicesContent' => $servicesContent
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact(): View
    {
        // Get contact section content from the database
        $contactContent = $this->getContactContent();
        
        return view('contact', [
            'contactContent' => $contactContent
        ]);
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

    /**
     * Get the features section content from the database.
     * 
     * @return array
     */
    private function getFeaturesContent()
    {
        // Default features content values
        $defaultContent = [
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
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'features')
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
     * Get the services section content from the database.
     * 
     * @return array
     */
    private function getServicesContent()
    {
        // Default services content values
        $defaultContent = [
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
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'services')
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
     * Get the testimonials section content from the database.
     * 
     * @return array
     */
    private function getTestimonialsContent()
    {
        // Default testimonials content values
        $defaultContent = [
            'title' => 'What Our Patients Say',
            'view_all_text' => 'View All Testimonials',
            'avatar1' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
            'avatar2' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80',
            'avatar3' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80'
        ];
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'testimonials')
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
     * Get the contact section content from the database.
     * 
     * @return array
     */
    private function getContactContent()
    {
        // Default contact content values
        $defaultContent = [
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
        
        // Try to get content from database
        try {
            // Check if the table exists before querying
            if (!Schema::hasTable('website_contents')) {
                return $defaultContent;
            }
            
            $content = \App\Models\WebsiteContent::where('section', 'contact')
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
