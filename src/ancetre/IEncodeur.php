<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:08
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;

/**
 * Interface IEncodeur
 * Encodage des données
 * @package ThalassaWeb\BarcodeHelper\ancetre
 */
interface IEncodeur
{
    /**
     * Encodage des données
     * @param string $donnees
     * @param string $checkDigit
     * @return string
     */
    public function encoder($donnees, string $checkDigit = ''): string;
}
