<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250228163214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('users');
        $table->addColumn('id', 'string', ['length' => 255]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('email', 'string', ['length' => 180]);
        $table->addColumn('password', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', ['notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id']);
        $table->addUniqueIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('users');
    }
}
