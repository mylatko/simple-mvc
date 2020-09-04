<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitMigration extends AbstractMigration
{
    public function up()
    {
        $sql = 'CREATE TABLE `news` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title`     VARCHAR(512) NOT NULL,
            `slug`      VARCHAR(512) NULL,
            `status`    INT NULL,
            `date`      datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `content`   TEXT NULL,
            `image`     VARCHAR(512) NULL,
             PRIMARY KEY (`id`),
             UNIQUE KEY `slug` (`slug`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ';

        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'DROP TABLE `news`';
        $this->execute($sql);
    }
}
