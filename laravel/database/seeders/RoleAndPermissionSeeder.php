<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view_dashboard',
            
            // Users
            'manage_users',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Roles
            'manage_roles',
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            
            // Permissions
            'manage_permissions',
            'view_permissions',
            'create_permissions',
            'edit_permissions',
            'delete_permissions',
            
            // Tenants
            'manage_tenants',
            'view_tenants',
            'create_tenants',
            'edit_tenants',
            'delete_tenants',
            
            // Patients
            'manage_patients',
            'view_patients',
            'create_patients',
            'edit_patients',
            'delete_patients',
            
            // Appointments
            'manage_appointments',
            'view_appointments',
            'create_appointments',
            'edit_appointments',
            'delete_appointments',
            
            // Visits
            'manage_visits',
            'view_visits',
            'create_visits',
            'edit_visits',
            'delete_visits',
            
            // Reports
            'view_reports',
            'export_reports',
            
            // Settings
            'manage_settings',
            'view_settings',
            'edit_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_dashboard',
            'manage_users',
            'view_users',
            'create_users',
            'edit_users',
            'manage_roles',
            'view_roles',
            'manage_patients',
            'view_patients',
            'create_patients',
            'edit_patients',
            'manage_appointments',
            'view_appointments',
            'create_appointments',
            'edit_appointments',
            'manage_visits',
            'view_visits',
            'create_visits',
            'edit_visits',
            'view_reports',
            'export_reports',
            'manage_settings',
            'view_settings',
            'edit_settings',
        ]);

        $doctor = Role::create(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'view_dashboard',
            'manage_patients',
            'view_patients',
            'create_patients',
            'edit_patients',
            'manage_appointments',
            'view_appointments',
            'create_appointments',
            'edit_appointments',
            'manage_visits',
            'view_visits',
            'create_visits',
            'edit_visits',
            'view_reports',
        ]);

        $assistant = Role::create(['name' => 'assistant']);
        $assistant->givePermissionTo([
            'view_dashboard',
            'view_patients',
            'manage_appointments',
            'view_appointments',
            'create_appointments',
            'view_visits',
            'view_reports',
        ]);
    }
} 