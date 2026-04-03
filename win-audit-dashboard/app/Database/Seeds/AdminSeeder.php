<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userData = [
            'username' => 'admin',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role'     => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Using Query Builder
        $this->db->table('users')->insert($userData);

        // Initial Settings
        $settingsData = [
            [
                'key'      => 'theme_name',
                'value'    => 'vscode-dark',
                'category' => 'theme',
            ],
            [
                'key'      => 'app_name',
                'value'    => 'WinAudit Dashboard',
                'category' => 'system',
            ],
        ];
        $this->db->table('settings')->insertBatch($settingsData);
    }
}
