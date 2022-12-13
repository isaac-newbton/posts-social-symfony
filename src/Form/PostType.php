<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Content cannot be empty'
                    ]),
                    new Length([
                        'min'=>1,
                        'minMessage'=>'Posts must be at least {{ limit }} character',
                        'max'=>140,
                        'maxMessage'=>'Posts cannot exceed {{ limit }} characters'
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-blue'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
