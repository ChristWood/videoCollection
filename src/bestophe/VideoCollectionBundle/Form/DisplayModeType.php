<?php

namespace bestophe\VideoCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DisplayModeType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('display', 'choice', array(
                    'choices' => array('1' => 'Alpha', '2' => 'Compact', '3' => 'Poster'),
                    'expanded' => true,
                    'multiple' => false,
                    'data' => 2,
                ))
        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'DisplayModeForm';
    }

}
