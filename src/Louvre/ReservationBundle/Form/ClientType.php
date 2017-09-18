<?php

namespace Louvre\ReservationBundle\Form;

use Louvre\ReservationBundle\Validator\Constraints\ContainsLettersAndAccents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, array(
                'label'         => 'Prénom',
                'attr'          => ['placeholder' => 'Prénom'],
                'required'      => true,
                'constraints'   => [
                    new ContainsLettersAndAccents(),
                ],
            ))

            ->add('nom', TextType::class, array(
                'label'         => 'Nom',
                'attr'          => ['placeholder' => 'Nom'],
                'required'      => true,
                'constraints'   => [
                    new ContainsLettersAndAccents(),
                ],
            ))

            ->add('anniversaire', BirthdayType::class, array(
                'label'         => 'Date de naissance',
                'placeholder'   => array(
                    'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année',
                ),
                'format'        => 'ddMMyyyy',
                'years'         => range(1917,2017),
            ))

            ->add('pays', CountryType::class, array(
                'label'         => 'Pays',
                'placeholder'   => 'Choisissez votre pays',
                'preferred_choices' => [ 'FR' ]
            ))

            ->add('discount', CheckboxType::class, array(
                'label'         => 'Tarif réduit',
                'required'      => false,
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\ReservationBundle\Entity\Client',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_reservationbundle_client';

    }
}
