<?php

namespace bestophe\VideoCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ViewByGenreType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'entity', array(
                    'class' => 'bestopheVideoCollectionBundle:Genre',
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->orderBy('g.name', 'ASC');
                    },
                    'label' => false,
                    'placeholder' => 'Select a genre'))
                ->add('save', 'submit', array('label' => 'Ok'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
   public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'bestophe\VideoCollectionBundle\Entity\Genre'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bestophe_videocollectionbundle_genre';
    }

}
