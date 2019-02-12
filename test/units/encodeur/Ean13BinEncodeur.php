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
 * Class Ean13BinEncodeur
 * Encodeur EAN 13 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Ean13BinEncodeur extends atoum
{
    /**
     * Test d'encodage (avec calcul clé de contrôle)
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("7612345678900"))
                    ->isEqualTo("10101011110110011001001101000010100011011100101010101000010001001001000111010011100101110010101")
        ;
    }
}
