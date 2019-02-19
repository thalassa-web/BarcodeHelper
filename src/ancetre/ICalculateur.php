<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:03
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;

/**
 * Interface ICalculateur
 * Calculateur de clé de contrôle
 * @package ThalassaWeb\BarcodeHelper\ancetre
 */
interface ICalculateur
{
    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle($donnees): string;
}
