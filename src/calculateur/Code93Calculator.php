<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:36
 */

namespace ThalassaWeb\BarcodeHelper\calculateur;


use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

class Code93Calculator implements ICalculateur
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

    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle(string $donnees): string
    {
        // Calcul du 1er check digit
        $checkDigits = $this->calculerCheckDigit($donnees);
        // Le 1er digit est ajouté à la chaine initial pour le calcul du 2nd digit
        $checkDigits .= $this->calculerCheckDigit($donnees . $checkDigits,15);
        // On retourne ensuite les deux checks digits l'un derrière l'autre
        return $checkDigits;
    }
}
