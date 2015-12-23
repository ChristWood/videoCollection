<?php

namespace bestophe\VideoCollectionBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(name="genre_translations", indexes={
 *      @ORM\Index(name="genre_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class GenreTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}

