<?php
/**
 * Comment type.
 */

namespace App\Form\Type;

use App\Entity\Comment;
use App\Entity\Element;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ElementType.
 */
class CommentType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            TextType::class,
            [
                'label' => 'label.email',
                'required' => true,
                'attr' => ['max_length' => 64],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Pole email nie może być puste',
                    ]),
                    new Assert\Email([
                        'message' => 'Podaj prawidłowy adres email',
                    ]),
                    new Assert\Length([
                        'max' => 64,
                        'maxMessage' => 'Adres email nie może mieć więcej niż 64 znaki',
                    ]),
                ]
            ]
        )
            ->add(
                'nick',
                TextType::class,
                [
                    'label' => 'label.nick',
                    'required' => true,
                    'attr' => ['max_length' => 64],
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Pole nick nie może być puste.',
                        ]), new Assert\Length(
                            [
                                'max' => 64,
                                'maxMessage' => 'Nick nie może mieć więcej niż 64 znaki',
                            ]
                        )]
                ]
            )
            ->add(
                'content',
                TextType::class,
                [
                    'label' => 'label.content',
                    'required' => true,
                    'attr' => ['max_length' => 255],
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Pole treść komentarza nie może być puste',
                        ]),
                        new Assert\Length([
                            'max' => 255,
                            'maxMessage' => 'Treść komentarza nie może mieć więcej niż 255 znaków',
                        ]),
                    ]
                ]
            )

            ->add(
                'element',
                EntityType::class,
                [
                    'class' => Element::class,
                    'choice_label' => function ($element): string {
                        return $element->getTitle();
                    },
                    'label' => 'label.element',
                    'placeholder' => 'label.select_element',
                    'required' => true,
                    'constraints' => [
                        new Assert\NotNull([
                            'message' => 'Pole element nie może być puste',
                        ])
                    ]]
            );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Comment::class]);
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
        return 'comment';
    }
}
