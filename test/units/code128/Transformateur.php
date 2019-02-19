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
 * Transformation Code 128
 * @package ThalassaWeb\BarcodeHelper\code128
 */
class Transformateur extends atoum
{
    /**
     * Simple avec seulement Subset B
     */
    public function testSubsetB() {
        $this->given($this->newTestedInstance)
            ->then
                ->object($this->testedInstance->transformer("/PT/12AZE RTY34"))
                ->toString()
                    ->isIdenticalTo('{"lastSubset":"B","valeurs":[104,15,48,52,15,17,18,33,58,37,0,50,52,57,19,20]}');
        ;
    }

    /**
     * Simple avec uniquement un nombre paire de digits : Subset C
     */
    public function testSubsetC() {
        $this->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->transformer("31630035"))
            ->toString()
            ->isIdenticalTo('{"lastSubset":"C","valeurs":[105,31,63,0,35]}');
        ;
    }

    /**
     * Alternance B C B
     */
    public function testAlternanceBCB() {
        $this->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->transformer("/PT/az12345za"))
            ->toString()
            ->isIdenticalTo('{"lastSubset":"B","valeurs":[104,15,48,52,15,65,90,17,99,23,45,100,90,65]}');
        ;
    }

    /**
     * Alternance B C
     */
    public function testAlternanceBC() {
        $this->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->transformer("/PT/az12345"))
            ->toString()
            ->isIdenticalTo('{"lastSubset":"C","valeurs":[104,15,48,52,15,65,90,17,99,23,45]}');
        ;
    }

    /**
     * Alternance A B C
     */
    public function testAlternanceABC() {
        $this->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->transformer(chr(2) . "/PT/az12345"))
                ->toString()
                    ->isIdenticalTo('{"lastSubset":"C","valeurs":[103,66,15,48,52,15,100,65,90,17,99,23,45]}');
        ;
    }
    /**
     * Test pour subset A
     */
    public function testSubsetA() {
        $this->given($this->newTestedInstance)
            ->then
            ->object($this->testedInstance->transformer(chr(2) . "/PT/AZ123ER"))
                ->toString()
                    ->isIdenticalTo('{"lastSubset":"A","valeurs":[103,66,15,48,52,15,33,58,17,18,19,37,50]}');
        ;
    }
}
