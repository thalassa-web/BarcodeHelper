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
 * Validation Code 128
 * @package ThalassaWeb\BarcodeHelper\code128
 */
class Calculator extends atoum
{
    /**
     * Test pour subset B
     */
    public function testSubsetB() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'B';
        // /PT/12AZE RTY34
        $this->calling($enchainement)->getValeurs = [104, 15, 48, 52, 15, 17, 18, 33, 58, 37, 0, 50, 52, 57, 19, 20];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle($enchainement))
                    ->isEqualTo("-")
        ;
    }
    /**
     * Test pour subset C
     */
    public function testSubsetC() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'C';
        // 31630035
        $this->calling($enchainement)->getValeurs = [105, 31, 63, 0, 35];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle($enchainement))
                    ->isEqualTo("]")
        ;
    }

    /**
     * Alternance B C B
     */
    public function testAlternanceBCB() {$enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'B';
        // /PT/az12345za
        $this->calling($enchainement)->getValeurs = [104,15,48,52,15,65,90,17,99,23,45,100,90,65];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle($enchainement))
                    ->isEqualTo("2")
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
                ->string($this->testedInstance->getCleControle($enchainement))
                    ->isEqualTo(chr(1))
        ;
    }
}
