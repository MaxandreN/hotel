<?php

namespace App\Form\Field;

use PhpParser\Parser\Multiple;
use Proxies\__CG__\App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutSelectField extends EntityType {
        
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'class' => \App\Entity\Statut::class,
            'multiple' => false,
            'choice_label' => 'label',
        ]);
    }
}