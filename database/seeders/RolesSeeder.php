<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de permisos
        $permisos = [
            'events.view', 'events.create', 'events.update', 'events.delete',
            'attendance.manage',
            'certificates.issue', 'certificates.view-any', 'certificates.view-own',
            'participants.import', 'participants.manage',
        ];

        // Crear permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::findOrCreate($permiso);
        }

        $this->command->info('Permisos creados correctamente.');

        // Crear roles
        $admin = Role::findOrCreate('Administrador');
        $coordinador = Role::findOrCreate('Coordinador');
        $participante = Role::findOrCreate('Participante');

        $this->command->info('Roles creados correctamente.');

        // Asignar permisos a roles
        $admin->syncPermissions($permisos);

        $coordinador->syncPermissions([
            'events.view', 'events.create', 'events.update', 'events.delete',
            'attendance.manage',
            'certificates.issue',
        ]);

        $participante->syncPermissions([
            'certificates.view-own',
        ]);

        $this->command->info('Permisos asignados a los roles correctamente.');

        // Asignar el rol "Administrador" al primer usuario
        $user = User::first();

        if ($user && !$user->hasRole('Administrador')) {
            $user->assignRole('Administrador');
            $this->command->info("Rol 'Administrador' asignado al usuario: {$user->email}");
        } else {
            $this->command->warn('No se encontró un usuario para asignar el rol o ya tiene el rol.');
        }
    }
}
