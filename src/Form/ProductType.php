<?php


namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del producto',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Cantidad disponible',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Precio unitario',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
