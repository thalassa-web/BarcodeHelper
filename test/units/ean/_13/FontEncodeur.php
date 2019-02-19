<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\ean\_13;

use atoum;

/**
 * Class 13FontEncodeur
 * BinEncodeur EAN 13 pour police de caractères
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class FontEncodeur extends atoum
{
    /**
     * Test d'encodage (avec calcul clé de contrôle)
     * Un digit pouvant être représentés de différentes manières (suivant le 1er digit du codebarre)
     * Des lettres ont été utilisées pour représenter un digit suivant le subset utilisé
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    public function testEncodage() {
        $this->given($this->newTestedInstance)
            ->then
                ->string($this->testedInstance->encoder("761234567890", '0'))
                    ->isEqualTo("*6B2D4F-QRSTKK*")
        ;
    }
}
