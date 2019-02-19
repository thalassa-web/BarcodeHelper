<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:15
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\ean;

use atoum;

/**
 * Class Calculator
 * Calcul de la clé de contrôle pour EAN
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class Calculator extends atoum
{
    /**
     * Calcul clé de controle EAN 13
     */
    public function testCleControleEan13() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle("761234567890"))
                    ->isEqualTo("0")
        ;
    }

    /**
     * Calcul clé de contrôle EAN 8
     */
    public function testCleControleEan8() {
        $this->given($this->newTestedInstance(8))
            ->then
                ->string($this->testedInstance->getCleControle("7612345"))
                    ->isEqualTo("0")
        ;
    }

    /**
     * Calcul clé de contrôle UPC A
     */
    public function testCleControleUpcA() {
        $this->given($this->newTestedInstance(12))
            ->then
                ->string($this->testedInstance->getCleControle("04210000526"))
                    ->isEqualTo("4")
        ;
    }

    /**
     * Calcul clé de contrôle UPC E
     */
    public function testCleControleUpcE() {
        $this->given($this->newTestedInstance(6))
            ->then
                ->string($this->testedInstance->getCleControle("42526"))
                    ->isEqualTo("1")
        ;
    }

    /**
     * Calcul clé de contrôle EAN 14
     */
    public function testCleControleEan14() {
        $this->given($this->newTestedInstance(14))
            ->then
            ->string($this->testedInstance->getCleControle("2419730963892"))
            ->isEqualTo("5")
        ;
    }
}
