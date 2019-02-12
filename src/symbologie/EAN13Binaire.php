<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 11/02/2019
 * Time: 17:14
 */

namespace ThalassaWeb\BarcodeHelper\symbologie;

class EAN13Binaire extends EAN13
{
    /**
     * EAN 13 => 3 Subsets
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    const SUBSETS = [
        "A" => ["0001101", "0011001", "0010011", "0111101", "0100011", "0110001", "0101111", "0111011", "0110111", "0001011"],
        "B" => ["0100111", "0110011", "0011011", "0100001", "0011101", "0111001", "0000101", "0010001", "0001001", "0010111"],
        "C" => ["1110010", "1100110", "1101100", "1000010", "1011100", "1001110", "1010000", "1000100", "1001000", "1110100"]
    ];

    /**
     * Chaîne début/fin
     * @return string
     */
    protected function getStartStop(): string
    {
        return '101';
    }

    /**
     * Chaîne séparateur
     * @return string
     */
    protected function getSeparateur(): string
    {
        return '01010';
    }

    /**
     * La valeur suivant le subset
     * @param string $subset
     * @param int $valeur
     * @return string
     */
    protected function getValeur(string $subset, int $valeur): string
    {
        return static::SUBSETS[$subset][$valeur];
    }
}
