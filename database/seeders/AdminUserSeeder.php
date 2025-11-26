<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar si ya existe un admin
        $adminExists = User::where('rol', 'admin')->exists();
        
        if (!$adminExists) {
            User::create([
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => 'admin@teamcell.com',
                'password' => Hash::make('admin123456'),
                'edad' => 30,
                'celular' => 12345678,
                'sexo' => 'M',
                'rol' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Usuario administrador creado exitosamente');
            $this->command->info('📧 Email: admin@TeamCell.com');
            $this->command->info('🔑 Contraseña: admin123456');
        } else {
            $this->command->info('ℹ️ Ya existe un usuario administrador');
        }

        // Crear algunos usuarios de ejemplo
        $users = [
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan@ejemplo.com',
                'password' => Hash::make('12345678'),
                'edad' => 25,
                'celular' => 87654321,
                'sexo' => 'M',
                'rol' => 'cliente',
                'email_verified_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'García',
                'email' => 'maria@ejemplo.com',
                'password' => Hash::make('12345678'),
                'edad' => 28,
                'celular' => 11223344,
                'sexo' => 'F',
                'rol' => 'proveedor',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }

        $this->command->info('✅ Usuarios de ejemplo creados');
    }
}