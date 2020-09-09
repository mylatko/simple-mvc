<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserMigration extends AbstractMigration
{
    public function up(): void
    {
        $sql = 'CREATE TABLE `users` (
            `id`            INT(11) NOT NULL AUTO_INCREMENT,
            `nickname`      VARCHAR(128) NOT NULL,
            `email`         VARCHAR(255) NOT NULL,
            `is_confirmed`  tinyint(1) NOT NULL DEFAULT "0",
            `role`          ENUM("user", "admin"),
            `password_hash` VARCHAR(255) NOT NULL,
            `auth_token`    VARCHAR(255) NOT NULL,
            `date`          datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
             PRIMARY KEY (`id`),
             UNIQUE KEY `nickname` (`nickname`),
             UNIQUE KEY `email` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ';

        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE `users`';
        $this->execute($sql);
    }
}
