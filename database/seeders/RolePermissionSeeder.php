<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            // User management
            ['name' => 'create_users', 'display_name' => 'Create Users', 'description' => 'Can create new users'],
            ['name' => 'read_users', 'display_name' => 'Read Users', 'description' => 'Can view users'],
            ['name' => 'update_users', 'display_name' => 'Update Users', 'description' => 'Can update users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],

            // Approvals
            ['name' => 'approve_requests', 'display_name' => 'Approve Requests', 'description' => 'Can approve requests'],
            ['name' => 'reject_requests', 'display_name' => 'Reject Requests', 'description' => 'Can reject requests'],
            ['name' => 'view_pending_requests', 'display_name' => 'View Pending Requests', 'description' => 'Can view pending requests'],

            // Reports
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'description' => 'Can view reports'],
            ['name' => 'export_reports', 'display_name' => 'Export Reports', 'description' => 'Can export reports'],

            // Settings
            ['name' => 'manage_roles', 'display_name' => 'Manage Roles', 'description' => 'Can manage roles and permissions'],
            ['name' => 'manage_settings', 'display_name' => 'Manage Settings', 'description' => 'Can manage system settings'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Define roles with their permissions
        $rolePermissions = [
            'admin' => [
                'create_users', 'read_users', 'update_users', 'delete_users',
                'approve_requests', 'reject_requests', 'view_pending_requests',
                'view_reports', 'export_reports',
                'manage_roles', 'manage_settings'
            ],
            'staff' => [
                'read_users', 'create_users', 'update_users',
                'view_pending_requests', 'view_reports'
            ],
            'approver' => [
                'read_users',
                'approve_requests', 'reject_requests', 'view_pending_requests',
                'view_reports', 'export_reports'
            ],
            'resident' => [
                'read_users',
                'view_reports'
            ],
        ];

        // Create roles and assign permissions
        foreach ($rolePermissions as $roleName => $permissionNames) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                [
                    'display_name' => $this->getRoleDisplayName($roleName),
                    'description' => $this->getRoleDescription($roleName),
                ]
            );

            foreach ($permissionNames as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission && !$role->permissions()->where('permission_id', $permission->id)->exists()) {
                    $role->permissions()->attach($permission);
                }
            }
        }
    }

    private function getRoleDisplayName(string $roleName): string
    {
        return match($roleName) {
            'admin' => 'Administrator',
            'staff' => 'Barangay Staff',
            'approver' => 'Barangay Captain',
            'resident' => 'Resident',
            default => ucfirst($roleName),
        };
    }

    private function getRoleDescription(string $roleName): string
    {
        return match($roleName) {
            'admin' => 'Full system access and management',
            'staff' => 'Can manage users and view reports',
            'approver' => 'Can approve/reject requests and view reports',
            'resident' => 'Can view reports and basic information',
            default => ucfirst($roleName),
        };
    }
}
