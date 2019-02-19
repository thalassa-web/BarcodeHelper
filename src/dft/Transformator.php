<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:33
 */

namespace ThalassaWeb\BarcodeHelper\dft;

use ThalassaWeb\BarcodeHelper\ancetre\ITransformateur;

/**
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class Transformator implements ITransformateur
{
    /**
     * Pas de transfo des données d'entrée
     * @param string $donnees
     * @return string
     */
    public function transformer(string $donnees)
    {
        return $donnees;
    }
}
