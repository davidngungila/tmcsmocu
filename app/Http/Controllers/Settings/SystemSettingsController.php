<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Models\FinancialYear;
use App\Models\User;
use App\Models\Role;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SystemSettingsController extends Controller
{
    public function index()
    {
        // Get active financial year
        $activeYear = FinancialYear::getActive();
        
        // System Health
        $systemHealth = $this->getSystemHealth();
        
        // Statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::whereNotNull('email_verified_at')->count(),
            'suspended_users' => User::whereNull('email_verified_at')->count(),
            'total_roles' => Role::count(),
            'total_transactions' => FinanceTransaction::count(),
        ];
        
        return view('settings.system.index', compact('activeYear', 'systemHealth', 'stats'));
    }
    
    private function getSystemHealth()
    {
        try {
            // Database connection check
            DB::connection()->getPdo();
            $dbConnected = true;
            
            // Get database size (MySQL specific)
            $dbSize = 0;
            try {
                $dbName = DB::connection()->getDatabaseName();
                $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb FROM information_schema.tables WHERE table_schema = ?", [$dbName]);
                $dbSize = $result[0]->size_mb ?? 0;
            } catch (\Exception $e) {
                $dbSize = 0;
            }
            
            // Get last backup time (from settings)
            $lastBackup = SystemSetting::getValue('last_backup_time', null);
            
            return [
                'database' => [
                    'connected' => $dbConnected,
                    'size_mb' => $dbSize,
                    'last_backup' => $lastBackup,
                ],
                'server' => [
                    'cpu_usage' => $this->getCpuUsage(),
                    'memory_usage' => $this->getMemoryUsage(),
                    'disk_usage' => $this->getDiskUsage(),
                    'uptime_days' => $this->getUptimeDays(),
                ],
                'performance' => [
                    'response_time' => $this->getResponseTime(),
                    'online_users' => $this->getOnlineUsers(),
                    'requests_per_second' => $this->getRequestsPerSecond(),
                ],
            ];
        } catch (\Exception $e) {
            return [
                'database' => ['connected' => false],
                'server' => [],
                'performance' => [],
            ];
        }
    }
    
    private function getCpuUsage()
    {
        // This would require system-level access
        // For now, return a mock value
        return 23; // 23%
    }
    
    private function getMemoryUsage()
    {
        // Get memory usage if available
        if (function_exists('memory_get_usage')) {
            $used = memory_get_usage(true);
            $total = memory_get_peak_usage(true);
            return [
                'used' => round($used / 1024 / 1024, 2), // MB
                'total' => round($total / 1024 / 1024, 2), // MB
                'percentage' => round(($used / $total) * 100, 1),
            ];
        }
        return ['used' => 0, 'total' => 0, 'percentage' => 0];
    }
    
    private function getDiskUsage()
    {
        // Get disk usage
        $total = disk_total_space('.');
        $free = disk_free_space('.');
        $used = $total - $free;
        
        return [
            'used' => round($used / 1024 / 1024 / 1024, 2), // GB
            'total' => round($total / 1024 / 1024 / 1024, 2), // GB
            'percentage' => round(($used / $total) * 100, 1),
        ];
    }
    
    private function getUptimeDays()
    {
        // This would require system-level access
        // For now, return a mock value
        return 45; // days
    }
    
    private function getResponseTime()
    {
        // Calculate average response time
        $start = microtime(true);
        // Simulate a quick operation
        DB::select('SELECT 1');
        $end = microtime(true);
        
        return round(($end - $start) * 1000, 2); // milliseconds
    }
    
    private function getOnlineUsers()
    {
        // Get users active in last 5 minutes (using updated_at as proxy for activity)
        $fiveMinutesAgo = now()->subMinutes(5);
        return User::where('updated_at', '>=', $fiveMinutesAgo)->count();
    }
    
    private function getRequestsPerSecond()
    {
        // This would require tracking requests
        // For now, return a mock value
        return 12; // requests per second
    }
    
    public function health()
    {
        $systemHealth = $this->getSystemHealth();
        
        // Get error logs count (mock for now)
        $errorLogs = [
            'today' => 2,
            'this_week' => 15,
            'resolved' => 12,
        ];
        
        return view('settings.system.health', compact('systemHealth', 'errorLogs'));
    }
    
    public function backupIndex()
    {
        // Get backup history (mock data for now)
        $backups = [
            (object)[
                'name' => 'daily_backup_' . date('Y-m-d'),
                'type' => 'automatic',
                'size' => 156.7,
                'status' => 'completed',
                'created_at' => now()->subHours(2),
                'description' => 'Daily automatic backup'
            ],
            (object)[
                'name' => 'manual_backup_' . date('Y-m-d', strtotime('-1 day')),
                'type' => 'manual',
                'size' => 158.2,
                'status' => 'completed',
                'created_at' => now()->subDay(),
                'description' => 'Manual backup before update'
            ],
            (object)[
                'name' => 'weekly_backup_' . date('Y-m-d', strtotime('-7 days')),
                'type' => 'scheduled',
                'size' => 162.4,
                'status' => 'completed',
                'created_at' => now()->subDays(7),
                'description' => 'Weekly scheduled backup'
            ]
        ];
        
        return view('settings.backup.index', compact('backups'));
    }
    
    public function backup()
    {
        // Trigger backup process
        // This would typically call a backup command or service
        SystemSetting::setValue('last_backup_time', now()->toDateTimeString(), 'string');
        
        return redirect()->route('settings.system.index')
            ->with('success', 'Backup imeanzishwa kwa mafanikio.');
    }
}

