<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MinecraftServerType extends AbstractServerType
{
    /**
     * {@inheritdoc}
     */
    public function addFields(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('queryPort', null, ['required' => false, 'label' => 'form.field.server.queryPort'])
            ->add('rconPort', null, ['required' => false, 'label' => 'form.field.server.rconPort'])
            ->add('rconPassword', null, ['required' => false, 'label' => 'form.field.server.rconPassword']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MinecraftServer',
            'translation_domain' => 'forms'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_minecraftserver';
    }
}
