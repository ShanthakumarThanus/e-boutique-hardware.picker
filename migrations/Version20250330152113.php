<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330152113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD utilisateur_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6EEAA67DFB88E14F ON commande (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande ADD article_id INT NOT NULL, ADD commande_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B7294869C FOREIGN KEY (article_id) REFERENCES article (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3170B74B7294869C ON ligne_commande (article_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3170B74B82EA2E54 ON ligne_commande (commande_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier ADD panier_id INT NOT NULL, ADD article_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B4F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B47294869C FOREIGN KEY (article_id) REFERENCES article (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_21691B4F77D927C ON ligne_panier (panier_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_21691B47294869C ON ligne_panier (article_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD utilisateur_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_24CC0DF2FB88E14F ON panier (utilisateur_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_24CC0DF2FB88E14F ON panier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE panier DROP utilisateur_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B4F77D927C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B47294869C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_21691B4F77D927C ON ligne_panier
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_21691B47294869C ON ligne_panier
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_panier DROP panier_id, DROP article_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6EEAA67DFB88E14F ON commande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP utilisateur_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B7294869C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3170B74B7294869C ON ligne_commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3170B74B82EA2E54 ON ligne_commande
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ligne_commande DROP article_id, DROP commande_id
        SQL);
    }
}
