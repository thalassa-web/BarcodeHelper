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
 * Encodage binaire Code 128
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class BinEncodeur extends atoum
{
    /**
     * Subset B
     */
    public function testEncodageSubsetB() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'B';
        // /PT/12AZE RTY34
        $this->calling($enchainement)->getValeurs = [104, 15, 48, 52, 15, 17, 18, 33, 58, 37, 0, 50, 52, 57, 19, 20];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder($enchainement, '-'))
                    ->isIdenticalTo("0000000000110100100001011100110011101110110110111000101011100110010011100110110011100101010001100011101100010100011010001101100110011000101110110111000101110110100011001011100110010011101001101110011000111010110000000000")
        ;
    }

    /**
     * Subset C
     */
    public function testEncodageSubsetC() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'C';
        // 31630035
        $this->calling($enchainement)->getValeurs = [105,31,63,0,35];
        $this->given($this->newTestedInstance)
            ->then
            ->string($this->testedInstance->encoder($enchainement, ']'))
            ->isIdenticalTo("000000000011010011100110110001101010011000011011001100100010001101010001111011000111010110000000000")
        ;
    }
    /**
     * Test pour subset A
     */
    public function testSubsetA() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'A';
        $this->calling($enchainement)->getValeurs = [103, 66, 15, 48, 52, 15, 33, 58, 17, 18, 19, 37];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder($enchainement, chr(1)))
                    ->isIdenticalTo("00000000001101000010010010000110101110011001110111011011011100010101110011001010001100011101100010100111001101100111001011001011100100011010001001011000011000111010110000000000")
        ;
    }
}
