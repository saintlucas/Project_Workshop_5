<?php

namespace Workshop_5Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PhoneType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('phoneNumber')->add('type')
                ->add('save', 'submit', array('label' => 'Dodaj numer telefonu'))
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'Domowy' => 'domowy',
                        'Służbowy' => 'sluzbowy',
                        'Inny' => 'inny',
                    )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Workshop_5Bundle\Entity\Phone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'workshop_5bundle_phone';
    }

}