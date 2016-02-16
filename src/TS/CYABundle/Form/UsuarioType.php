<?php

namespace TS\CYABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UsuarioType
 * @package TS\CYABundle\Form
 */
class UsuarioType extends AbstractType
{
    /**
     * @var bool
     */
    protected $editarCuenta;

    /**
     * @param bool $bool
     */
    public function __construct($bool = false)
    {
        $this->editarCuenta = $bool;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('nombreImpresion', TextType::class, ['label' => 'Name'])
            ->add('username', TextType::class, ['label' => 'User name'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Confirm password'],
                    'invalid_message' => 'fos_user.password.mismatch',
                ]
            );

        if (!$this->editarCuenta) {
            $builder
                ->add('enabled', CheckboxType::class)
                ->add(
                    'roles',
                    ChoiceType::class,
                    [
                        'multiple' => true,
                        'attr' => ['class' => 'select-chosen'],
                        'choices' => [
                            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                            'ROLE_ADMIN' => 'ROLE_ADMIN',
                            'ROLE_USER' => 'ROLE_USER',
                            'ROLE_SELLER' => 'ROLE_SELLER',
                        ],
                    ]
                );
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Usuario',
            'intention' => 'registration',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ts_usuario_type';
    }
}
