<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:34
 */

namespace ThalassaWeb\BarcodeHelper\code128;

use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

/**
 * Class Calculator
 * Calcule clé de contrôle Code 128
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class Calculator implements ICalculateur
{
    use CheckDigitConverter;

    /**
     * Obtenir la clé de contrôle
     * @param Enchainement $donnees
     * @return string
     */
    public function getCleControle($donnees): string
    {
        $arrData = $donnees->getValeurs();
        // Initialisation de la valeur du checkDigit avec la valeur de démarrage
        $checkDigit = $arrData[0];
        // Ajout de la valeur multipliée par la position du caractère
        for ($index = 1; $index < count($arrData); $index++) {
            $checkDigit += $index * $arrData[$index];
        }
        // Conversion du Checkdigit numérique en caractère ASCII
        return $this->valueToAscii($checkDigit % 103, $donnees->getLastSubset());
    }
}
