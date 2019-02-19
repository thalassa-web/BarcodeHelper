<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:12
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\code128;

use atoum;

/**
 * Validation Code 128
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
                ->boolean($this->testedInstance->valider("Codé 128"))
                    ->isFalse
                ->boolean($this->testedInstance->valider("/P.T$/1+2AZER_TY34%"))
                    ->isTrue
        ;
    }
}
