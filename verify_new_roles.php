<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== New Role Structure Verification ===\n\n";

$roles = \App\Models\Role::withCount('permissions')->orderBy('level')->get();

echo "Role Hierarchy and Permissions:\n";
echo str_repeat("=", 80) . "\n";

foreach ($roles as $role) {
    echo sprintf("%-20s | Level %-2d | %3d permissions | %s\n", 
        $role->display_name, 
        $role->level, 
        $role->permissions_count,
        substr($role->responsibilities, 0, 40) . (strlen($role->responsibilities) > 40 ? '...' : '')
    );
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "Total Roles: " . $roles->count() . "\n";
echo "Total Permission Assignments: " . $roles->sum('permissions_count') . "\n\n";

echo "Detailed Role Responsibilities:\n";
echo str_repeat("-", 80) . "\n";

foreach ($roles as $role) {
    echo sprintf("%s (%s)\n", $role->display_name, $role->name);
    echo "Level: {$role->level}\n";
    echo "Responsibilities: {$role->responsibilities}\n";
    echo "Permissions: {$role->permissions_count}\n";
    echo str_repeat("-", 40) . "\n";
}

echo "\n=== Verification Complete ===\n";
