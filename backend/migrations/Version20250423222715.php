<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423222715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociation DROP INDEX UNIQ_B5E137D8A76ED395, ADD INDEX IDX_B5E137D8A76ED395 (user_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_negociation_per_user_room ON negociation (user_id, room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociation DROP INDEX IDX_B5E137D8A76ED395, ADD UNIQUE INDEX UNIQ_B5E137D8A76ED395 (user_id)');
        $this->addSql('DROP INDEX unique_negociation_per_user_room ON negociation');
    }
}
