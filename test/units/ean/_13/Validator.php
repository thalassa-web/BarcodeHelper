<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:11
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\ean\_13;

use atoum;

/**
 * Class ValidateurEan13
 * Validation EAN13
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class Validator extends atoum
{
    /**
     * Un caractère de la chaine à encoder n'est pas valide
     */
    public function testValidite() {
        $this->given($this->newTestedInstance)
            ->then
                ->boolean($this->testedInstance->valider("1234?"))
                    ->isFalse
                ->boolean($this->testedInstance->valider("1234567890123"))
                    ->isTrue
        ;
    }
}
