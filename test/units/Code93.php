<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 16:31
 */

namespace ThalassaWeb\BarcodeHelper\tests\units;

use atoum;

class Code93 extends atoum
{
    /**
     * Un caractère de la chaine à encoder n'est pas valide
     */
    public function testCaracteresNonValides() {
        $this->given($this->newTestedInstance)
            ->then
                ->exception(
                    function() {
                        $this->testedInstance->encoder("1234?");
                    }
                )
        ;
    }

    /**
     * Test d'encodage
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("CODE 93"))
                    ->isEqualTo("*CODE 93E0*")
        ;
    }

    /**
     * Test de validation des clefs
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testValidation() {
        $this->given($this->newTestedInstance)
            ->then
                ->boolean($this->testedInstance->verifier("CODE 93E0"))
                    ->isTrue
            ->and
                ->boolean($this->testedInstance->verifier("CODE 93E1"))
                    ->isFalse
        ;
    }
}
