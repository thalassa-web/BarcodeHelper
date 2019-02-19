<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:11
 */

namespace ThalassaWeb\BarcodeHelper\code128;

use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;

/**
 * Class Validator
 * Validation Code 128
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class Validator implements IValidateur
{
    /**
     * Que des caractères ASCII
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return !preg_match("/[^[:ascii:]]/", $donnees);
    }
}
