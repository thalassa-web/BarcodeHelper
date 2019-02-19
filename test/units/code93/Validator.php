<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:12
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\code93;

use atoum;

/**
 * Class Validator
 * Validation Code 93
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
                ->boolean($this->testedInstance->valider("/P.T$/1+2AZER TY34%"))
                    ->isTrue
        ;
    }
}
