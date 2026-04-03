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

        // Check if admin already exists
        $userExists = $this->db->table('users')->where('username', 'admin')->countAllResults();

        if ($userExists === 0) {
            $this->db->table('users')->insert($userData);
            echo "Admin user created.\n";
        } else {
            echo "Admin user already exists. Skipping...\n";
        }

        // Initial Settings - check if they exist individually or just check one
        $settingsExist = $this->db->table('settings')->where('key', 'theme_name')->countAllResults();
        
        if ($settingsExist === 0) {
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
            echo "Initial settings seeded.\n";
        } else {
            echo "Settings already seeded. Skipping...\n";
        }
    }
}
