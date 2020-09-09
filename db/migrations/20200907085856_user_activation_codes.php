<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserActivationCodes extends AbstractMigration
{
    public function up(): void
    {
        $sql = 'CREATE TABLE `users_activation_codes` (
            `id`           INT(11) NOT NULL AUTO_INCREMENT,
            `user_id`      INT(11) NOT NULL,
            `code`         VARCHAR(255) NOT NULL,
             PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ';

        $this->execute($sql);
    }

    public function down() {
        $sql = 'DROP TABLE `users`';
        $this->execute($sql);
    }
}
