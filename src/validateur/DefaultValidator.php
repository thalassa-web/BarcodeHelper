<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:33
 */

namespace ThalassaWeb\BarcodeHelper\validateur;

use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;

/**
 * Class DefaultValidator
 * Tout le temps valide
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class DefaultValidator implements IValidateur
{
    /**
     * Validation des données d'entrée
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return true;
    }
}
