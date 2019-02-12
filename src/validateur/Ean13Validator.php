<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:11
 */

namespace ThalassaWeb\BarcodeHelper\validateur;

use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;

/**
 * Class ValidateurEan13
 * Validation EAN13
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class Ean13Validator implements IValidateur
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
