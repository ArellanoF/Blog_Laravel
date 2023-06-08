<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Administrator']);
        $author = Role::create(['name' => 'Author']);

        //Permisos
        Permission::create([
            'name' => 'admin.index',
            'description' => 'Ver el Dashboard'
        ])->syncRoles([$admin, $author]);

        //Categorias
        Permission::create([
            'name' => 'categories.index',
            'description' => 'Ver Categorias'
        ])->syncRoles([$admin]);


        Permission::create([
            'name' => 'categories.create',
            'description' => 'Crear Categorias'
        ])->assignRole($admin);


        Permission::create([
            'name' => 'categories.edit',
            'description' => 'Editar Categorias'
        ])->assignRole($admin);


        Permission::create([
            'name' => 'categories.destroy',
            'description' => 'Eliminar Categorias'
        ])->assignRole($admin);
        
        //Articulos
        Permission::create([
            'name' => 'articles.index',
            'description' => 'Ver Artículos'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'articles.create',
            'description' => 'Crear Artículos'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'articles.edit',
            'description' => 'Editar Artículos'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'articles.destroy',
            'description' => 'Eliminar Artículos'
        ])->syncRoles([$admin, $author]);

        //Comentarios
        Permission::create([
            'name' => 'comments.index',
            'description' => 'Ver Comentario'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'comments.create',
            'description' => 'Crear Comentarios'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'comments.edit',
            'description' => 'Editar Comentarios'
        ])->syncRoles([$admin, $author]);


        Permission::create([
            'name' => 'comments.destroy',
            'description' => 'Eliminar Comentarios'
        ])->syncRoles([$admin, $author]);

        //Usuarios
        Permission::create([
            'name' => 'users.index',
            'description' => 'Ver usuarios'
        ])->assignRole($admin);


        Permission::create([
            'name' => 'users.edit',
            'description' => 'Editar usuarios'
        ])->assignRole($admin);


        Permission::create([
            'name' => 'users.destroy',
            'description' => 'Eliminar usuarios'
        ])->assignRole($admin);
    }
}
