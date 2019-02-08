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
                    ->isEqualTo("*CODE 93E0*|")
        ;
    }

    /**
     * Test d'encodage binaire
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodageBinaire() {
        $this->given($this->newTestedInstance)
            ->then
            ->array($this->testedInstance->encoderBinaire("CODE 93"))
                ->hasSize(12)
                ->isEqualTo([
                    //   *           C             O            D           E            [ ]          9
                    0b101011110, 0b110100010, 0b100101100, 0b110010100, 0b110010010, 0b111010010, 0b100001010,
                    //   3           E             0            *           |
                    0b101000010, 0b110010010, 0b100010100, 0b101011110, 0b100000000
                ])
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
