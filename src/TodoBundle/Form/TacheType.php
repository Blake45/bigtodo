<?php

namespace TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text')
            ->add('tempsPrevu','hidden',array(
                'required'=>true
            ))
            ->add('description','textarea')
            ->add('projet','entity',array(
                'required'=>false,
                'class'=>'TodoBundle:Projet',
                'property'=>'nom'
            ))
            ->add('complexity','entity',array(
                'required'=>false,
                'class'=>'TodoBundle:Complexity',
                'property'=>'nom'
            ))
            ->add('tacheParentes','entity',array(
                'required'=>false,
                'class'=>'TodoBundle:Tache',
                'property'=>'nom'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TodoBundle\Entity\Tache'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'todobundle_tache';
    }
}
