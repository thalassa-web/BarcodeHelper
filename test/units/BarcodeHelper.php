<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:41
 */

namespace ThalassaWeb\BarcodeHelper\tests\units;

use atoum;

class BarcodeHelper extends atoum
{
    /**
     * Mode inconnu
     */
    public function testModeInconnu() {
        $this->exception(function () {
            $this->getTestedClassName()::getBarcode(-1);
        });
    }

    /**
     * Code 93 binaire
     */
    public function testCode93Bin() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(0))
            ->then
                ->string($barcode->encoder('CODE 93'))
                    ->isEqualTo('101011110110100010100101100110010100110010010111010010100001010101000010110010010100010100101011110100000000');
    }

    /**
     * Code 93 Font
     */
    public function testCode93Font() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(1))
            ->then
                ->string($barcode->encoder('CODE 93'))
                    ->isEqualTo('*CODE 93E0*|');
    }

    /**
     * Code 93 binaire
     */
    public function terstEan13Bin() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(2))
            ->then
                ->string($barcode->encoder('761234567890'))
                    ->isEqualTo('10101011110110011001001101000010100011011100101010101000010001001001000111010011100101110010101');
    }

    /**
     * Code 93 Font
     */
    public function testEan13Font() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(3))
            ->then
                ->string($barcode->encoder('761234567890'))
                    ->isEqualTo('*6B2D4F-QRSTKK*');
    }
}
