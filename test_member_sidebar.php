<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Member Role Sidebar Analysis ===\n\n";

// Test Member role permissions
$roleName = 'member';

echo "Testing Member Role Permissions:\n";
echo "Role: " . $roleName . "\n";

// Simulate sidebar permission logic for Member
$isSuperAdmin = $roleName === 'super_admin';
$isChaplain = $roleName === 'chaplain';
$isChairpersonEmployee = $roleName === 'chairperson_employee';
$isChairpersonStudent = $roleName === 'chairperson_student';
$isSecretary = $roleName === 'secretary';
$isTreasurer = $roleName === 'treasurer';
$isSpiritualCoordinator = $roleName === 'spiritual_coordinator';
$isCommunityLeader = $roleName === 'community_leader';
$isGroupLeader = $roleName === 'group_leader';
$isKamatiHead = $roleName === 'kamati_head';
$isMember = $roleName === 'member';
$isEventChairperson = $roleName === 'event_chairperson';

// High-level access roles
$isFullAccess = $isSuperAdmin || $isChaplain;
$isLeadership = $isChairpersonEmployee || $isChairpersonStudent;
$isAdministrative = $isSecretary || $isTreasurer;
$isCoordinator = $isSpiritualCoordinator || $isCommunityLeader || $isGroupLeader;

// Module-specific permissions (current logic)
$canFinance = $isFullAccess || $isLeadership || $isTreasurer;
$canParishioners = $isFullAccess || $isLeadership || $isSecretary || $isCoordinator;
$canEvents = $isFullAccess || $isLeadership || $isSecretary || $isCoordinator || $isKamatiHead || $isEventChairperson;
$canAssets = $isFullAccess || $isLeadership || $isKamatiHead;
$canSms = $isFullAccess || $isLeadership || $isSecretary || $isTreasurer;
$canReports = $isFullAccess || $isLeadership || $isTreasurer || $isSecretary;
$canSettings = $isSuperAdmin;
$canCommunities = $isFullAccess || $isLeadership || $isSecretary || $isCommunityLeader;
$canGroups = $isFullAccess || $isLeadership || $isSecretary || $isGroupLeader || $isSpiritualCoordinator;
$canCertificates = $isFullAccess || $isSecretary;

echo "\nCurrent Member Permissions:\n";
echo "  Finance: " . ($canFinance ? 'YES' : 'NO') . "\n";
echo "  Parishioners: " . ($canParishioners ? 'YES' : 'NO') . "\n";
echo "  Events: " . ($canEvents ? 'YES' : 'NO') . "\n";
echo "  Assets: " . ($canAssets ? 'YES' : 'NO') . "\n";
echo "  SMS: " . ($canSms ? 'YES' : 'NO') . "\n";
echo "  Reports: " . ($canReports ? 'YES' : 'NO') . "\n";
echo "  Settings: " . ($canSettings ? 'YES' : 'NO') . "\n";
echo "  Communities: " . ($canCommunities ? 'YES' : 'NO') . "\n";
echo "  Groups: " . ($canGroups ? 'YES' : 'NO') . "\n";
echo "  Certificates: " . ($canCertificates ? 'YES' : 'NO') . "\n";

echo "\nRecommended Member Sidebar Items:\n";
echo "  - Dashboard (always visible)\n";
echo "  - My Profile (always visible)\n";
echo "  - My Contributions (member-specific)\n";
echo "  - My Certificates (member-specific)\n";
echo "  - My Events (member-specific)\n";
echo "  - My Community (if member belongs to one)\n";
echo "  - My Spiritual Group (if member belongs to one)\n";
echo "  - Directory (view other members)\n";
echo "  - Calendar (view events)\n";
echo "  - Announcements (view communications)\n";

echo "\n=== Analysis Complete ===\n";
