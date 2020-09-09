<?php


use Phinx\Seed\AbstractSeed;

class AdminSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'nickname' => 'admin',
                'email' => 'admin@admin.admin',
                'is_confirmed' => '1',
                'role' => 'admin',
                'password_hash' => 'pass',
                'auth_token' => 'hash'
            ]
        ];
        $user = $this->table('users');
        $user->insert($data)->save();
    }
}
