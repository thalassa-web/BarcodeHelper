<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\encodeur;

use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;

/**
 * Class Code93FontEncodeur
 * Encodeur Code 93 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Code93FontEncodeur implements IEncodeur
{
    /**
     * Encodage des données
     * @param string $donnees
     * @return string
     */
    public function encoder(string $donnees): string
    {
        return "*$donnees*|";
    }
}
