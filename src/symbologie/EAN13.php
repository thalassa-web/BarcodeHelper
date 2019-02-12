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
abstract class EAN13 extends Barcode
{
    /**
     * Permet de déterminer le SET à utiliser pour chaque DIGIT de la 1ère partie du codebarre
     */
    const TABLE_PARITE = ["AAAAA", "ABABB", "ABBAB", "ABBBA", "BAABB", "BBAAB", "BBBAA", "BABAB", "BABBA", "BBABA"];

    /**
     * Chaîne début/fin
     * @return string
     */
    abstract protected function getStartStop(): string;

    /**
     * Chaîne séparateur
     * @return string
     */
    abstract protected function getSeparateur(): string;

    /**
     * La valeur suivant le subset
     * @param string $subset
     * @param int $valeur
     * @return string
     */
    abstract protected function getValeur(string $subset, int $valeur): string;

    /**
     * L' EAN 13 permet de codifier 13 chiffres
     * On accepte 12 chiffres, auquel cas le digit de vérification sera calculé
     * @param string $donnees
     * @return bool
     */
    public function valider(string $donnees): bool
    {
        return preg_match("#[0-9]{12}[0-9]?#", $donnees);
    }

    /**
     * Calcul checksum EAN
     * @param string $donnees
     * @return string
     */
    protected function calculerChecksum(string $donnees): string
    {
        $somme = 0;
        for ($index = 0; $index < 12; $index++) {
            $multiplicateur = ($index % 2) ? 3 : 1;
            $somme += ($multiplicateur * intval($donnees[$index]));
        }
        $digit = 10 - ($somme % 10);
        // 10 => 0
        return strval($digit === 10 ? 0 : $digit);
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
            // 2ème caractère du préfixe (toujours dans le subset A)
            $this->getValeur('A', intval($donnees[1])) .
            // Les cinq caractères du Numéro de Participant (L'enchainement des subset dépend du 1er digit)
            $this->encoderAvecEnchainementSubsets(static::TABLE_PARITE[intval($donnees[0])], substr($donnees, 2, 5)) .
            // Le séparateur central
            $this->getSeparateur() .
            // Les cinq caractères du Numéro d'Article (toujours Subset C)
            $this->encoderAvecEnchainementSubsets("CCCCC", substr($donnees, 7, 5)) .
            // Le check Digit
            $this->getValeur('C', intval($this->calculerChecksum($donnees))) .
            // Le caractère de fin
            $this->getStartStop()
            ;
    }

    /**
     * Encodage des données avec l'enchainement des subsets
     * @param string $enchainementSubsets Sous forme "ABC"
     * @param string $donnees
     * @return string
     */
    private function encoderAvecEnchainementSubsets(string $enchainementSubsets, string $donnees): string {
        $elements = [];
        for ($index = 0; $index < strlen($enchainementSubsets); $index++) {
            $elements[] = $this->getValeur($enchainementSubsets[$index], intval($donnees[$index]));
        }
        return implode('', $elements);
    }
}
