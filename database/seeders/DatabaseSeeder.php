<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        
        // Seed testimonials if table exists
        if (Schema::hasTable('testimonials')) {
            DB::table('testimonials')->insert([
                [
                    'name' => 'Michael Peters', 
                    'detail' => 'Knee Surgery Rehabilitation', 
                    'text' => 'After working with Danie for just 3 months, I\'ve seen remarkable improvement in my mobility and strength following my knee surgery. His expertise and personalized approach made all the difference in my recovery.', 
                    'is_approved' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Sarah Johnson', 
                    'detail' => 'Chronic Disease Management', 
                    'text' => 'As someone with Type 2 Diabetes, I was skeptical about exercise therapy. Danie designed a program that worked for my condition, and I\'ve seen significant improvements in my blood sugar levels and overall energy.', 
                    'is_approved' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'David Pretorius', 
                    'detail' => 'Cricket Player', 
                    'text' => 'Danie\'s athlete-specific training helped me recover from a shoulder injury and improve my cricket bowling performance. His knowledge of sports biomechanics is exceptional.', 
                    'is_approved' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
