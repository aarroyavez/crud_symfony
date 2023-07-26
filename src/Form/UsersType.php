<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nombre",
                "attr" => [
                    "placeholder" => "Nombre",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('username', TextType::class, [
                "label" => "Nombre de usuario",
                "attr" => [
                    "placeholder" => "Nombre de usuario",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('password', PasswordType::class, [
                "label" => "Contraseña",
                "attr" => [
                    "placeholder" => "Contraseña",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('address', TextType::class, [
                "label" => "Dirección",
                "attr" => [
                    "placeholder" => "Dirección",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('phone', TextType::class, [
                "label" => "Teléfono",
                "attr" => [
                    "placeholder" => "Teléfono",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Correo electrónico",
                "attr" => [
                    "placeholder" => "Correo electrónico",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add('authn_data', CheckboxType::class, [
                "label" => "Datos de autorización",
                "attr" => [
                    "placeholder" => "Datos de autorización",
                    "autocomplete" => "off",
                    "class" => "form-control",
                    "required" => true
                ]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Guardar",
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
