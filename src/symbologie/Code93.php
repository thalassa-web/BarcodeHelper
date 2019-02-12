<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:50
 */

namespace ThalassaWeb\BarcodeHelper\symbologie;

use ThalassaWeb\BarcodeHelper\ancetre\Barcode;

/**
 * Généra
 * @package EAN13
 */
abstract class Code93 extends Barcode
{
    /**
     * Valeur numérique de chaque caractère
     */
    const TABLE_VALEURS = [
        '0' => 0 , '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
        'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 18, 'J' => 19,
        'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29,
        'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35, '-' => 36, '.' => 37, ' ' => 38, '$' => 39,
        '/' => 40, '+' => 41, '%' => 42, '!' => 43, '#' => 44, '&' => 45, '@' => 46
    ];

    /**
     * Chaîne début/fin
     * @return string
     */
    abstract protected function getStartStop(): string;

    /**
     * Chaîne de terminaison
     * @return string
     */
    abstract protected function getTerminaison(): string;

    /**
     * La valeur encodée à partir de la valeur d'origine
     * @param string $valeur
     * @return string
     */
    abstract protected function getValeurEncodee(string $valeur): string;

    /**
     * Le code 93 permet de codifier :
     *   - les 26 lettres majuscules (A à Z),
     *   - les 10 chiffres (0 à 9 ) ainsi que
     *   - les 7 caractères (- , . , Espace,  $ , / , + , % )
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return !preg_match("#[^A-Z0-9 .$/+%-]#", $donnees);
    }

    /**
     * Calcul checksum Code 93
     * @param string $donnees
     * @return string
     */
    protected function calculerChecksum(string $donnees): string
    {
        // Calcul du 1er check digit
        $checkDigits = $this->calculerCheckDigit($donnees);
        // Le 1er digit est ajouté à la chaine initial pour le calcul du 2nd digit
        $checkDigits .= $this->calculerCheckDigit($donnees . $checkDigits,15);
        // On retourne ensuite les deux checks digits l'un derrière l'autre
        return $checkDigits;
    }

    /**
     * Permet d'encoder avec des caractères spécifiques pour une police de caractère
     * @param string $donnees
     * @return string
     */
    protected function calculerEncodage(string $donnees): string
    {
        // Le caractère de début
        return $this->getStartStop() .
            // Les données d'entrées
            $this->encoderChaine($donnees) .
            // Les check Digits
            $this->encoderChaine($this->calculerChecksum($donnees)) .
            // Le caractère de fin
            $this->getStartStop() .
            // Le caractère de terminaison
            $this->getTerminaison()
            ;
    }

    /**
     * Transformer une chaine
     * @param string $donnees
     * @return string
     */
    private function encoderChaine(string $donnees): string {
        return implode('', array_map(function (string $char) {return $this->getValeurEncodee($char);}, str_split($donnees)));
    }

    /**
     * Calcul d'un check digit
     * @param string $data
     * @param int $maxPoids
     * @return string
     */
    private function calculerCheckDigit(string $data , int $maxPoids = 20): string {
        $valeur = 0;
        $longueur = strlen($data) % $maxPoids;
        // Calcul de la somme des poids x valeur du caractère
        foreach (str_split($data) as $char) {
            $longueur = $longueur == 0 ? $maxPoids : $longueur;
            $valeur += (static::TABLE_VALEURS[$char] * $longueur--);
        }
        return array_search($valeur % 47, static::TABLE_VALEURS);
    }
}
