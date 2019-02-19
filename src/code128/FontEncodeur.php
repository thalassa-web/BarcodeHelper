<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 14/02/2019
 * Time: 16:02
 */

namespace ThalassaWeb\BarcodeHelper\code128;

use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;

/**
 * Class BinEncodeur
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class FontEncodeur implements IEncodeur
{
    /**
     * Encodage des données
     * @param Enchainement $donnees
     * @param string $checkDigit
     * @return string
     */
    public function encoder($donnees, string $checkDigit = ''): string
    {
        // Chaque valeur est transformée en son caractère ASCII associé
        // Caractère STOP = n° 106 = j (ASCII 106)
        return implode('', array_map(function (int $valeur) {return chr($valeur);}, $donnees->getValeurs())) . $checkDigit . 'j';
    }
}
