<?php

namespace bestophe\VideoCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'expanded' => true,
            'multiple' => false,
            'placeholder' => false,
            'label'=>false,
            'attr' => array(
                'class' => 'rating',
            ),
            'choices' => array(
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
            )
        ));
    }

    public function getParent() {
        return 'choice';
    }

    public function getName() {
        return 'rating';
    }

}
