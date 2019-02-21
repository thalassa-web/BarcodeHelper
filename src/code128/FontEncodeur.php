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
        $valeurs = $donnees->getValeurs();
        $valeurs[] = ord($checkDigit);
        $valeurs[] = 172;
        return implode('', array_map(function (int $valeur) {
            // On ne retourne que des caractère affichables, on décale donc de 32
            $valeurAffichable = $valeur + 32;
            // Comme on doit encoder 106 caractères et que de 127 à 160 ils ne sont pas affichables
            // On décale de 34
            // On aura donc des caractères pouvant aller de 32 à 126 et de 161 à 172
            return chr($valeurAffichable > 126 ? $valeurAffichable + 34 : $valeurAffichable);
        }, $valeurs));
    }
}
