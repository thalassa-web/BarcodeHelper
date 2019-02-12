<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:32
 */

namespace ThalassaWeb\BarcodeHelper\symbologie;


class Code93Font extends Code93
{
    /**
     * Chaîne début/fin
     * @return string
     */
    protected function getStartStop(): string
    {
        return '*';
    }

    /**
     * Chaîne de terminaison
     * @return string
     */
    protected function getTerminaison(): string
    {
        return '|';
    }

    /**
     * Pas d'encodage …
     * @param string $valeur
     * @return string
     */
    protected function getValeurEncodee(string $valeur): string
    {
        return $valeur;
    }
}
