<?php

namespace App\Form;

use App\Entity\Sheet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SheetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder ,array $options)
    {
        $builder
            ->add('kayittarihi')
            ->add('tel')
            ->add('cagriyapan')
            ->add('cagriyolu')
            ->add('cagrinedeni')
            ->add('sokak')
            ->add('mahalle')
            ->add('ilce')
            ->add('cinsiyet')
            ->add('yas')
            ->add('sosyalGuvence')
            ->add('oncelik')
            ->add('ekhasta')
            ->add('bilinc')
            ->add('bilincdurumu')
            ->add('pupiler')
            ->add('solunum')
            ->add('cilt')
            ->add('diger')
            ->add('sistolik')
            ->add('diastolik')
            ->add('tani')
            ->add('tani2')
            ->add('mudahale')
            ->add('hastane')
            ->add('kentselkirsal')
            ->add('ekipno')
            ->add('kendibolgesi')
            ->add('cikiskm')
            ->add('variskm')
            ->add('kmfark')
            ->add('cagrizamani')
            ->add('vakaveriszamani')
            ->add('hareketzamani')
            ->add('bulusmazamani')
            ->add('variszamani')
            ->add('ayriliszamani')
            ->add('varis')
            ->add('ayrilis')
            ->add('donus')
            ->add('reaksiyon')
            ->add('ulasim')
            ->add('mesguliyet')
            ->add('toplam')
            ->add('sonuc')
            ->add('gitmeligitmemeli')
            ->add('yatiszamani')
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sheet::class,
        ]);
    }


}
