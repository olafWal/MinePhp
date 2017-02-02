<?php

namespace AppBundle\Form;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractServerType extends AbstractType implements TranslationContainerInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'form.field.server.name'])
            ->add('description', null, ['label' => 'form.field.server.description'])
            ->add('address', null, ['label' => 'form.field.server.address'])
            ->add('port', null, ['label' => 'form.field.server.port']);
        $this->addFields($builder, $options);
    }

    abstract public function addFields(FormBuilderInterface $builder, array $options);

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\AbstractServer',
            'translation_domain' => 'forms'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_abstractserver';
    }

    public static function getTranslationMessages()
    {
        return [
            new Message('server.formtab.minecraft','forms'),
            new Message('server.formtab.bungee', 'forms')
        ];
    }
}
