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
     * EAN13 binaire
     */
    public function testEan13Bin() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(2))
            ->then
                ->string($barcode->encoder('761234567890'))
                    ->isEqualTo('10101011110110011001001101000010100011011100101010101000010001001001000111010011100101110010101');
    }

    /**
     * EAN13 Font
     */
    public function testEan13Font() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(3))
            ->then
                ->string($barcode->encoder('761234567890'))
                    ->isEqualTo('*6B2D4F-QRSTKK*');
    }

    /**
     * Code 128 binaire
     */
    public function testCode128Bin() {
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(4))
            ->then
            ->string($barcode->encoder('/PT/12AZE RTY34'))
            ->isEqualTo('0000000000110100100001011100110011101110110110111000101011100110010011100110110011100101010001100011101100010100011010001101100110011000101110110111000101110110100011001011100110010011101001101110011000111010110000000000');
    }

    /**
     * Code 128 Font
     */
    public function testCode128Font() {
        $chrs = [0 => chr(0), 15 => chr(15), 17 => chr(17), 18 => chr(18), 19 => chr(19), 20 => chr(20)];
        $this
            ->given($barcode = $this->getTestedClassName()::getBarcode(5))
            ->then
            ->string($barcode->encoder('/PT/12AZE RTY34'))
            ->isEqualTo("h{$chrs[15]}04{$chrs[15]}{$chrs[17]}{$chrs[18]}!:%{$chrs[0]}249{$chrs[19]}{$chrs[20]}-j");
    }
}
