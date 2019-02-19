<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 18/02/2019
 * Time: 11:25
 */

namespace ThalassaWeb\BarcodeHelper\code128;

use ThalassaWeb\BarcodeHelper\ancetre\ITransformateur;

class Transformateur implements ITransformateur
{
    /**
     * @var Enchainement
     */
    private $enchainement;

    /**
     * On ajoute aux données d'entrée le Subset de démarrage ainsi que les potentiels Subsets intercalaires
     * @param string $donnees
     * @return Enchainement
     */
    public function transformer(string $donnees)
    {
        $this->enchainement = new Enchainement();
        return $this->calculerEnchainementAvecSubset($donnees);
    }

    /**
     * Calcul des enchainements avec Subsets pour optimisation taille
     * @param string $donnees
     * @param Enchainement|null $enchainement
     * @return Enchainement
     */
    private function calculerEnchainementAvecSubset(string $donnees): Enchainement
    {
        if (strlen($donnees) === 0) {
            return $this->enchainement;
        }
        $nbDigits = strlen($this->getDigitsConsecutifs($donnees));
        // Si on est déjà en subset C, il suffit que les deux prochains caractères soient des digits pour rester en subset C
        // Sinon il faut au moins 4 digits consécutifs pour que le changement de subset soit optimum
        // De plus, si on est sur un nombre de digits impaire, le premier digit est encodé avec le subset précédent
        if (($this->enchainement->getLastSubset() === 'C' && $nbDigits > 1) || ($nbDigits > 3 && $nbDigits % 2 === 0)) {
            // Subset C
            $this->enchainement->ajouterValeur((int) substr($donnees, 0, 2), 'C');
            $donnees = substr($donnees, 2);
        } else {
            $ascii = ord($donnees[0]);
            // La plupart du temps, Subset B
            $subset = 'B';
            if ($ascii < 32 || ($ascii < 96 && $this->enchainement->getLastSubset() === 'A')) {
                // Subset A
                $subset = 'A';
            }
            $this->enchainement->ajouterValeur($this->getValeurSubsetAB($ascii), $subset);
            $donnees = substr($donnees, 1);
        }
        return $this->calculerEnchainementAvecSubset($donnees);
    }

    /**
     * Obtenir les digits consécutifs à partir du premier caractère de $donnees
     * @param string $donnees
     * @param string $prev
     * @return string
     */
    private function getDigitsConsecutifs(string $donnees, string $prev = ''): string {
        if (strlen($donnees) === 0 || !ctype_digit($donnees[0])) {
            return $prev;
        }
        return $this->getDigitsConsecutifs(substr($donnees, 1), $prev . $donnees[0]);
    }

    /**
     * Calcul de la valeur à partir de la valeur ASCII en Subset A et B
     * @param int $valeurAscii
     * @return int
     */
    private function getValeurSubsetAB(int $valeurAscii): int
    {
        if ($valeurAscii < 32) {
            return $valeurAscii + 64;
        }
        return $valeurAscii - 32;
    }
}
