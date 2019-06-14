<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190401202507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sheet ADD kayittarihi DATETIME DEFAULT NULL, ADD tel VARCHAR(255) DEFAULT NULL, ADD cagriyapan VARCHAR(255) DEFAULT NULL, ADD cagriyolu VARCHAR(255) DEFAULT NULL, ADD cagrinedeni VARCHAR(255) DEFAULT NULL, ADD adres VARCHAR(255) DEFAULT NULL, ADD adsoyad VARCHAR(255) DEFAULT NULL, ADD ekhasta VARCHAR(255) DEFAULT NULL, ADD bilincdurumu VARCHAR(255) DEFAULT NULL, ADD kentselkirsal VARCHAR(255) DEFAULT NULL, ADD ekipno VARCHAR(255) DEFAULT NULL, ADD kendibolgesi VARCHAR(255) DEFAULT NULL, ADD cikisKM VARCHAR(255) DEFAULT NULL, ADD VarisKM VARCHAR(255) DEFAULT NULL, ADD kmfark VARCHAR(255) DEFAULT NULL, ADD cagriZamani DATETIME DEFAULT NULL, ADD vakaVerisZamani DATETIME DEFAULT NULL, ADD HareketZamani DATETIME DEFAULT NULL, ADD BulusmaZamani DATETIME DEFAULT NULL, ADD varisZamani DATETIME DEFAULT NULL, ADD ayrilisZamani DATETIME DEFAULT NULL, ADD varis DATETIME DEFAULT NULL, ADD ayrilis DATETIME DEFAULT NULL, ADD donus DATETIME DEFAULT NULL, ADD Reaksiyon DOUBLE PRECISION DEFAULT NULL, ADD Ulasim DOUBLE PRECISION DEFAULT NULL, ADD Mesguliyet DOUBLE PRECISION DEFAULT NULL, ADD Toplam DOUBLE PRECISION DEFAULT NULL, ADD gitmeligitmemeli VARCHAR(255) DEFAULT NULL, ADD yatiszamani DATETIME DEFAULT NULL, DROP kayit_tarihi, DROP tel_no, DROP cagri_yapan, DROP cagri_yolu, DROP cagri_nedeni, DROP ek_hasta, DROP Bilinc_ne_durumda, DROP kentsel/kirsal, DROP ekip_no, DROP kendi_bolgesi?, DROP cikis_KM, DROP Varis_KM, DROP cks_vrs_kmFark, DROP cagri_Zamani, DROP Vaka_Veris_Zamani, DROP Hareket_Zamani, DROP Bulusma_Zamani, DROP Olay_Yerine_Varis_Zamani, DROP Olay_Yeri_Ayrilis_Zamani, DROP Hastaneye Varis Zamani, DROP Hastaneden Ayrilis Zamani, DROP Istasyona Donus Zamani, DROP Reaksiyon(sn), DROP Ulasim(sn), DROP Mesguliyet(sn), DROP Toplam(sn), DROP gitmeli / gitmemeli, DROP Hasta Yatis Zamani, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE tibbi mudahale mudahale LONGTEXT DEFAULT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sheet MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE sheet DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sheet ADD kayit_tarihi DATETIME DEFAULT NULL, ADD tel_no VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cagri_yapan VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cagri_yolu VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cagri_nedeni VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD ek_hasta VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD Bilinc_ne_durumda VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD kentsel/kirsal VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD ekip_no VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD kendi_bolgesi? VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cikis_KM VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD Varis_KM VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cks_vrs_kmFark VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD cagri_Zamani DATETIME DEFAULT NULL, ADD Vaka_Veris_Zamani DATETIME DEFAULT NULL, ADD Hareket_Zamani DATETIME DEFAULT NULL, ADD Bulusma_Zamani DATETIME DEFAULT NULL, ADD Olay_Yerine_Varis_Zamani DATETIME DEFAULT NULL, ADD Olay_Yeri_Ayrilis_Zamani DATETIME DEFAULT NULL, ADD Hastaneye Varis Zamani DATETIME DEFAULT NULL, ADD Hastaneden Ayrilis Zamani DATETIME DEFAULT NULL, ADD Istasyona Donus Zamani DATETIME DEFAULT NULL, ADD Reaksiyon(sn) DOUBLE PRECISION DEFAULT NULL, ADD Ulasim(sn) DOUBLE PRECISION DEFAULT NULL, ADD Mesguliyet(sn) DOUBLE PRECISION DEFAULT NULL, ADD Toplam(sn) DOUBLE PRECISION DEFAULT NULL, ADD gitmeli / gitmemeli VARCHAR(255) DEFAULT NULL COLLATE latin1_swedish_ci, ADD Hasta Yatis Zamani DATETIME DEFAULT NULL, DROP kayittarihi, DROP tel, DROP cagriyapan, DROP cagriyolu, DROP cagrinedeni, DROP adres, DROP adsoyad, DROP ekhasta, DROP bilincdurumu, DROP kentselkirsal, DROP ekipno, DROP kendibolgesi, DROP cikisKM, DROP VarisKM, DROP kmfark, DROP cagriZamani, DROP vakaVerisZamani, DROP HareketZamani, DROP BulusmaZamani, DROP varisZamani, DROP ayrilisZamani, DROP varis, DROP ayrilis, DROP donus, DROP Reaksiyon, DROP Ulasim, DROP Mesguliyet, DROP Toplam, DROP gitmeligitmemeli, DROP yatiszamani, CHANGE id id DOUBLE PRECISION DEFAULT NULL, CHANGE mudahale Tibbi Mudahale LONGTEXT DEFAULT NULL COLLATE latin1_swedish_ci');
    }
}
