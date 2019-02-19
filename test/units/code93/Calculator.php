<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:36
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\code93;

use atoum;

class Calculator extends atoum
{
    /**
     * Un caractère de la chaine à encoder n'est pas valide
     */
    public function testCleControle() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle("/PT/12AZERTY34"))
                    ->isEqualTo("TM")
        ;
    }
}
