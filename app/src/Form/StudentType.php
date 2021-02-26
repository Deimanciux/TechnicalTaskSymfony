<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $project = $options['project'];
        $builder->add('fullName', TextType::class)
            ->add('group', EntityType::class, [
                'class' => Group::class,
                'choices' => $project->getGroups(),
                'choice_label' => 'title'
            ])
            ->add('Add_student', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
            'project' => null,
        ]);
    }
}