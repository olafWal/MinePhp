<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType implements TranslationContainerInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $passRequired = true;
        if ($builder->getData()->getId()) {
            $passRequired = false;
        }

        $builder
            ->add('username', null, ['label' => 'field.user.name'])
            ->add('email', null, ['label' => 'field.user.email'])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'field.user.roles',
                'choices' => [
                    'role.user' => User::ROLE_DEFAULT,
                    'role.admin' => User::ROLE_ADMIN,
                    'role.superadmin' => User::ROLE_SUPER_ADMIN
                ]
            ])
            /* Some browsers always fill the password field even if autocomplete is set to off
             * So we give them sandbox here to play with ....
            */

            ->add('hack_to_avoid_autofill',PasswordType::class, ['required' => false, 'mapped' => false, 'attr'=> ['class' => 'hidden']])
            ->add('password', RepeatedType::class, [
                    'mapped' => false,
                    'type' => PasswordType::class,
                    'invalid_message' => 'password.mismatch',
                    'options' => ['attr' => ['class' => 'form-control']],
                    'required' => $passRequired,
                    'first_options' => ['label' => 'field.password', 'always_empty' => true, 'attr' => ['autocomplete' => 'off']],
                    'second_options' => ['label' => 'field.password.repeat']
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'translation_domain' => 'forms'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }

    /**
     * Returns an array of messages.
     *
     * @return array<Message>
     */
    public static function getTranslationMessages()
    {
        return [
            new Message('password.mismatch','validators')
        ];
    }
}
