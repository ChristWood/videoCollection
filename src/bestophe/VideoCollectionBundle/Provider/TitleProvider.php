<?php

namespace bestophe\VideoCollectionBundle\Provider;

use FOS\ElasticaBundle\Provider\ProviderInterface;
use Elastica\Type;
use Elastica\Document;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;

class TitleProvider implements ProviderInterface {

    use ConstantTrait;

    protected $movieType;
    protected $movieManager;

    public function __construct(Type $movieType, $movieManager) {
        $this->movieType = $movieType;
        $this->movieManager = $movieManager;
    }

    /**
     * Insert the repository objects in the type index
     *
     * @param \Closure $loggerClosure
     * @param array    $options
     */
    public function populate(\Closure $loggerClosure = null, array $options = array()) {
        if ($loggerClosure) {
            $loggerClosure('Indexing movies');
        }

        $allMovies = $this->movieManager->getAllMovies();
        $languages = $this->getLanguagesAvailable();

        foreach ($allMovies as $movie) {
            $document = new Document();
            $id = $movie->getId();
            $document->setId($id);

            $titleFr = $this->movieManager->getMovieTitleInLocale($id, $languages['fr']);
            $titleEn = $this->movieManager->getMovieTitleInLocale($id, $languages['en']);           

//            $titleEn = $this->movieManager->getMovieTitleInLocale($id, 'en');
//            $titleFr = $this->movieManager->getMovieTitleInLocale($id, 'fr');

            $document->setData(array('id' => $id, 'title_fr' => $titleFr['title'], 'title_en' => $titleEn['title']));
            $this->movieType->addDocuments(array($document));
        }
    }

}
