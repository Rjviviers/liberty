<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('detail', 255)->nullable();
            $table->text('text');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Insert sample testimonials
        DB::table('testimonials')->insert([
            [
                'name' => 'Michael Peters', 
                'detail' => 'Knee Surgery Rehabilitation', 
                'text' => 'After working with Danie for just 3 months, I\'ve seen remarkable improvement in my mobility and strength following my knee surgery. His expertise and personalized approach made all the difference in my recovery.', 
                'is_approved' => true
            ],
            [
                'name' => 'Sarah Johnson', 
                'detail' => 'Chronic Disease Management', 
                'text' => 'As someone with Type 2 Diabetes, I was skeptical about exercise therapy. Danie designed a program that worked for my condition, and I\'ve seen significant improvements in my blood sugar levels and overall energy.', 
                'is_approved' => true
            ],
            [
                'name' => 'David Pretorius', 
                'detail' => 'Cricket Player', 
                'text' => 'Danie\'s athlete-specific training helped me recover from a shoulder injury and improve my cricket bowling performance. His knowledge of sports biomechanics is exceptional.', 
                'is_approved' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
