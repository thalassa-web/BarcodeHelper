<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 16:31
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\symbologie;

use atoum;

class Code93Font extends atoum
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
     * Test d'encodage
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("CODE 93"))
                    ->isEqualTo("*CODE 93E0*|")
            ->and
                ->exception(function () {
                    $this->testedInstance->encoder("asr7634567890");
                })
        ;
    }
}
