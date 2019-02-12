<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\encodeur;

use atoum;

/**
 * Class Ean13FontEncodeur
 * Encodeur EAN 13 pour police de caractères
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Ean13FontEncodeur extends atoum
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
                ->string($this->testedInstance->encoder("7612345678900"))
                    ->isEqualTo("*6B2D4F-QRSTKK*")
        ;
    }
}
