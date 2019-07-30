<?php declare(strict_types=1);

namespace Project\Database\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730121143 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE user ('
            . ' id INT AUTO_INCREMENT NOT NULL,'
            . ' name VARCHAR(255) NOT NULL,'
            . ' surname VARCHAR(255) NOT NULL,'
            . ' email VARCHAR(255) NOT NULL,'
            . ' password VARCHAR(255) NOT NULL,'
            . ' role VARCHAR(255) NOT NULL,'
            . ' UNIQUE INDEX user_email_uniq (email),'
            . ' PRIMARY KEY(id)'
            . ') DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE session ('
            . ' id VARBINARY(128) NOT NULL,'
            . ' data LONGBLOB NOT NULL,'
            . ' lifetime BIGINT NOT NULL,'
            . ' time INT UNSIGNED NOT NULL,'
            . ' PRIMARY KEY(id)'
            . ') DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
