<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\code93;

use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;

/**
 * Code 93 Font
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class FontEncodeur implements IEncodeur
{
    /**
     * Encodage des données
     * @param string $donnees
     * @param string $checkDigit
     * @return string
     */
    public function encoder($donnees, string $checkDigit = ''): string
    {
        return "*$donnees{$checkDigit}*|";
    }
}
