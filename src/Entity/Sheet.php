<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Sheet
 *
 * @ORM\Table(name="sheet")
 * @ORM\Entity
 */
class Sheet
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="kayittarihi", type="datetime", nullable=true)
     */
    private $kayittarihi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cagriyapan", type="string", length=255, nullable=true)
     */
    private $cagriyapan;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cagriyolu", type="string", length=255, nullable=true)
     */
    private $cagriyolu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cagrinedeni", type="string", length=255, nullable=true)
     */
    private $cagrinedeni;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sokak", type="string", length=255, nullable=true)
     */
    private $sokak;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mahalle", type="string", length=255, nullable=true)
     */
    private $mahalle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ilce", type="string", length=255, nullable=true)
     */
    private $ilce;





    /**
     * @var string|null
     *
     * @ORM\Column(name="cinsiyet", type="string", length=255, nullable=true)
     */
    private $cinsiyet;

    /**
     * @var float|null
     *
     * @ORM\Column(name="yas", type="float", precision=10, scale=0, nullable=true)
     */
    private $yas;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sosyal_guvence", type="string", length=255, nullable=true)
     */
    private $sosyalGuvence;

    /**
     * @var string|null
     *
     * @ORM\Column(name="oncelik", type="string", length=255, nullable=true)
     */
    private $oncelik;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ekhasta", type="string", length=255, nullable=true)
     */
    private $ekhasta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bilinc", type="string", length=255, nullable=true)
     */
    private $bilinc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bilincdurumu", type="string", length=255, nullable=true)
     */
    private $bilincdurumu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pupiler", type="string", length=255, nullable=true)
     */
    private $pupiler;

    /**
     * @var string|null
     *
     * @ORM\Column(name="solunum", type="string", length=255, nullable=true)
     */
    private $solunum;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cilt", type="string", length=255, nullable=true)
     */
    private $cilt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="diger", type="string", length=255, nullable=true)
     */
    private $diger;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sistolik", type="string", length=255, nullable=true)
     */
    private $sistolik;

    /**
     * @var string|null
     *
     * @ORM\Column(name="diastolik", type="string", length=255, nullable=true)
     */
    private $diastolik;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tani", type="string", length=255, nullable=true)
     */
    private $tani;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tani2", type="string", length=255, nullable=true)
     */
    private $tani2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mudahale", type="text", length=0, nullable=true)
     */
    private $mudahale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hastane", type="string", length=255, nullable=true)
     */
    private $hastane;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kentselkirsal", type="string", length=255, nullable=true)
     */
    private $kentselkirsal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ekipno", type="string", length=255, nullable=true)
     */
    private $ekipno;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kendibolgesi", type="string", length=255, nullable=true)
     */
    private $kendibolgesi;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cikisKM", type="string", length=255, nullable=true)
     */
    private $cikiskm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="VarisKM", type="string", length=255, nullable=true)
     */
    private $variskm;

    /**
     * @var string|null
     *
     * @ORM\Column(name="kmfark", type="string", length=255, nullable=true)
     */
    private $kmfark;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="cagriZamani", type="datetime", nullable=true)
     */
    private $cagrizamani;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="vakaVerisZamani", type="datetime", nullable=true)
     */
    private $vakaveriszamani;

    /**
     * @var \DateTime|null
    *
     * @ORM\Column(name="HareketZamani", type="datetime", nullable=true)
     */
    private $hareketzamani;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="BulusmaZamani", type="datetime", nullable=true)
     */
    private $bulusmazamani;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="varisZamani", type="datetime", nullable=true)
     */
    private $variszamani;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ayrilisZamani", type="datetime", nullable=true)
     */
    private $ayriliszamani;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="varis", type="datetime", nullable=true)
     */
    private $varis;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ayrilis", type="datetime", nullable=true)
     */
    private $ayrilis;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="donus", type="datetime", nullable=true)
     */
    private $donus;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Reaksiyon", type="float", precision=10, scale=0, nullable=true)
     */
    private $reaksiyon;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Ulasim", type="float", precision=10, scale=0, nullable=true)
     */
    private $ulasim;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Mesguliyet", type="float", precision=10, scale=0, nullable=true)
     */
    private $mesguliyet;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Toplam", type="float", precision=10, scale=0, nullable=true)
     */
    private $toplam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Sonuc", type="string", length=255, nullable=true)
     */
    private $sonuc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gitmeligitmemeli", type="string", length=255, nullable=true)
     */
    private $gitmeligitmemeli;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="yatiszamani", type="datetime", nullable=true)
     */
    private $yatiszamani;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKayittarihi(): ?\DateTimeInterface
    {
        return $this->kayittarihi;
    }

    public function setKayittarihi(?\DateTimeInterface $kayittarihi): self
    {
        $this->kayittarihi = $kayittarihi;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getCagriyapan(): ?string
    {
        return $this->cagriyapan;
    }

    public function setCagriyapan(?string $cagriyapan): self
    {
        $this->cagriyapan = $cagriyapan;

        return $this;
    }

    public function getCagriyolu(): ?string
    {
        return $this->cagriyolu;
    }

    public function setCagriyolu(?string $cagriyolu): self
    {
        $this->cagriyolu = $cagriyolu;

        return $this;
    }

    public function getCagrinedeni(): ?string
    {
        return $this->cagrinedeni;
    }

    public function setCagrinedeni(?string $cagrinedeni): self
    {
        $this->cagrinedeni = $cagrinedeni;

        return $this;
    }

    public function getSokak(): ?string
    {
        return $this->sokak;
    }

    public function setSokak(?string $sokak): self
    {
        $this->sokak = $sokak;

        return $this;
    }

    public function getMahalle(): ?string
    {
        return $this->mahalle;
    }

    public function setMahalle(?string $mahalle): self
    {
        $this->mahalle = $mahalle;

        return $this;
    }

    public function getIlce(): ?string
    {
        return $this->ilce;
    }

    public function setIlce(?string $ilce): self
    {
        $this->ilce = $ilce;

        return $this;
    }





    public function getCinsiyet(): ?string
    {
        return $this->cinsiyet;
    }

    public function setCinsiyet(?string $cinsiyet): self
    {
        $this->cinsiyet = $cinsiyet;

        return $this;
    }

    public function getYas(): ?float
    {
        return $this->yas;
    }

    public function setYas(?float $yas): self
    {
        $this->yas = $yas;

        return $this;
    }

    public function getSosyalGuvence(): ?string
    {
        return $this->sosyalGuvence;
    }

    public function setSosyalGuvence(?string $sosyalGuvence): self
    {
        $this->sosyalGuvence = $sosyalGuvence;

        return $this;
    }

    public function getOncelik(): ?string
    {
        return $this->oncelik;
    }

    public function setOncelik(?string $oncelik): self
    {
        $this->oncelik = $oncelik;

        return $this;
    }

    public function getEkhasta(): ?string
    {
        return $this->ekhasta;
    }

    public function setEkhasta(?string $ekhasta): self
    {
        $this->ekhasta = $ekhasta;

        return $this;
    }

    public function getBilinc(): ?string
    {
        return $this->bilinc;
    }

    public function setBilinc(?string $bilinc): self
    {
        $this->bilinc = $bilinc;

        return $this;
    }

    public function getBilincdurumu(): ?string
    {
        return $this->bilincdurumu;
    }

    public function setBilincdurumu(?string $bilincdurumu): self
    {
        $this->bilincdurumu = $bilincdurumu;

        return $this;
    }

    public function getPupiler(): ?string
    {
        return $this->pupiler;
    }

    public function setPupiler(?string $pupiler): self
    {
        $this->pupiler = $pupiler;

        return $this;
    }

    public function getSolunum(): ?string
    {
        return $this->solunum;
    }

    public function setSolunum(?string $solunum): self
    {
        $this->solunum = $solunum;

        return $this;
    }

    public function getCilt(): ?string
    {
        return $this->cilt;
    }

    public function setCilt(?string $cilt): self
    {
        $this->cilt = $cilt;

        return $this;
    }

    public function getDiger(): ?string
    {
        return $this->diger;
    }

    public function setDiger(?string $diger): self
    {
        $this->diger = $diger;

        return $this;
    }

    public function getSistolik(): ?string
    {
        return $this->sistolik;
    }

    public function setSistolik(?string $sistolik): self
    {
        $this->sistolik = $sistolik;

        return $this;
    }

    public function getDiastolik(): ?string
    {
        return $this->diastolik;
    }

    public function setDiastolik(?string $diastolik): self
    {
        $this->diastolik = $diastolik;

        return $this;
    }

    public function getTani(): ?string
    {
        return $this->tani;
    }

    public function setTani(?string $tani): self
    {
        $this->tani = $tani;

        return $this;
    }

    public function getTani2(): ?string
    {
        return $this->tani2;
    }

    public function setTani2(?string $tani2): self
    {
        $this->tani2 = $tani2;

        return $this;
    }

    public function getMudahale(): ?string
    {
        return $this->mudahale;
    }

    public function setMudahale(?string $mudahale): self
    {
        $this->mudahale = $mudahale;

        return $this;
    }

    public function getHastane(): ?string
    {
        return $this->hastane;
    }

    public function setHastane(?string $hastane): self
    {
        $this->hastane = $hastane;

        return $this;
    }

    public function getKentselkirsal(): ?string
    {
        return $this->kentselkirsal;
    }

    public function setKentselkirsal(?string $kentselkirsal): self
    {
        $this->kentselkirsal = $kentselkirsal;

        return $this;
    }

    public function getEkipno(): ?string
    {
        return $this->ekipno;
    }

    public function setEkipno(?string $ekipno): self
    {
        $this->ekipno = $ekipno;

        return $this;
    }

    public function getKendibolgesi(): ?string
    {
        return $this->kendibolgesi;
    }

    public function setKendibolgesi(?string $kendibolgesi): self
    {
        $this->kendibolgesi = $kendibolgesi;

        return $this;
    }

    public function getCikiskm(): ?string
    {
        return $this->cikiskm;
    }

    public function setCikiskm(?string $cikiskm): self
    {
        $this->cikiskm = $cikiskm;

        return $this;
    }

    public function getVariskm(): ?string
    {
        return $this->variskm;
    }

    public function setVariskm(?string $variskm): self
    {
        $this->variskm = $variskm;

        return $this;
    }

    public function getKmfark(): ?string
    {
        return $this->kmfark;
    }

    public function setKmfark(?string $kmfark): self
    {
        $this->kmfark = $kmfark;

        return $this;
    }

    public function getCagrizamani(): ?\DateTimeInterface
    {
        return $this->cagrizamani;
    }

    public function setCagrizamani(?\DateTimeInterface $cagrizamani): self
    {
        $this->cagrizamani = $cagrizamani;

        return $this;
    }

    public function getVakaveriszamani(): ?\DateTimeInterface
    {
        return $this->vakaveriszamani;
    }

    public function setVakaveriszamani(?\DateTimeInterface $vakaveriszamani): self
    {
        $this->vakaveriszamani = $vakaveriszamani;

        return $this;
    }

    public function getHareketzamani(): ?\DateTimeInterface
    {
        return $this->hareketzamani;
    }

    public function setHareketzamani(?\DateTimeInterface $hareketzamani): self
    {
        $this->hareketzamani = $hareketzamani;

        return $this;
    }

    public function getBulusmazamani(): ?\DateTimeInterface
    {
        return $this->bulusmazamani;
    }

    public function setBulusmazamani(?\DateTimeInterface $bulusmazamani): self
    {
        $this->bulusmazamani = $bulusmazamani;

        return $this;
    }

    public function getVariszamani(): ?\DateTimeInterface
    {
        return $this->variszamani;
    }

    public function setVariszamani(?\DateTimeInterface $variszamani): self
    {
        $this->variszamani = $variszamani;

        return $this;
    }

    public function getAyriliszamani(): ?\DateTimeInterface
    {
        return $this->ayriliszamani;
    }

    public function setAyriliszamani(?\DateTimeInterface $ayriliszamani): self
    {
        $this->ayriliszamani = $ayriliszamani;

        return $this;
    }

    public function getVaris(): ?\DateTimeInterface
    {
        return $this->varis;
    }

    public function setVaris(?\DateTimeInterface $varis): self
    {
        $this->varis = $varis;

        return $this;
    }

    public function getAyrilis(): ?\DateTimeInterface
    {
        return $this->ayrilis;
    }

    public function setAyrilis(?\DateTimeInterface $ayrilis): self
    {
        $this->ayrilis = $ayrilis;

        return $this;
    }

    public function getDonus(): ?\DateTimeInterface
    {
        return $this->donus;
    }

    public function setDonus(?\DateTimeInterface $donus): self
    {
        $this->donus = $donus;

        return $this;
    }

    public function getReaksiyon(): ?float
    {
        return $this->reaksiyon;
    }

    public function setReaksiyon(?float $reaksiyon): self
    {
        $this->reaksiyon = $reaksiyon;

        return $this;
    }

    public function getUlasim(): ?float
    {
        return $this->ulasim;
    }

    public function setUlasim(?float $ulasim): self
    {
        $this->ulasim = $ulasim;

        return $this;
    }

    public function getMesguliyet(): ?float
    {
        return $this->mesguliyet;
    }

    public function setMesguliyet(?float $mesguliyet): self
    {
        $this->mesguliyet = $mesguliyet;

        return $this;
    }

    public function getToplam(): ?float
    {
        return $this->toplam;
    }

    public function setToplam(?float $toplam): self
    {
        $this->toplam = $toplam;

        return $this;
    }

    public function getSonuc(): ?string
    {
        return $this->sonuc;
    }

    public function setSonuc(?string $sonuc): self
    {
        $this->sonuc = $sonuc;

        return $this;
    }

    public function getGitmeligitmemeli(): ?string
    {
        return $this->gitmeligitmemeli;
    }

    public function setGitmeligitmemeli(?string $gitmeligitmemeli): self
    {
        $this->gitmeligitmemeli = $gitmeligitmemeli;

        return $this;
    }

    public function getYatiszamani(): ?\DateTimeInterface
    {
        return $this->yatiszamani;
    }

    public function setYatiszamani(?\DateTimeInterface $yatiszamani): self
    {
        $this->yatiszamani = $yatiszamani;

        return $this;
    }


}
