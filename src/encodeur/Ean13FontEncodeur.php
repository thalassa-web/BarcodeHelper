<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\encodeur;

/**
 * Class Ean13FontEncodeur
 * Encodeur EAN 13 pour police de caractères
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Ean13FontEncodeur extends Ean13Encodeur
{
    public function __construct()
    {
        parent::__construct('*', '-');
    }

    /**
     * Définir le subset A
     * @return array
     */
    protected function getSubsetA(): array
    {
        return ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    }

    /**
     * Définir le subset B
     * @return array
     */
    protected function getSubsetB(): array
    {
        return ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"];
    }

    /**
     * Définir le subset C
     * @return array
     */
    protected function getSubsetC(): array
    {
        return ["K", "L", "M", "N", "O", "P", "Q", "R", "S", "T"];
    }
}
