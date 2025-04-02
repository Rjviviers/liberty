<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('website_contents')) {
            // Table exists, add missing columns
            Schema::table('website_contents', function (Blueprint $table) {
                if (!Schema::hasColumn('website_contents', 'section')) {
                    $table->string('section')->comment('Section of the website (hero, about, etc)');
                }
                
                if (!Schema::hasColumn('website_contents', 'key')) {
                    $table->string('key')->comment('Content identifier');
                }
                
                if (!Schema::hasColumn('website_contents', 'value')) {
                    $table->text('value')->nullable()->comment('Content value');
                }
                
                if (!Schema::hasColumn('website_contents', 'type')) {
                    $table->string('type')->default('text')->comment('Content type (text, image, etc)');
                }
                
                if (!Schema::hasColumn('website_contents', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
                
                // Add unique constraint if it doesn't exist
                // Note: Laravel doesn't have a direct way to check if an index exists,
                // so we'll try/catch this operation
                try {
                    $table->unique(['section', 'key']);
                } catch (\Exception $e) {
                    // Index likely already exists
                }
            });
        } else {
            // Table doesn't exist, create it
            Schema::create('website_contents', function (Blueprint $table) {
                $table->id();
                $table->string('section')->comment('Section of the website (hero, about, etc)');
                $table->string('key')->comment('Content identifier');
                $table->text('value')->nullable()->comment('Content value');
                $table->string('type')->default('text')->comment('Content type (text, image, etc)');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                // Create a unique constraint for section and key combination
                $table->unique(['section', 'key']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop the table if the down migration is explicitly called
        // We won't drop the table as it might contain important data
        // Instead, just remove the columns we added
        if (Schema::hasTable('website_contents')) {
            Schema::table('website_contents', function (Blueprint $table) {
                // Drop the unique index
                $table->dropUnique(['section', 'key']);
                
                // Drop columns
                $table->dropColumn(['section', 'key', 'value', 'type', 'is_active']);
            });
        }
    }
};
