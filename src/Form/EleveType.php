<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\User;
use App\Entity\Classe;
use App\Repository\UserRepository;
use App\Repository\ClasseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photoFile',FileType::class,[
            "mapped" =>false,
            "constraints" =>[
                new File([
                    "maxSize"=>"2M",
                    "mimeTypes"=>[
                        "image/jpg",
                        "image/png",
                    ]
                    
                    ])
            ]
            ])
            ->add('nom')
            ->add('prenom')
            ->add('matricule')
            ->add('parent',EntityType::class,[
                "class"=>User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->andWhere('u.isParent = :isParent')
                    ->setParameter('isParent', true)
                        ->orderBy('u.nom', 'ASC');
                },
           "choice_label"=>"nom"
            ])
            ->add('classe',EntityType::class,[

                "class"=>Classe::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    
                        ->orderBy('u.id', 'ASC');
                },
           "choice_label"=>"nom"

            
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
