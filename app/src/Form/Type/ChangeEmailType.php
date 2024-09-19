<?php

/**
 * ChangeEmail type.
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class ChangeEmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => ['label' => 'Nowy adres email'],
                'second_options' => ['label' => 'Powtórz nowy adres email'],
                'invalid_message' => 'Podane adresy email muszą być takie same',
                'required' => true,
                'attr' => [
                    'max_length' => 128,
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Adres email nie może być pusty.',
                        ]),
                        new Assert\Email([
                            'message' => 'Podaj prawidłowy adres email.',
                        ]),
                        new Assert\Length([
                            'max' => 128,
                            'maxMessage' => 'Adres email nie może być dłuższy niż 128 znaków',
                        ]),
                    ],
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
