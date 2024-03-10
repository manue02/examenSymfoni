<?php

namespace App\Form;

use App\Entity\Empleado;
use App\Entity\Factura;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class FacturaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total', null, [
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('estadoPago', CheckboxType::class, [
                'attr' => ['class' => 'form-check-input mb-2']
            ])
            ->add('fechaEmision', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control mb-2']
            ])
            ->add('idEmpleado', EntityType::class, [
                'class' => Empleado::class,
                'choice_label' => function (Empleado $empleado) {
                    return $empleado->getId() . ' - ' . $empleado->getNombre();
                },
                'attr' => ['class' => 'form-control mb-4']
            ])
            ->add('guardar', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
                'label' => 'Insertar Factura'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Factura::class,
        ]);
    }
}
