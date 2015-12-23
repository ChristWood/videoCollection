<?php

namespace bestophe\VideoCollectionBundle\Transformer;

use Elastica\Document;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class MovieToElasticaTransformer implements ModelToElasticaTransformerInterface {

    use ConstantTrait;

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * Transform a movie to an elasticsearch object with title translated
     *
     * @param movieuser $movie the object to convert
     * @param array  $fields the keys we want to have in the returned array
     *
     * @return Document
     * */
    public function transform($movie, array $fields) {
        $identifier = $movie->getId();
        $languages = $this->getLanguagesAvailable(); //fr, en
        $titleFr = $this->container->get('bestophe_video_collection.movieManager')->getMovieTitleInLocale($identifier, $languages['fr']);
        $titleEn = $this->container->get('bestophe_video_collection.movieManager')->getMovieTitleInLocale($identifier, $languages['en']);
        
        $values = array(
            'id' => $identifier,
            'title_fr' => $titleFr['title'],
            'title_en' => $titleEn['title'],)
        ;
        $document = new Document($identifier, $values);
        return $document;
    }

}
