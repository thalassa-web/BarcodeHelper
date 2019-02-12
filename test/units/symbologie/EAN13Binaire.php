<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 16:31
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\symbologie;

use atoum;

class EAN13Binaire extends atoum
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

    /**
     * Test d'encodage (avec calcul clé de contrôle)
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("761234567890"))
                    ->isEqualTo("10101011110110011001001101000010100011011100101010101000010001001001000111010011100101110010101")
            ->and
                ->exception(function () {
                    $this->testedInstance->encoder("7634567890");
                })
        ;
    }

    /**
     * Test de calcul de clé de contrôle
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testChecksum() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getChecksum("761234567890"))
                    ->isEqualTo("0")
            ->and
                ->exception(function () {
                    $this->testedInstance->getChecksum("?7634567890");
                })
        ;
    }
}
