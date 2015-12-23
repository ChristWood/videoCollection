<?php

namespace bestophe\VideoCollectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class MovieUserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('media', 'entity', array(
                    'class' => 'bestopheVideoCollectionBundle:Media',
                    'choice_label' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->orderBy('u.name', 'ASC');
                    },
                    'placeholder' => 'movieUserForm.chooseMedia',
                    'translation_domain' => 'menu'
                ))
                ->add('comment', 'textarea', array('required' => false))
                ->add('rating', 'rating', array(
                    'required' => false,
                    'data' => '1'
                ))
                ->add('saveMedia', 'submit', array('label' => 'Ok'))
                ->add('saveComment', 'submit', array('label' => 'Ok'))
                ->add('saveRating', 'submit', array('label' => 'Ok'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'bestophe\VideoCollectionBundle\Entity\MovieUser'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bestophe_videocollectionbundle_movieUser';
    }

}
