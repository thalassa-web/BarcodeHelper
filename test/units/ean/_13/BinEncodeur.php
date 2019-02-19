<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\ean\_13;

use atoum;

/**
 * Class 13BinEncodeur
 * BinEncodeur EAN 13 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class BinEncodeur extends atoum
{
    /**
     * Test d'encodage (avec calcul clé de contrôle)
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("761234567890", '0'))
                    ->isEqualTo("10101011110110011001001101000010100011011100101010101000010001001001000111010011100101110010101")
        ;
    }
}
