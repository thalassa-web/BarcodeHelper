<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:19
 */

namespace ThalassaWeb\BarcodeHelper\encodeur;

/**
 * Class Ean13BinEncodeur
 * Encodeur EAN 13 binaire
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class Ean13BinEncodeur extends Ean13Encodeur
{

    public function __construct()
    {
        parent::__construct('101', '01010');
    }

    /**
     * Définir le subset A
     * @return array
     */
    protected function getSubsetA(): array
    {
        return ["0001101", "0011001", "0010011", "0111101", "0100011", "0110001", "0101111", "0111011", "0110111", "0001011"];
    }

    /**
     * Définir le subset B
     * @return array
     */
    protected function getSubsetB(): array
    {
        return ["0100111", "0110011", "0011011", "0100001", "0011101", "0111001", "0000101", "0010001", "0001001", "0010111"];
    }

    /**
     * Définir le subset C
     * @return array
     */
    protected function getSubsetC(): array
    {
        return ["1110010", "1100110", "1101100", "1000010", "1011100", "1001110", "1010000", "1000100", "1001000", "1110100"];
    }
}
