<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:11
 */

namespace ThalassaWeb\BarcodeHelper\ean\_13;

use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;

/**
 * Validation EAN13
 * @package ThalassaWeb\BarcodeHelper\ean
 */
class Validator implements IValidateur
{

    /**
     * On accepte 12 ou 13 digits
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return preg_match("#[0-9]{12}[0-9]?#", $donnees);
    }
}
