<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class ComprehensivePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create all permissions
        $permissions = $this->getPermissions();
        $createdPermissions = [];
        
        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $permissionData) {
                $permission = Permission::create([
                    'name' => $permissionData['name'],
                    'display_name' => $permissionData['display_name'],
                    'module' => $module,
                    'category' => $permissionData['category'],
                    'description' => $permissionData['description'] ?? null,
                ]);
                $createdPermissions[$permissionData['name']] = $permission;
            }
        }

        // Create roles
        $roles = $this->getRoles();
        
        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'slug' => $roleData['slug'],
                'display_name' => $roleData['display_name'],
                'description' => $roleData['description'],
                'responsibilities' => $roleData['responsibilities'] ?? null,
                'level' => $roleData['level'],
                'is_active' => true,
            ]);

            // Assign permissions to role
            if (isset($roleData['permissions'])) {
                $permissionIds = [];
                foreach ($roleData['permissions'] as $permissionName) {
                    if (isset($createdPermissions[$permissionName])) {
                        $permissionIds[] = $createdPermissions[$permissionName]->id;
                    }
                }
                $role->permissions()->attach($permissionIds);
            }
        }
    }

    private function getPermissions(): array
    {
        return [
            'members' => [
                ['name' => 'view_members', 'display_name' => 'View Members', 'category' => 'read', 'description' => 'View member profiles and basic information'],
                ['name' => 'create_members', 'display_name' => 'Create Members', 'category' => 'write', 'description' => 'Add new members to the system'],
                ['name' => 'edit_members', 'display_name' => 'Edit Members', 'category' => 'write', 'description' => 'Update member information'],
                ['name' => 'delete_members', 'display_name' => 'Delete Members', 'category' => 'admin', 'description' => 'Remove members from the system'],
                ['name' => 'import_members', 'display_name' => 'Import Members (CSV)', 'category' => 'write', 'description' => 'Bulk import members from CSV files'],
                ['name' => 'export_members', 'display_name' => 'Export Members', 'category' => 'read', 'description' => 'Export member data to files'],
                ['name' => 'manage_member_types', 'display_name' => 'Manage Member Types', 'category' => 'admin', 'description' => 'Manage student/employee/child member types'],
                ['name' => 'assign_to_community', 'display_name' => 'Assign to Community', 'category' => 'write', 'description' => 'Assign members to spiritual communities'],
                ['name' => 'assign_to_group', 'display_name' => 'Assign to Group', 'category' => 'write', 'description' => 'Assign members to spiritual groups'],
            ],
            'finance' => [
                ['name' => 'view_finance', 'display_name' => 'View Finance', 'category' => 'read', 'description' => 'View financial records and reports'],
                ['name' => 'record_contribution', 'display_name' => 'Record Contribution', 'category' => 'write', 'description' => 'Record member contributions and donations'],
                ['name' => 'record_expense', 'display_name' => 'Record Expense', 'category' => 'write', 'description' => 'Record church expenses'],
                ['name' => 'generate_receipt', 'display_name' => 'Generate Receipt', 'category' => 'write', 'description' => 'Generate contribution receipts'],
                ['name' => 'view_receipts', 'display_name' => 'View Receipts', 'category' => 'read', 'description' => 'View and search receipts'],
                ['name' => 'view_finance_reports', 'display_name' => 'View Finance Reports', 'category' => 'read', 'description' => 'Access financial reports and analytics'],
                ['name' => 'manage_financial_years', 'display_name' => 'Manage Financial Years', 'category' => 'admin', 'description' => 'Manage financial year periods and transitions'],
            ],
            'certificates' => [
                ['name' => 'view_certificates', 'display_name' => 'View Certificates', 'category' => 'read', 'description' => 'View issued certificates'],
                ['name' => 'generate_finalist_certificate', 'display_name' => 'Generate Finalist Certificate', 'category' => 'write', 'description' => 'Generate certificates for finalists'],
                ['name' => 'generate_group_certificate', 'display_name' => 'Generate Group Certificate', 'category' => 'write', 'description' => 'Generate group participation certificates'],
                ['name' => 'generate_leadership_certificate', 'display_name' => 'Generate Leadership Certificate', 'category' => 'write', 'description' => 'Generate leadership recognition certificates'],
                ['name' => 'generate_event_certificate', 'display_name' => 'Generate Event Certificate', 'category' => 'write', 'description' => 'Generate event participation certificates'],
                ['name' => 'approve_certificates', 'display_name' => 'Approve Certificates', 'category' => 'admin', 'description' => 'Approve certificate requests and issuances'],
                ['name' => 'manage_templates', 'display_name' => 'Manage Certificate Templates', 'category' => 'admin', 'description' => 'Design and manage certificate templates'],
                ['name' => 'verify_certificates', 'display_name' => 'Verify Certificates (Public)', 'category' => 'read', 'description' => 'Public certificate verification'],
            ],
            'communities' => [
                ['name' => 'view_communities', 'display_name' => 'View Communities', 'category' => 'read', 'description' => 'View spiritual communities'],
                ['name' => 'create_communities', 'display_name' => 'Create Communities', 'category' => 'write', 'description' => 'Create new spiritual communities'],
                ['name' => 'edit_communities', 'display_name' => 'Edit Communities', 'category' => 'write', 'description' => 'Update community information'],
                ['name' => 'delete_communities', 'display_name' => 'Delete Communities', 'category' => 'admin', 'description' => 'Remove communities'],
                ['name' => 'assign_community_leaders', 'display_name' => 'Assign Community Leaders', 'category' => 'write', 'description' => 'Assign leaders to communities'],
                ['name' => 'view_community_reports', 'display_name' => 'View Community Reports', 'category' => 'read', 'description' => 'Access community-specific reports'],
            ],
            'spiritual_groups' => [
                ['name' => 'view_groups', 'display_name' => 'View Spiritual Groups', 'category' => 'read', 'description' => 'View spiritual groups'],
                ['name' => 'create_groups', 'display_name' => 'Create Spiritual Groups', 'category' => 'write', 'description' => 'Create new spiritual groups'],
                ['name' => 'edit_groups', 'display_name' => 'Edit Spiritual Groups', 'category' => 'write', 'description' => 'Update group information'],
                ['name' => 'delete_groups', 'display_name' => 'Delete Spiritual Groups', 'category' => 'admin', 'description' => 'Remove spiritual groups'],
                ['name' => 'assign_group_leaders', 'display_name' => 'Assign Group Leaders', 'category' => 'write', 'description' => 'Assign leaders to spiritual groups'],
                ['name' => 'view_group_reports', 'display_name' => 'View Group Reports', 'category' => 'read', 'description' => 'Access group-specific reports'],
            ],
            'events' => [
                ['name' => 'view_events', 'display_name' => 'View Events', 'category' => 'read', 'description' => 'View church events and calendar'],
                ['name' => 'create_events', 'display_name' => 'Create Events', 'category' => 'write', 'description' => 'Create new events'],
                ['name' => 'edit_events', 'display_name' => 'Edit Events', 'category' => 'write', 'description' => 'Update event details'],
                ['name' => 'delete_events', 'display_name' => 'Delete Events', 'category' => 'admin', 'description' => 'Cancel or remove events'],
                ['name' => 'appoint_event_chairperson', 'display_name' => 'Appoint Event Chairperson', 'category' => 'write', 'description' => 'Assign chairpersons to events'],
                ['name' => 'manage_event_tasks', 'display_name' => 'Manage Event Tasks', 'category' => 'write', 'description' => 'Create and assign event tasks'],
                ['name' => 'track_event_attendance', 'display_name' => 'Track Event Attendance', 'category' => 'write', 'description' => 'Track and manage event attendance'],
                ['name' => 'submit_event_report', 'display_name' => 'Submit Post-Event Report', 'category' => 'write', 'description' => 'Submit reports after events'],
            ],
            'elections' => [
                ['name' => 'view_elections', 'display_name' => 'View Elections', 'category' => 'read', 'description' => 'View election processes and results'],
                ['name' => 'manage_nominations', 'display_name' => 'Manage Nominations', 'category' => 'write', 'description' => 'Manage candidate nominations'],
                ['name' => 'manage_interviews', 'display_name' => 'Manage Interviews', 'category' => 'write', 'description' => 'Conduct and manage candidate interviews'],
                ['name' => 'conduct_voting', 'display_name' => 'Conduct Voting', 'category' => 'write', 'description' => 'Manage voting process'],
                ['name' => 'publish_results', 'display_name' => 'Publish Results', 'category' => 'admin', 'description' => 'Publish election results'],
                ['name' => 'view_audit_trail', 'display_name' => 'View Audit Trail', 'category' => 'read', 'description' => 'Access election audit logs'],
            ],
            'assets' => [
                ['name' => 'view_assets', 'display_name' => 'View Assets', 'category' => 'read', 'description' => 'View church assets and inventory'],
                ['name' => 'create_assets', 'display_name' => 'Create Assets', 'category' => 'write', 'description' => 'Add new assets to inventory'],
                ['name' => 'edit_assets', 'display_name' => 'Edit Assets', 'category' => 'write', 'description' => 'Update asset information'],
                ['name' => 'delete_assets', 'display_name' => 'Delete Assets', 'category' => 'admin', 'description' => 'Remove assets from system'],
                ['name' => 'checkout_assets', 'display_name' => 'Check Out Assets', 'category' => 'write', 'description' => 'Check out assets for use'],
                ['name' => 'checkin_assets', 'display_name' => 'Check In Assets', 'category' => 'write', 'description' => 'Check in returned assets'],
                ['name' => 'schedule_maintenance', 'display_name' => 'Schedule Maintenance', 'category' => 'write', 'description' => 'Schedule asset maintenance'],
            ],
            'shop_pos' => [
                ['name' => 'view_shop', 'display_name' => 'View Shop (POS)', 'category' => 'read', 'description' => 'View point of sale interface'],
                ['name' => 'process_sales', 'display_name' => 'Process Sales', 'category' => 'write', 'description' => 'Process sales transactions'],
                ['name' => 'manage_inventory', 'display_name' => 'Manage Inventory', 'category' => 'write', 'description' => 'Manage shop inventory'],
                ['name' => 'view_sales_reports', 'display_name' => 'View Sales Reports', 'category' => 'read', 'description' => 'Access sales reports and analytics'],
                ['name' => 'manage_low_stock_alerts', 'display_name' => 'Manage Low Stock Alerts', 'category' => 'write', 'description' => 'Handle low inventory alerts'],
            ],
            'communication_sms' => [
                ['name' => 'view_sms', 'display_name' => 'View SMS', 'category' => 'read', 'description' => 'View SMS communications'],
                ['name' => 'send_sms', 'display_name' => 'Send SMS', 'category' => 'write', 'description' => 'Send SMS messages'],
                ['name' => 'schedule_sms', 'display_name' => 'Schedule SMS', 'category' => 'write', 'description' => 'Schedule SMS campaigns'],
                ['name' => 'use_sms_templates', 'display_name' => 'Use SMS Templates', 'category' => 'write', 'description' => 'Use predefined SMS templates'],
                ['name' => 'view_sms_logs', 'display_name' => 'View SMS Logs', 'category' => 'read', 'description' => 'Access SMS delivery logs'],
                ['name' => 'view_sms_cost_reports', 'display_name' => 'View SMS Cost Reports', 'category' => 'read', 'description' => 'View SMS cost analysis'],
            ],
            'communication_email' => [
                ['name' => 'view_email', 'display_name' => 'View Email', 'category' => 'read', 'description' => 'View email communications'],
                ['name' => 'send_email', 'display_name' => 'Send Email', 'category' => 'write', 'description' => 'Send email messages'],
                ['name' => 'schedule_email', 'display_name' => 'Schedule Email', 'category' => 'write', 'description' => 'Schedule email campaigns'],
                ['name' => 'use_email_templates', 'display_name' => 'Use Email Templates', 'category' => 'write', 'description' => 'Use predefined email templates'],
                ['name' => 'view_email_logs', 'display_name' => 'View Email Logs', 'category' => 'read', 'description' => 'Access email delivery logs'],
            ],
            'reports' => [
                ['name' => 'view_all_reports', 'display_name' => 'View All Reports', 'category' => 'read', 'description' => 'Access comprehensive reports dashboard'],
                ['name' => 'generate_custom_reports', 'display_name' => 'Generate Custom Reports', 'category' => 'write', 'description' => 'Create custom reports'],
                ['name' => 'export_reports', 'display_name' => 'Export Reports', 'category' => 'read', 'description' => 'Export reports in various formats'],
            ],
            'settings' => [
                ['name' => 'view_settings', 'display_name' => 'View Settings', 'category' => 'read', 'description' => 'View system settings'],
                ['name' => 'manage_users', 'display_name' => 'Manage Users', 'category' => 'admin', 'description' => 'Manage user accounts'],
                ['name' => 'manage_roles', 'display_name' => 'Manage Roles', 'category' => 'admin', 'description' => 'Manage system roles and permissions'],
                ['name' => 'manage_system_settings', 'display_name' => 'Manage System Settings', 'category' => 'admin', 'description' => 'Configure system-wide settings'],
                ['name' => 'manage_financial_year_setup', 'display_name' => 'Manage Financial Year Setup', 'category' => 'admin', 'description' => 'Configure financial year settings'],
                ['name' => 'manage_certificate_templates', 'display_name' => 'Manage Certificate Templates', 'category' => 'admin', 'description' => 'Design and manage certificate templates'],
                ['name' => 'backup_restore', 'display_name' => 'Backup & Restore', 'category' => 'admin', 'description' => 'Manage system backups and restoration'],
                ['name' => 'view_activity_log', 'display_name' => 'View Activity Log', 'category' => 'read', 'description' => 'Access system activity logs'],
            ],
        ];
    }

    private function getRoles(): array
    {
        return [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Full system control with access to all features and settings',
                'responsibilities' => 'System administration, user management, security oversight, and complete system configuration',
                'level' => 'super_admin',
                'permissions' => [
                    // All permissions - Super Admin has everything
                    'view_members', 'create_members', 'edit_members', 'delete_members', 'import_members', 'export_members', 'manage_member_types', 'assign_to_community', 'assign_to_group',
                    'view_finance', 'record_contribution', 'record_expense', 'generate_receipt', 'view_receipts', 'view_finance_reports', 'manage_financial_years',
                    'view_certificates', 'generate_finalist_certificate', 'generate_group_certificate', 'generate_leadership_certificate', 'generate_event_certificate', 'approve_certificates', 'manage_templates', 'verify_certificates',
                    'view_communities', 'create_communities', 'edit_communities', 'delete_communities', 'assign_community_leaders', 'view_community_reports',
                    'view_groups', 'create_groups', 'edit_groups', 'delete_groups', 'assign_group_leaders', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'delete_events', 'appoint_event_chairperson', 'manage_event_tasks', 'track_event_attendance', 'submit_event_report',
                    'view_elections', 'manage_nominations', 'manage_interviews', 'conduct_voting', 'publish_results', 'view_audit_trail',
                    'view_assets', 'create_assets', 'edit_assets', 'delete_assets', 'checkout_assets', 'checkin_assets', 'schedule_maintenance',
                    'view_shop', 'process_sales', 'manage_inventory', 'view_sales_reports', 'manage_low_stock_alerts',
                    'view_sms', 'send_sms', 'schedule_sms', 'use_sms_templates', 'view_sms_logs', 'view_sms_cost_reports',
                    'view_email', 'send_email', 'schedule_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports', 'generate_custom_reports', 'export_reports',
                    'view_settings', 'manage_users', 'manage_roles', 'manage_system_settings', 'manage_financial_year_setup', 'manage_certificate_templates', 'backup_restore', 'view_activity_log'
                ]
            ],
            [
                'name' => 'Chaplain',
                'slug' => 'chaplain',
                'display_name' => 'Chaplain',
                'description' => 'Spiritual leadership with comprehensive access except system configuration',
                'responsibilities' => 'Spiritual guidance, member counseling, community oversight, and religious administration',
                'level' => 'leadership',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'import_members', 'export_members', 'assign_to_community', 'assign_to_group',
                    'view_finance', 'record_contribution', 'record_expense', 'generate_receipt', 'view_receipts', 'view_finance_reports',
                    'view_certificates', 'generate_finalist_certificate', 'generate_group_certificate', 'generate_leadership_certificate', 'generate_event_certificate',
                    'view_communities', 'create_communities', 'edit_communities', 'assign_community_leaders', 'view_community_reports',
                    'view_groups', 'create_groups', 'edit_groups', 'assign_group_leaders', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'appoint_event_chairperson', 'manage_event_tasks', 'track_event_attendance', 'submit_event_report',
                    'view_elections', 'manage_nominations', 'manage_interviews', 'conduct_voting', 'publish_results',
                    'view_assets', 'create_assets', 'edit_assets', 'checkout_assets', 'checkin_assets', 'schedule_maintenance',
                    'view_shop', 'process_sales', 'view_sales_reports',
                    'view_sms', 'send_sms', 'schedule_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'schedule_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports', 'export_reports',
                    'view_settings', 'view_activity_log'
                ]
            ],
            [
                'name' => 'Chairperson (Employee)',
                'slug' => 'chairperson_employee',
                'display_name' => 'Chairperson (Employee)',
                'description' => 'Co-leadership role overseeing employee affairs and operations',
                'responsibilities' => 'Employee representation, operational coordination, and leadership support',
                'level' => 'leadership',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'assign_to_community', 'assign_to_group',
                    'view_finance', 'record_contribution', 'record_expense', 'view_receipts', 'view_finance_reports',
                    'view_certificates', 'generate_finalist_certificate', 'generate_event_certificate',
                    'view_communities', 'edit_communities', 'view_community_reports',
                    'view_groups', 'edit_groups', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_elections', 'manage_nominations', 'manage_interviews',
                    'view_assets', 'checkout_assets', 'checkin_assets',
                    'view_shop', 'process_sales', 'view_sales_reports',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports',
                    'view_settings'
                ]
            ],
            [
                'name' => 'Chairperson (Student)',
                'slug' => 'chairperson_student',
                'display_name' => 'Chairperson (Student)',
                'description' => 'Co-leadership role overseeing student affairs and activities',
                'responsibilities' => 'Student representation, activity coordination, and student leadership',
                'level' => 'leadership',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'assign_to_group',
                    'view_certificates', 'generate_finalist_certificate', 'generate_event_certificate',
                    'view_groups', 'edit_groups', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_elections', 'manage_nominations',
                    'view_assets', 'checkout_assets', 'checkin_assets',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports'
                ]
            ],
            [
                'name' => 'Secretary',
                'slug' => 'secretary',
                'display_name' => 'Secretary',
                'description' => 'Records management and administrative support',
                'responsibilities' => 'Record keeping, correspondence, data entry, and administrative assistance',
                'level' => 'standard',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'import_members', 'export_members',
                    'view_finance', 'record_contribution', 'record_expense', 'generate_receipt', 'view_receipts',
                    'view_certificates', 'generate_finalist_certificate', 'generate_group_certificate', 'generate_event_certificate',
                    'view_communities', 'create_communities', 'edit_communities', 'view_community_reports',
                    'view_groups', 'create_groups', 'edit_groups', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance', 'submit_event_report',
                    'view_elections', 'manage_nominations', 'view_audit_trail',
                    'view_assets', 'create_assets', 'edit_assets', 'checkout_assets', 'checkin_assets',
                    'view_sms', 'send_sms', 'schedule_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'schedule_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports', 'export_reports',
                    'view_settings'
                ]
            ],
            [
                'name' => 'Treasurer',
                'slug' => 'treasurer',
                'display_name' => 'Treasurer',
                'description' => 'Financial management and reporting',
                'responsibilities' => 'Financial oversight, budget management, contribution tracking, and financial reporting',
                'level' => 'leadership',
                'permissions' => [
                    'view_members', 'view_members',
                    'view_finance', 'record_contribution', 'record_expense', 'generate_receipt', 'view_receipts', 'view_finance_reports', 'manage_financial_years',
                    'view_certificates', 'view_certificates',
                    'view_communities', 'view_community_reports',
                    'view_groups', 'view_group_reports',
                    'view_events', 'view_events',
                    'view_assets', 'view_assets',
                    'view_shop', 'process_sales', 'manage_inventory', 'view_sales_reports', 'manage_low_stock_alerts',
                    'view_sms', 'view_sms_cost_reports',
                    'view_all_reports', 'generate_custom_reports', 'export_reports',
                    'view_settings'
                ]
            ],
            [
                'name' => 'Spiritual Coordinator',
                'slug' => 'spiritual_coordinator',
                'display_name' => 'Spiritual Coordinator',
                'description' => 'Manages specific academic programme/class',
                'responsibilities' => 'Spiritual programme management, class coordination, and spiritual guidance for assigned groups',
                'level' => 'standard',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'assign_to_group',
                    'view_certificates', 'generate_finalist_certificate', 'generate_event_certificate',
                    'view_groups', 'create_groups', 'edit_groups', 'assign_group_leaders', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_assets', 'checkout_assets', 'checkin_assets',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports'
                ]
            ],
            [
                'name' => 'Community Leader',
                'slug' => 'community_leader',
                'display_name' => 'Community Leader',
                'description' => 'Manages a specific spiritual community',
                'responsibilities' => 'Community leadership, member coordination, and community activity management',
                'level' => 'standard',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'assign_to_community',
                    'view_certificates', 'generate_group_certificate', 'generate_event_certificate',
                    'view_communities', 'edit_communities', 'view_community_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports'
                ]
            ],
            [
                'name' => 'Group Leader',
                'slug' => 'group_leader',
                'display_name' => 'Group Leader',
                'description' => 'Manages a specific spiritual group',
                'responsibilities' => 'Group leadership, activity coordination, and member support within the group',
                'level' => 'standard',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members', 'assign_to_group',
                    'view_certificates', 'generate_group_certificate', 'generate_event_certificate',
                    'view_groups', 'edit_groups', 'view_group_reports',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs'
                ]
            ],
            [
                'name' => 'Kamati Head',
                'slug' => 'kamati_head',
                'display_name' => 'Kamati Head',
                'description' => 'Manages a specific committee (Liturgical, Decoration, Table of Sales)',
                'responsibilities' => 'Committee leadership, task coordination, and committee-specific operations',
                'level' => 'standard',
                'permissions' => [
                    'view_members', 'create_members', 'edit_members',
                    'view_events', 'create_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance',
                    'view_assets', 'checkout_assets', 'checkin_assets',
                    'view_shop', 'process_sales', 'view_sales_reports', 'manage_low_stock_alerts',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs',
                    'view_all_reports'
                ]
            ],
            [
                'name' => 'Member',
                'slug' => 'member',
                'display_name' => 'Member',
                'description' => 'Regular member with self-service access',
                'responsibilities' => 'Personal profile management, participation in activities, and access to own information',
                'level' => 'limited',
                'permissions' => [
                    'view_members',
                    'view_certificates', 'verify_certificates',
                    'view_events', 'track_event_attendance',
                    'view_sms', 'view_sms_logs',
                    'view_email', 'view_email_logs'
                ]
            ],
            [
                'name' => 'Event Chairperson',
                'slug' => 'event_chairperson',
                'display_name' => 'Event Chairperson',
                'description' => 'Temporary role for managing specific events',
                'responsibilities' => 'Event coordination, task management, and event execution oversight',
                'level' => 'limited',
                'permissions' => [
                    'view_members', 'edit_members',
                    'view_events', 'edit_events', 'manage_event_tasks', 'track_event_attendance', 'submit_event_report',
                    'view_assets', 'checkout_assets', 'checkin_assets',
                    'view_sms', 'send_sms', 'use_sms_templates', 'view_sms_logs',
                    'view_email', 'send_email', 'use_email_templates', 'view_email_logs'
                ]
            ]
        ];
    }
}
