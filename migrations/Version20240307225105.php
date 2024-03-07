<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307225105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, puesto VARCHAR(50) NOT NULL, apellido VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factura (id_factura INT AUTO_INCREMENT NOT NULL, total INT NOT NULL, estado_pago TINYINT(1) NOT NULL, fecha_emision DATE NOT NULL, idEmpleado INT NOT NULL, INDEX IDX_F9EBA0098A7A9509 (idEmpleado), PRIMARY KEY(id_factura)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicio (id_servicio INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, precio DOUBLE PRECISION NOT NULL, disponibilidad TINYINT(1) NOT NULL, idEmpleado INT NOT NULL, INDEX IDX_CB86F22A8A7A9509 (idEmpleado), PRIMARY KEY(id_servicio)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0098A7A9509 FOREIGN KEY (idEmpleado) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE servicio ADD CONSTRAINT FK_CB86F22A8A7A9509 FOREIGN KEY (idEmpleado) REFERENCES empleado (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0098A7A9509');
        $this->addSql('ALTER TABLE servicio DROP FOREIGN KEY FK_CB86F22A8A7A9509');
        $this->addSql('DROP TABLE empleado');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
