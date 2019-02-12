<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:33
 */

namespace ThalassaWeb\BarcodeHelper\symbologie;


class Code93Binaire extends Code93
{
    /**
     * Table de correspondance chaine => représentation binaire
     * @var array
     */
    const CORRESPONDANCE_BINAIRE = [
        '0' => "100010100", '1' => "101001000", '2' => "101000100", '3' => "101000010",
        '4' => "100101000", '5' => "100100100", '6' => "100100010", '7' => "101010000",
        '8' => "100010010", '9' => "100001010", 'A' => "110101000", 'B' => "110100100",
        'C' => "110100010", 'D' => "110010100", 'E' => "110010010", 'F' => "110001010",
        'G' => "101101000", 'H' => "101100100", 'I' => "101100010", 'J' => "100110100",
        'K' => "100011010", 'L' => "101011000", 'M' => "101001100", 'N' => "101000110",
        'O' => "100101100", 'P' => "100010110", 'Q' => "110110100", 'R' => "110110010",
        'S' => "110101100", 'T' => "110100110", 'U' => "110010110", 'V' => "110011010",
        'W' => "101101100", 'X' => "101100110", 'Y' => "100110110", 'Z' => "100111010",
        '-' => "100101110", '.' => "111010100", ' ' => "111010010", '$' => "111001010",
        '/' => "101101110", '+' => "101110110", '%' => "110101110", '!' => "100100110",
        '#' => "111011010", '&' => "111010110", '@' => "100110010"
    ];

    /**
     * Chaîne début/fin
     * @return string
     */
    protected function getStartStop(): string
    {
        return '101011110';
    }

    /**
     * Chaîne de terminaison
     * @return string
     */
    protected function getTerminaison(): string
    {
        return '100000000';
    }

    /**
     * La valeur encodée à partir de la valeur d'origine
     * @param string $valeur
     * @return string
     */
    protected function getValeurEncodee(string $valeur): string
    {
        return static::CORRESPONDANCE_BINAIRE[$valeur];
    }
}
