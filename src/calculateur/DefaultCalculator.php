<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:34
 */

namespace ThalassaWeb\BarcodeHelper\calculateur;

use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

/**
 * Class DefaultCalculator
 * Pas de clé de contrôle
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class DefaultCalculator implements ICalculateur
{
    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle(string $donnees): string
    {
        return '';
    }
}
