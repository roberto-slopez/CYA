<?php

namespace TS\CYABundle\Form;

use Symfony\Component\Form\AbstractType;
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
            ->add(
                'nombreImpresion',
                null,
                [
                    'label' => 'Nombre:'
                ]
            )
            ->add(
                'username',
                null,
                array(
                    'label' => 'Usuario:',
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'label' => 'Email:',
                )
            )
            ->add(
                'plainPassword',
                'repeated',
                array(
                    'type' => 'password',
                    'first_options' => array('label' => 'Contraseña'),
                    'second_options' => array('label' => 'Confirme contraseñanalis'),
                    'invalid_message' => 'fos_user.password.mismatch',
                )
            );

        if (!$this->editarCuenta) {
            $builder
                ->add( 'enabled', 'checkbox', ['label' => 'Activo'])
                ->add('roles', 'choice', [
                        'multiple' => true,
                        'attr' => ['class' => 'select2-list'],
                        'choices' => [
                            'ROLE_SUPER_ADMIN' => 'Super administrador',
                            'ROLE_ADMIN' => 'Administrador',
                            'ROLE_USER' => 'Usuario',
                        ]
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
