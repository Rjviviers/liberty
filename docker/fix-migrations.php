<?php

/**
 * Migration Fix Script
 * 
 * This script ensures that migrations will run in the correct order by fixing timestamps
 * and ensuring proper dependencies between tables.
 */

// Directory containing migration files
$migrationsDir = __DIR__ . '/../database/migrations';

// Get all migration files
$files = scandir($migrationsDir);
$migrationFiles = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue;
    }
    
    $migrationFiles[] = $file;
}

echo "Checking migration files...\n";

// Check for future dates
$futureDates = [];
foreach ($migrationFiles as $file) {
    if (preg_match('/^(20[2-9][5-9]_\d{2}_\d{2})/', $file, $matches)) {
        $futureDates[] = $file;
    }
}

if (!empty($futureDates)) {
    echo "Found " . count($futureDates) . " migration files with future dates:\n";
    foreach ($futureDates as $file) {
        echo "  - $file\n";
    }
    
    echo "\nFixing migration file dates...\n";
    
    // Get current timestamp parts
    $now = new DateTime();
    $year = $now->format('Y');
    $month = $now->format('m');
    $day = $now->format('d');
    
    // Base timestamp for today
    $baseTimestamp = "{$year}_{$month}_{$day}";
    
    // Counter for sequential timestamps
    $counter = 1;
    
    foreach ($futureDates as $file) {
        $newTimestamp = $baseTimestamp . '_' . str_pad($counter, 3, '0', STR_PAD_LEFT);
        $newFilename = preg_replace('/^\d{4}_\d{2}_\d{2}/', $newTimestamp, $file);
        
        echo "  Renaming $file to $newFilename\n";
        
        // Rename the file
        rename("$migrationsDir/$file", "$migrationsDir/$newFilename");
        
        $counter++;
    }
}

// Check for foreign key dependencies
echo "\nChecking for foreign key dependencies...\n";

// Define tables with their dependencies
$dependencies = [
    'treatment_plans' => ['patients'],
    // Add more dependencies here if needed
];

// Find migration files for each table
$tableFiles = [];
foreach ($migrationFiles as $file) {
    foreach (array_merge(array_keys($dependencies), array_merge(...array_values($dependencies))) as $table) {
        if (strpos($file, "create_{$table}_table") !== false) {
            $tableFiles[$table] = $file;
        }
    }
}

// Check if dependent tables have correct timestamps
foreach ($dependencies as $table => $dependsOn) {
    if (!isset($tableFiles[$table])) {
        echo "  Warning: Migration for table '$table' not found\n";
        continue;
    }
    
    foreach ($dependsOn as $dependency) {
        if (!isset($tableFiles[$dependency])) {
            echo "  Warning: Migration for dependency '$dependency' not found\n";
            continue;
        }
        
        // Extract timestamps
        preg_match('/^(\d{4}_\d{2}_\d{2}_\d{6})/', $tableFiles[$table], $tableMatches);
        preg_match('/^(\d{4}_\d{2}_\d{2}_\d{6})/', $tableFiles[$dependency], $depMatches);
        
        if (empty($tableMatches) || empty($depMatches)) {
            echo "  Warning: Could not extract timestamps for '$table' or '$dependency'\n";
            continue;
        }
        
        $tableTimestamp = $tableMatches[1];
        $depTimestamp = $depMatches[1];
        
        // Check if dependency should run before the table
        if ($tableTimestamp <= $depTimestamp) {
            echo "  Error: Table '$table' depends on '$dependency' but would run before it\n";
            
            // Fix the timestamp of the dependent table
            $now = new DateTime();
            $year = $now->format('Y');
            $month = $now->format('m');
            $day = $now->format('d');
            $time = (int)$now->format('His') + 1; // Add 1 second to ensure it's later
            
            $newTimestamp = "{$year}_{$month}_{$day}_" . str_pad($time, 6, '0', STR_PAD_LEFT);
            $newFilename = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}/', $newTimestamp, $tableFiles[$table]);
            
            echo "  Renaming {$tableFiles[$table]} to $newFilename\n";
            
            // Rename the file
            rename("$migrationsDir/{$tableFiles[$table]}", "$migrationsDir/$newFilename");
        } else {
            echo "  OK: Table '$table' depends on '$dependency' and will run after it\n";
        }
    }
}

echo "\nMigration check complete.\n";
