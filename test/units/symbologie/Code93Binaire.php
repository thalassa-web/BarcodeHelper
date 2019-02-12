<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 16:31
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\symbologie;

use atoum;

class Code93Binaire extends atoum
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

    /**
     * Test de calcul de clé de contrôle
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testChecksum() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getChecksum("/PT/12AZERTY34"))
                    ->isEqualTo("TM")
            ->and
                ->exception(function () {
                    $this->testedInstance->getChecksum("76345_67890");
                })
        ;
    }

    /**
     * Test d'encodage binaire
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("CODE 93"))
                    ->isEqualTo("101011110110100010100101100110010100110010010111010010100001010101000010110010010100010100101011110100000000")
            ->and
                ->exception(function () {
                    $this->testedInstance->encoder("asr7634567890");
                })
        ;
    }
}
