<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 18/02/2019
 * Time: 10:54
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;


interface ITransformateur
{
    /**
     * Transformer les données d'entrée à destination de l'encodeur
     * @param string $donnees
     * @return string
     */
    public function transformer(string $donnees);
}
