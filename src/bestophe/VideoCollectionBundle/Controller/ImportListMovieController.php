<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use \Tmdb\Model\Common\GenericCollection;
use bestophe\VideoCollectionBundle\Entity\Import;

/**
 * Description of ImportListMovieController
 *
 * @author Christophe
 */
class ImportListMovieController extends Controller {

    public function uploadAction(Request $request) {

        $user = $this->getUser();
        $userId = $user->getId();
        $language = $request->getLocale();
        $importFileform = $this->createFormBuilder()
                ->add('file', 'file')
                ->getForm();

        $importFileform->handleRequest($request);
        if ($importFileform->isValid()) {
            $file = $importFileform['file']->getData();
            $fileName = $userId . '_importListMovie' . '.' . $file->getClientOriginalExtension();
            $dir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/import';
            $file->move($dir, $fileName);
            $this->deleteOldRecords($userId);
            $this->import($dir, $fileName, $userId);
            return $this->search($language, $userId);
        }
        return $this->render('bestopheVideoCollectionBundle:AddNewMovie:MovieImportFile.html.twig', array('ImportFileForm' => $importFileform->createView()));
    }

    public function deleteOldRecords($userId) {

        $recordsToDelete = $this->repositoryImport()->findBy(
                array('userId' => $userId) // Criteria
        );

        if ($recordsToDelete != null) {
            foreach ($recordsToDelete as $record) {
                $this->remove($record);
            }
            $this->flush();
        }
    }

    public function search($language, $userId) {

        $query = new MovieSearchQuery();
        $query->language($language);
        $results = new GenericCollection();
        $totalResults = 0;
        $totalPages = 0;

        $listImport = $this->repositoryImport()->findBy(
                array('userId' => $userId), // Criteria
                array('title' => 'desc')     // sorting
        );

        foreach ($listImport as $import) {
            $title = $import->getTitle();
            $results = $this->get('tmdb.search_repository')->searchMovie($title, $query)->merge($results);
            $queryResults = $this->get('tmdb.search_repository')->searchMovie($title, $query)->getTotalResults();
            if ($queryResults > 20) {
                $totalResults = $totalResults + 20;
            } else {
                $totalResults = $totalResults + $queryResults;
            }
            $totalPages++;
        }
        return $this->render('bestopheVideoCollectionBundle:AddNewMovie:SearchMovieResults.html.twig', array('movies' => $results,
                    'nbResults' => $totalResults, 'nbPages' => $totalPages, 'query' => 'Import'));
    }

    public function import($dir, $fileName, $userId) {

        // Getting php array of data from CSV
        $header = array('title');
        $data = $this->convert($dir . '/' . $fileName, $header);

        // Getting doctrine manager
        $em = $this->getDoctrine()->getManager();

        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);


        // Define the size of record, the frequency for persisting the data and the current index of records
        //$size = count($data);
        $batchSize = 5;
        $i = 1;

        // Processing on each row of data
        foreach ($data as $row) {
            $import = new Import();
            $import
                    ->setUserId($userId)
                    ->setTitle($row['title']);

            // Persisting the current import
            $this->persist($import);

            // Each x import persisted we flush everything
            if (($i % $batchSize) === 0) {

                $this->flush();
                // Detaches all objects from Doctrine for memory save
                //$em->clear();
            }
            $i++;
        }
        // Flushing and clear data on queue
        $this->flush();
        // $em->clear();
    }

    public function convert($filename, $header, $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header) {
                    $header = $row;
                } else {
                    $row = array_map("utf8_encode", $row);
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function repositoryImport() {
        $repImport = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('bestopheVideoCollectionBundle:Import')
        ;
        return $repImport;
    }

    public function persist($object) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
    }

    public function remove($object) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($object);
    }

    public function flush() {
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $em->clear();
    }

}
