<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:15
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\calculateur;

use atoum;

/**
 * Class EanCalculator
 * Calcul de la clé de contrôle pour EAN
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class EanCalculator extends atoum
{
    /**
     * Un caractère de la chaine à encoder n'est pas valide
     */
    public function testCleControleEAN13() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->getCleControle("761234567890"))
                    ->isEqualTo("0")
        ;
    }
}
