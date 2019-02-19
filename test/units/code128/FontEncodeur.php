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
        $chr15 = chr(15);
        $chr17 = chr(17);
        $chr18 = chr(18);
        $chr19 = chr(19);
        $chr20 = chr(20);
        $chr0 = chr(0);
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder($enchainement, '-'))
                    ->isIdenticalTo("h{$chr15}04{$chr15}{$chr17}{$chr18}!:%{$chr0}249{$chr19}{$chr20}-j")
        ;
    }

    /**
     * Subset C
     */
    public function testEncodageSubsetC() {
        $chr0 = chr(0);
        $chr31 = chr(31);
        $enchainement = new \mock\ThalassaWeb\BarcodeHelper\code128\Enchainement;
        $this->calling($enchainement)->getLastSubset = 'C';
        // 31630035
        $this->calling($enchainement)->getValeurs = [105,31,63,0,35];
        $this->given($this->newTestedInstance)
            ->then
            ->string($this->testedInstance->encoder($enchainement, ']'))
            ->isIdenticalTo("i{$chr31}?{$chr0}#]j")
        ;
    }
}
