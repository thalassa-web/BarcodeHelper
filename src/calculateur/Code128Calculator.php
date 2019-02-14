<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:34
 */

namespace ThalassaWeb\BarcodeHelper\calculateur;

use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;

/**
 * Class Code128Calculator
 * Calcule clé de contrôle Code 128
 * @package ThalassaWeb\BarcodeHelper\calculateur
 */
class Code128Calculator implements ICalculateur
{
    /**
     * Obtenir la clé de contrôle
     * @param string $donnees
     * @return string
     */
    public function getCleControle(string $donnees): string
    {
        $checkDigit = 0;
        $multiplicateur = 0;
        $enchainements = static::calculerEnchainementAvecSubset($donnees);
        foreach ($enchainements->getEnchainement() as $valeurs) {
            foreach ($valeurs['valeurs'] as $valeur) {
                $checkDigit += $valeur * ($multiplicateur === 0 ? 1 : $multiplicateur);
                $multiplicateur++;
            }
        }
        $checkDigit = $checkDigit % 103;
        if ($enchainements->getLastType() === 'C') {
            return strval($checkDigit);
        } else {
            if ($enchainements->getLastType() === 'B' || $checkDigit < 64) {
                $checkDigit += 32;
            } else {
                $checkDigit -= 64;
            }
        }
        return chr($checkDigit);
    }

    /**
     * Calcul de la valeur à partir de la valeur ASCII en Subset A et B
     * @param int $valeurAscii
     * @return int
     */
    private static function getValeurSubsetAB(int $valeurAscii): int
    {
        if ($valeurAscii < 32) {
            return $valeurAscii + 64;
        }
        return $valeurAscii - 32;
    }

    public static function calculerEnchainementAvecSubset(string $donnees, Code128Enchainement $enchainement = null): Code128Enchainement
    {
        if ($enchainement === null) {
            $enchainement = new Code128Enchainement();
        }

        if (strlen($donnees) === 0) {
            return $enchainement;
        }

        $premiers = strlen($donnees) > 1 ? substr($donnees, 0, 2) : '';
        $seconds = strlen($donnees) > 3 ? substr($donnees, 2, 2) : '';
        if (ctype_digit($premiers) && ($enchainement->getLastType() === 'C' || ctype_digit($seconds))) {
            // Subset C
            $enchainement->ajouterValeur((int) $premiers, 'C');
            $donnees = substr($donnees, 2);
        } else {
            $ascii = ord($donnees[0]);
            // La plupart du temps, Subset B
            $type = 'B';
            if ($ascii < 32 || ($ascii < 96 && $enchainement->getLastType() === 'A')) {
                // Subset A
                $type = 'A';
            }
            $enchainement->ajouterValeur(static::getValeurSubsetAB($ascii), $type);
            $donnees = substr($donnees, 1);
        }
        return static::calculerEnchainementAvecSubset($donnees, $enchainement);
    }
}
