<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => 'App\Entity\Users',
                'choice_label' => 'name', // Assuming 'name' is the property that represents the user's name
                'label' => 'Usuario del pedido',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('shippingAddress', TextType::class, [
                'label' => 'Dirección de envío',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('total', NumberType::class, [
                'label' => 'Total del pedido',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductOrderType::class, // Assuming you create a form type for the products
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Crear Pedido',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
