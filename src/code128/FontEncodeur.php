<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 14/02/2019
 * Time: 16:02
 */

namespace ThalassaWeb\BarcodeHelper\code128;

use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;

/**
 * Class BinEncodeur
 * @package ThalassaWeb\BarcodeHelper\encodeur
 */
class FontEncodeur implements IEncodeur
{
    const PLUS_QUE_95 = ["¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬"];

    /**
     * Encodage des données
     * On s'arrange pour retourner des caractères affichables
     * Voir table ASCII étendue
     * @param Enchainement $donnees
     * @param string $checkDigit
     * @return string
     */
    public function encoder($donnees, string $checkDigit = ''): string
    {
        // Chaque valeur est transformée en son caractère ASCII associé
        // Caractère STOP = n° 106 = ¬ "ASCII" 172
        return implode('', array_map(function (int $valeur) {
            // On ne retourne que des caractère affichables, on décale donc de 32
            // Entre 32 et 126 on a 95 caractères affichables
            // Pour les 12 restants, on utilise le tableau PLUS_QUE_95
            return $valeur < 95 ? chr($valeur + 32) : self::PLUS_QUE_95[$valeur-95];
        }, $donnees->getValeurs())) . "{$checkDigit}¬";
    }
}
