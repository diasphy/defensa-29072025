<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Socio;
use App\Models\Garante;
use App\Models\SolicitudCredito;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando el seeding de la base de datos...');

        // -- 1. CREACIÓN DE ROLES Y USUARIOS --
        $this->command->info('📝 Creando rol y usuario administrador...');
        $adminRole = Role::firstOrCreate(['name' => 'admin'], [
            'is_active' => true
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // -- 2. CREACIÓN DE MENÚS Y SUBMENÚS --
        $this->command->info('🏗️ Creando estructura de menús...');
        
        // Menú Principal: Dashboard
        $dashboardMenu = Menu::firstOrCreate(['name' => 'Dashboard'], [
            'route' => 'dashboard',
            'icon' => 'fa-solid fa-house',
            'order' => 1,
            'is_active' => true,
        ]);

        $homeSubMenu = SubMenu::firstOrCreate(['route' => 'dashboard'], [
            'menu_id' => $dashboardMenu->id,
            'name' => 'Inicio',
            'description' => 'Vista principal del sistema',
            'icon' => 'fa-solid fa-home',
            'is_active' => true,
            'order' => 1,
        ]);

        // Menú Principal: Valoracion
        $valoracionMenu = Menu::firstOrCreate(['name' => 'Valoracion'], [
            'icon' => 'fa-solid fa-hand-holding-dollar',
            'order' => 2,
            'is_active' => true,
        ]);

        $valoracionsubmenu = SubMenu::firstOrCreate(['route' => 'Valoracion.index'], [
            'menu_id' => $valoracionMenu->id,
            'name' => 'Valoracion',
            'description' => 'Valoracion',
            'icon' => 'fa-solid fa-file-invoice-dollar',
            'is_active' => true,
            'order' => 1,
        ]);

        // -- 3. ASIGNACIÓN DE PERMISOS --
        $this->command->info('🔐 Asignando permisos al rol de administrador...');
        $adminRole->subMenus()->sync([
            $homeSubMenu->id => ['is_active' => true],
            $valoracionsubmenu->id => ['is_active' => true]
        ]);

        
        $this->command->info('✅ Seeding completado exitosamente!');
        $this->command->info('📧 Usuario: admin@gmail.com');
        $this->command->info('🔑 Contraseña: password');
    }
}