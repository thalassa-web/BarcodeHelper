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
 * Encodage pour police de caractères Code 128
 * @package ThalassaWeb\BarcodeHelper\validateur
 */
class FontEncodeur extends atoum
{
    /**
     * Un caractère de la chaine à encoder n'est pas valide
     */
    public function testEncodageSubsetB() {
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'B';
        // /PT/12AZE RTY34
        $this->calling($enchainement)->getValeurs = [104, 15, 48, 52, 15, 17, 18, 33, 58, 37, 0, 50, 52, 57, 19, 20];
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder($enchainement, '-'))
                    ->isIdenticalTo("ª/PT/12AZE RTY34M¬")
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
                    ->isIdenticalTo("«?_ C}¬")
        ;
    }
}
