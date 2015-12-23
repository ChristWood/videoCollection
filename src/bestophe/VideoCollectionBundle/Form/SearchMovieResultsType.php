<?php

namespace bestophe\VideoCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMovieResultsType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('idTmdb')
                ->add('originalTitle')
                ->add('title')
                ->add('releaseDate')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'bestophe\VideoCollectionBundle\Entity\Movie'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'SearchMovieResultsForm';
    }

}
