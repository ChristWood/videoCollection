 <?php

/**
 * Description of MovieSearchType
 *
 * @author Christophe
 */

/** namespace bestophe\VideoCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', 'text');
    }

    public function configureOptions(OptionsResolver $resolver)

        $resolver->setDefaults(array(
            'data_class' => 'bestophe\VideoCollectionBundle\Entity\MoviesDetails'
        ));
    }

    public function getName() {
        return 'MovieSearchForm';
    }

}**/
