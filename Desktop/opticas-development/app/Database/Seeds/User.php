<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {

        auth()
            ->getProvider()
            ->save([
            'username' => 'superuser',
            "email" => "admin@admin.com",
            'password' => password_hash('administrador', PASSWORD_DEFAULT),
        ]);
    }
}
