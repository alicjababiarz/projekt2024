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
 * Change email form type
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
                'first_options' => ['label' => 'label.new_email'],
                'second_options' => ['label' => 'label.repeat_new_email'],
                'invalid_message' => 'message.emails_must_match',
                'required' => true,
                'attr' => [
                    'max_length' => 128,
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'message.email_not_blank',
                    ]),
                    new Assert\Email([
                        'message' => 'message.invalid_email_format',
                    ]),
                    new Assert\Length([
                        'max' => 128,
                        'maxMessage' => 'message.email_length',
                    ]),
                ],
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
