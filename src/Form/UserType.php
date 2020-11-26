<?php

namespace App\Form;

use App\Entity\User;

use App\Form\Field\RoleSelectField;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('fonction', RoleSelectField::class)
            ->add('email')
            ->add('passwordEncod', PasswordType::class, [
                'mapped' => false,
                'invalid_message' => 'les chanps ne sont pas égaux.',
                'required' => true,
                'constraints' => [
                    new NotBlank,
                    new Length(['min' => 6])
                ]
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
