<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use bestophe\VideoCollectionBundle\Entity\MovieUser;
use bestophe\VideoCollectionBundle\Entity\Genre;
use bestophe\VideoCollectionBundle\Entity\MovieCast;
use bestophe\VideoCollectionBundle\Entity\MovieCrew;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\MovieRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\TranslationEntity(class="bestophe\VideoCollectionBundle\Entity\Translation\MovieTranslation")
 * @ExclusionPolicy("all")
 */
class Movie implements Translatable {

    /**
     * @ORM\ManyToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\Genre",cascade={"persist"}, fetch="EAGER")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieUser", mappedBy="movie", cascade={"persist","remove"},fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $movie_user;

    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieCast", mappedBy="movie", cascade={"persist","remove"},fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $movie_cast;

    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieCrew", mappedBy="movie", cascade={"persist","remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $movie_crew;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Expose
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="adult", type="boolean")
     */
    private $adult;

    /**
     * @var integer
     *
     * @ORM\Column(name="budget", type="integer", nullable=true)
     */
    private $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="originalLanguage", type="string", length=255, nullable=true)
     */
    private $originalLanguage;

    /**
     * @var string
     *
     * @ORM\Column(name="originalTitle", type="string", length=255)
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $originalTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="backdropPath", type="string", length=255, nullable=true)
     */
    private $backdropPath;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="date")
     * @Expose
     */
    private $releaseDate;

    /**
     * @var array
     *
     * @ORM\Column(name="belongsToCollection", type="array", nullable=true)
     * @Expose
     */
    private $belongsToCollection;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage", type="string", length=255, nullable=true)
     */
    private $homepage;

    /**
     * @var string
     *
     * @ORM\Column(name="imdbId", type="string", length=255, nullable=true)
     */
    private $imdbId;

    /**
     * @var integer
     *
     * @ORM\Column(name="revenue", type="integer", nullable=true)
     */
    private $revenue;

    /**
     * @var integer
     *
     * @ORM\Column(name="runtime", type="integer", nullable=true)
     * @Expose
     */
    private $runtime;

    /**
     * @var string
     *
     * @ORM\Column(name="posterPath", type="string", length=255, nullable=true)
     */
    private $posterPath;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="overview", type="text", nullable=true)
     */
    private $overview;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="tagline", type="text", nullable=true)
     */
    private $tagline;

    /**
     * @var float
     *
     * @ORM\Column(name="voteAverage", type="float", nullable=true)
     */
    private $voteAverage;

    /**
     * @var integer
     *
     * @ORM\Column(name="voteCount", type="integer", nullable=true)
     */
    private $voteCount;

    /**
     * @var float
     *
     * @ORM\Column(name="popularity", type="float", nullable=true)
     */
    private $popularity;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Expose
     */
    private $updated;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function __construct() {
        $this->genres = new ArrayCollection();
        $this->movie_user = new ArrayCollection();
        $this->movie_cast = new ArrayCollection();
        $this->movie_crew = new ArrayCollection();
    }

    public function hydrate($tmdbMovie) {
        $this->setAdult($tmdbMovie->getAdult())
                ->setBackdropPath($tmdbMovie->getBackdropPath())
                ->setBelongsToCollection($tmdbMovie->getBelongsToCollection())
                //->setChanges($tmdbMovie->getChanges())
                //->addGenres($tmdbMovie->getGenres())
                ->setBudget($tmdbMovie->getBudget())
                ->setHomepage($tmdbMovie->getHomepage())
                ->setId($tmdbMovie->getId())
                //->setImages($tmdbMovie->getImages())
                ->setImdbId($tmdbMovie->getImdbId())
                ->setOriginalTitle($tmdbMovie->getOriginalTitle())
                ->setOriginalLanguage($tmdbMovie->getOriginalLanguage())
                ->setOverview($tmdbMovie->getOverview())
                ->setPopularity($tmdbMovie->getPopularity())
                ->setPosterPath($tmdbMovie->getPosterPath())
                //->setProductionCompanies($tmdbMovie->getProductionCompanies())
                //->setProductionCountries($tmdbMovie->getProductionCountries())
                ->setReleaseDate($tmdbMovie->getReleaseDate())
                ->setRevenue($tmdbMovie->getRevenue())
                ->setRuntime($tmdbMovie->getRuntime())
                //->setSpokenLanguages($tmdbMovie->getSpokenLanguages())
                ->setStatus($tmdbMovie->getStatus())
                ->setTagline($tmdbMovie->getTagline())
                ->setTitle($tmdbMovie->getTitle())
                ->setVoteAverage($tmdbMovie->getVoteAverage())
                ->setVoteCount($tmdbMovie->getVoteCount());
        //->setAlternativeTitles($tmdbMovie->getAlternativeTitles())
        //->setCast($tmdbMovie->getCredits()->getCast())
        //->setCrew($tmdbMovie->getCredits()->getCrew())
        //->setCredits($tmdbMovie->getCredits())
        //->setKeywords($tmdbMovie->getKeywords())
        //->setLists($tmdbMovie->getLists())
        //->setReleases($tmdbMovie->getReleases())
        //->setSimilar($tmdbMovie->getSimilar())
        //->setTranslations($tmdbMovie->getTranslations())
        //->setBackdrop($tmdbMovie->getBackdropImage())
        //->setPoster($tmdbMovie->getPosterImage());
        //->setReviews($tmdbMovie->getReviews())
        //->setVideos($tmdbMovie->getVideos());
//        foreach ($tmdbMovie->getGenres() as $genreTmdb) {
//            $idGenreTmdb = $genreTmdb->getId();
//            $genre = $this->getGenresInDB($idGenreTmdb);
//            $newMovie->addGenre($genre);
//        }
    }

    public function addGenre(Genre $genre) {
        $this->genres[] = $genre;

        return $this;
    }

    public function removeGenre(Genre $genre) {
        $this->genres->removeElement($genre);
    }

    public function getGenres() {
        return $this->genres;
    }

    /**
     * Add movie_user 
     * 
     * @param bestophe\VideoCollectionBundle\Entity\MovieUser $movie_user
     * @return User
     */
    public function addMovieUser(MovieUser $movie_user) {
        $this->movie_user[] = $movie_user;
        $movie_user->setMovie($this);
        return $this;
    }

    /**
     * Remove movie_user
     *
     * @param bestophe\VideoCollectionBundle\Entity\MovieUser $movie_user
     */
    public function removeMovieUser(MovieUser $movie_user) {
        $this->movie_user->removeElement($movie_user);
    }

    /**
     * Get movie_user 
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovieUser() {
        return $this->movie_user;
    }

    /**
     * Add movie_cast 
     * 
     * @param bestophe\VideoCollectionBundle\Entity\MovieCast $movie_cast
     * @return Person
     */
    public function addMovieCast(MovieCast $movie_cast) {
        $this->movie_cast[] = $movie_cast;
        $movie_cast->setMovie($this);
        return $this;
    }

    /**
     * Remove movie_cast
     *
     * @param bestophe\VideoCollectionBundle\Entity\MovieCast $movie_cast
     */
    public function removeMovieCast(MovieCast $movie_cast) {
        $this->movie_cast->removeElement($movie_cast);
    }

    /**
     * Get movie_cast 
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovieCast() {
        return $this->movie_cast;
    }

    /**
     * Add movie_crew 
     * 
     * @param bestophe\VideoCollectionBundle\Entity\MovieCrew $movie_crew
     * @return Person
     */
    public function addMovieCrew(MovieCrew $movie_crew) {
        $this->movie_crew[] = $movie_crew;
        $movie_crew->setMovie($this);
        return $this;
    }

    /**
     * Remove movie_crew
     *
     * @param bestophe\VideoCollectionBundle\Entity\MovieCrew $movie_crew
     */
    public function removeMovieCrew(MovieCrew $movie_crew) {
        $this->movie_crew->removeElement($movie_crew);
    }

    /**
     * Get movie_crew 
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovieCrew() {
        return $this->movie_crew;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Movie
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set adult
     *
     * @param boolean $adult
     * @return Movie
     */
    public function setAdult($adult) {
        $this->adult = $adult;

        return $this;
    }

    /**
     * Get adult
     *
     * @return boolean 
     */
    public function getAdult() {
        return $this->adult;
    }

    /**
     * Set budget
     *
     * @param integer $budget
     * @return Movie
     */
    public function setBudget($budget) {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return integer 
     */
    public function getBudget() {
        return $this->budget;
    }

    /**
     * Set originalLanguage
     *
     * @param string $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage($originalLanguage) {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    /**
     * Get originalLanguage
     *
     * @return string 
     */
    public function getOriginalLanguage() {
        return $this->originalLanguage;
    }

    /**
     * Set originalTitle
     *
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle($originalTitle) {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * Get originalTitle
     *
     * @return string 
     */
    public function getOriginalTitle() {
        return $this->originalTitle;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Movie
     */
    public function setReleaseDate($releaseDate) {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate() {
        return $this->releaseDate;
    }

    /**
     * Set belongsToCollection
     *
     * @param array $belongsToCollection
     * @return Movie
     */
    public function setBelongsToCollection($belongsToCollection) {
        $this->belongsToCollection = $belongsToCollection;

        return $this;
    }

    /**
     * Get belongsToCollection
     *
     * @return array 
     */
    public function getBelongsToCollection() {
        return $this->belongsToCollection;
    }

    /**
     * Set homepage
     *
     * @param string $homepage
     * @return Movie
     */
    public function setHomepage($homepage) {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return string 
     */
    public function getHomepage() {
        return $this->homepage;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     * @return Movie
     */
    public function setImdbId($imdbId) {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string 
     */
    public function getImdbId() {
        return $this->imdbId;
    }

    /**
     * Set revenue
     *
     * @param integer $revenue
     * @return Movie
     */
    public function setRevenue($revenue) {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * Get revenue
     *
     * @return integer 
     */
    public function getRevenue() {
        return $this->revenue;
    }

    /**
     * Set runtime
     *
     * @param integer $runtime
     * @return Movie
     */
    public function setRuntime($runtime) {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return integer 
     */
    public function getRuntime() {
        return $this->runtime;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return string
     */
    public function setTitle($title) {
        if (!empty($title)) {
            $this->title = $title;
        } else {
            $this->title = null;
        }

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set overview
     *
     * @param string $overview
     * @return MovieUser
     */
    public function setOverview($overview) {
        if (!empty($overview)) {
            $this->overview = $overview;
        } else {
            $this->overview = null;
        }

        return $this;
    }

    /**
     * Get overview
     *
     * @return string 
     */
    public function getOverview() {
        return $this->overview;
    }

    /**
     * Set tagline
     *
     * @param string $tagline
     * @return MovieUser
     */
    public function setTagline($tagline) {
        if (!empty($tagline)) {
            $this->tagline = $tagline;
        } else {
            $this->tagline = null;
        }

        return $this;
    }

    /**
     * Get tagline
     *
     * @return string 
     */
    public function getTagline() {
        return $this->tagline;
    }

    /**
     * Set voteAverage
     *
     * @param float $voteAverage
     * @return Movie
     */
    public function setVoteAverage($voteAverage) {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    /**
     * Get voteAverage
     *
     * @return float 
     */
    public function getVoteAverage() {
        return $this->voteAverage;
    }

    /**
     * Set voteCount
     *
     * @param integer $voteCount
     * @return Movie
     */
    public function setVoteCount($voteCount) {
        $this->voteCount = $voteCount;

        return $this;
    }

    /**
     * Get voteCount
     *
     * @return integer 
     */
    public function getVoteCount() {
        return $this->voteCount;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Movie
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Movie
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Sets translatable locale
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale) {
        $this->locale = $locale;
    }

    /**
     * Set backdropPath
     *
     * @param string $backdropPath
     * @return Movie
     */
    public function setBackdropPath($backdropPath) {
        $this->backdropPath = $backdropPath;

        return $this;
    }

    /**
     * Get backdropPath
     *
     * @return string 
     */
    public function getBackdropPath() {
        return $this->backdropPath;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Movie
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set posterPath
     *
     * @param string $posterPath
     * @return Movie
     */
    public function setPosterPath($posterPath) {
        $this->posterPath = $posterPath;

        return $this;
    }

    /**
     * Get posterPath
     *
     * @return string 
     */
    public function getPosterPath() {
        return $this->posterPath;
    }

    /**
     * Set popularity
     *
     * @param float $popularity
     * @return Movie
     */
    public function setPopularity($popularity) {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity
     *
     * @return float 
     */
    public function getPopularity() {
        return $this->popularity;
    }

}
