<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\encodeur;

use atoum;

/**
 * Class Code93FontEncodeur
 * Encodeur Code 93 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Code93FontEncodeur extends atoum
{
    /**
     * Test d'encodage
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("CODE 93E0"))
                    ->isEqualTo("*CODE 93E0*|")
        ;
    }
}
