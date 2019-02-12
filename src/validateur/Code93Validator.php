<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:12
 */

namespace ThalassaWeb\BarcodeHelper\validateur;

use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;

/**
 * Class Code93Validator
 * Validation Code 93
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class Code93Validator implements IValidateur
{
    /**
     * Le code 93 permet de codifier :
     *   - les 26 lettres majuscules (A à Z),
     *   - les 10 chiffres (0 à 9 ) ainsi que
     *   - les 7 caractères (- , . , Espace,  $ , / , + , % )
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return !preg_match("#[^A-Z0-9 .$/+%-]#", $donnees);
    }
}
