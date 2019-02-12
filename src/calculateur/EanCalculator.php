<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 11:15
 */

namespace ThalassaWeb\BarcodeHelper\calculateur;

use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

/**
 * Class EanCalculator
 * Calcul de la clé de contrôle pour EAN
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class EanCalculator implements ICalculateur
{
    /**
     * La multiplication par trois "mélange" l'ordre des unités
     * @var array
     */
    private static $valeursPaires = [0, 3, 6, 9, 2, 5, 8, 1, 4, 7];

    /**
     * @var int
     */
    private $taille;

    /**
     * EanCalculator constructor.
     * @param int $taille
     */
    public function __construct(int $taille = 13)
    {
        $this->taille = $taille;
    }

    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle(string $donnees): string
    {
        /*
         * Comme on ne se base que sur du modulo 10, seuls les unités importent
         * Le modulo 10 de la somme d'entiers revient à faire la somme des unités de ces derniers
         * et de retrancher 10 au delà de 9
         * Exemple :
         *   Somme + modulo
         *     21 + 3 + 42 + 1 = 67
         *     67 % 10 = 7
         *   Prenons uniquement les unités
         *     1 + 3 + 2 + 1 = 7
         * CQFD
         */
        $somme = 0;
        for ($index = 0; $index < $this->taille - 1; $index++) {
            $valeur = intval($donnees[$index]);
            $valeurCalc = ($index % 2) ? static::$valeursPaires[$valeur] : $valeur;
            $somme = $somme + $valeurCalc;
            $somme = $somme < 10 ? $somme : ($somme - 10);
        }
        $digit = 10 - ($somme === 0 ? 10 : $somme);
        // 10 => 0
        return strval($digit);
    }
}
