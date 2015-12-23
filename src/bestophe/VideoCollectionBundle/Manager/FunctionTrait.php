<?php

namespace bestophe\VideoCollectionBundle\Manager;

/**
 * Description of FunctionTrait
 *
 * @author Christophe
 */
trait FunctionTrait {

   

    function removeSpace($name) {
        $newName = ucwords($name);
        return str_replace(' ', '_', $newName);
    }

}
