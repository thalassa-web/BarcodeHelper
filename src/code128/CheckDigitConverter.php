<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 21/02/2019
 * Time: 11:17
 */

namespace ThalassaWeb\BarcodeHelper\code128;


trait CheckDigitConverter
{
    /**
     * Conversion valeur check digit en caractère ASCII
     * @param int $value
     * @param string $subset
     * @return string
     */
    protected function valueToAscii(int $value, string $subset): string {
        if ($subset === 'B' || ($value < 64 && $subset !== 'C')) {
            $value += 32;
        } elseif ($subset === 'A') {
            $value -= 64;
        }
        return chr($value);
    }
    /**
     * Conversion de la valeur ASCII du check digit en sa valeur numérique
     * @param string $ascii
     * @param string $subset
     * @return int
     */
    protected function asciiToValue(string $ascii, string $subset): int {
        $checkDigit = ord($ascii);
        if ($subset === 'A' && $checkDigit < 64) {
            $checkDigit += 64;
        } elseif ($subset === 'B') {
            $checkDigit -= 32;
        }
        return $checkDigit;
    }
}
