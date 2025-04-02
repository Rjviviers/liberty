<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing testimonials
        DB::table('testimonials')->truncate();
        
        // Create sample testimonials
        $testimonials = [
            [
                'name' => 'John Smith',
                'detail' => 'Recovered from back injury',
                'text' => 'After months of chronic back pain, Danie\'s expert care completely transformed my mobility. I can now enjoy activities I thought were no longer possible!',
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'detail' => 'Sports rehabilitation patient',
                'text' => 'As an athlete, finding the right biokinetic specialist was crucial for my recovery. Danie not only helped me recover from my knee injury but improved my overall performance.',
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Williams',
                'detail' => 'Post-surgery rehabilitation',
                'text' => 'Following my shoulder surgery, I was worried about regaining full mobility. Thanks to Danie\'s comprehensive treatment plan and professional guidance, I\'ve made a complete recovery.',
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maria Rodriguez',
                'detail' => 'Chronic pain management',
                'text' => 'I\'ve struggled with fibromyalgia for years. Danie\'s holistic approach to pain management has significantly improved my quality of life. I highly recommend his services.',
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Insert testimonials
        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
        
        $this->command->info('Sample testimonials seeded successfully!');
    }
}
