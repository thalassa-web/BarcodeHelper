<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:03
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;

/**
 * Interface IValidateur
 * Validation des données d'entrée
 * @package ThalassaWeb\BarcodeHelper\ancetre
 */
interface IValidateur
{
    /**
     * Validation des données d'entrée
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool;
}
