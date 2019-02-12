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
 * Class Code93BinEncodeur
 * Encodeur Code 93 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Code93BinEncodeur extends atoum
{
    /**
     * Test d'encodage binaire
     * @see http://www.gomaro.ch/code93.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("CODE 93E0"))
                    ->isEqualTo("101011110110100010100101100110010100110010010111010010100001010101000010110010010100010100101011110100000000")
        ;
    }
}
