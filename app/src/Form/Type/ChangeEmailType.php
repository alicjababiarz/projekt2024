<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

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

            ->add('currentEmail', EmailType::class, [
                'mapped' => false,
                'label' => 'label.current_email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'message.enter_current_email',
                    ]),
                    new Email([
                        'message' => 'message.invalid_email_format',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.new_email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'message.enter_new_email',
                    ]),
                    new Email([
                        'message' => 'message.invalid_email_format',
                    ]),
                    ]
            ]);
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'user';
    }
}
