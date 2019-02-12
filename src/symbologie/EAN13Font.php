<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:50
 */

namespace ThalassaWeb\BarcodeHelper\symbologie;

/**
 * Généra
 * @package EAN13
 */
class EAN13Font extends EAN13
{
    /**
     * EAN 13 => 3 Subsets
     * @see http://www.gomaro.ch/Specifications/EAN13.htm
     */
    const SUBSETS = [
        "A" => ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
        "B" => ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
        "C" => ["K", "L", "M", "N", "O", "P", "Q", "R", "S", "T"]
    ];

    /**
     * Chaîne début/fin
     * @return string
     */
    protected function getStartStop(): string
    {
        return '*';
    }

    /**
     * Chaîne séparateur
     * @return string
     */
    protected function getSeparateur(): string
    {
        return '-';
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
