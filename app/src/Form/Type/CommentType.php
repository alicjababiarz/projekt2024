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
 * Class CommentType.
 */
class CommentType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
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
                        'message' => 'message.email_not_blank',
                    ]),
                    new Assert\Email([
                        'message' => 'message.invalid_email_format',
                    ]),
                    new Assert\Length([
                        'max' => 64,
                        'maxMessage' => 'message.email_length',
                    ]),
                ],
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
                            'message' => 'message.nick_not_blank',
                        ]),
                        new Assert\Length([
                            'max' => 64,
                            'maxMessage' => 'message.nick_length',
                        ]),
                    ],
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
                            'message' => 'message.comment_content_not_blank',
                        ]),
                        new Assert\Length([
                            'max' => 255,
                            'maxMessage' => 'message.comment_content_length',
                        ]),
                    ],
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
                            'message' => 'message.element_not_null',
                        ]),
                    ],
                ]
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
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'comment';
    }
}
