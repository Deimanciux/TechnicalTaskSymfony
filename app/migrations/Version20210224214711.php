<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224214711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5166D1F9C ON `group` (project_id)');
        $this->addSql('ALTER TABLE project ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE41807E1D ON project (teacher_id)');
        $this->addSql('ALTER TABLE student ADD group_id INT NOT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33FE54D947 ON student (group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5166D1F9C');
        $this->addSql('DROP INDEX IDX_6DC044C5166D1F9C ON `group`');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE41807E1D');
        $this->addSql('DROP INDEX IDX_2FB3D0EE41807E1D ON project');
        $this->addSql('ALTER TABLE project DROP teacher_id');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33FE54D947');
        $this->addSql('DROP INDEX IDX_B723AF33FE54D947 ON student');
        $this->addSql('ALTER TABLE student DROP group_id');
    }
}
