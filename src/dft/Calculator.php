<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:34
 */

namespace ThalassaWeb\BarcodeHelper\dft;

use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

/**
 * Class Calculator
 * Pas de clé de contrôle
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class Calculator implements ICalculateur
{
    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle($donnees): string
    {
        return '';
    }
}
