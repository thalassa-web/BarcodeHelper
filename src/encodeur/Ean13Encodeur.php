<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 12:24
 */

namespace ThalassaWeb\BarcodeHelper\encodeur;


use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;

abstract class Ean13Encodeur implements IEncodeur
{
    /**
     * Permet de déterminer le SET à utiliser pour chaque DIGIT de la 1ère partie du codebarre
     */
    const TABLE_PARITE = ["AAAAA", "ABABB", "ABBAB", "ABBBA", "BAABB", "BBAAB", "BBBAA", "BABAB", "BABBA", "BBABA"];

    /**
     * @var string
     */
    private $startStop;

    /**
     * @var string
     */
    private $separateur;

    /**
     * Ean13Encodeur constructor.
     * @param string $startStop
     * @param string $separateur
     */
    public function __construct(string $startStop, string $separateur)
    {
        $this->startStop = $startStop;
        $this->separateur = $separateur;
    }

    /**
     * Définir le subset A
     * @return array
     */
    abstract protected function getSubsetA(): array;

    /**
     * Définir le subset B
     * @return array
     */
    abstract protected function getSubsetB(): array;

    /**
     * Définir le subset C
     * @return array
     */
    abstract protected function getSubsetC(): array;

    /**
     * La valeur suivant le subset
     * @param string $subset
     * @param int $valeur
     * @return string
     */
    private function getValeur(string $subset, int $valeur): string {
        $subsetAUtiliser = $this->getSubsetA();
        switch ($subset) {
            case 'B':
                $subsetAUtiliser = $this->getSubsetB();
                break;
            case 'C':
                $subsetAUtiliser = $this->getSubsetC();
                break;
        }
        return $subsetAUtiliser[$valeur];
    }

    /**
     * Encodage des données
     * @param string $donnees
     * @return string
     */
    public function encoder(string $donnees): string
    {
        // Le caractère de début
        return $this->startStop .
            // 2ème caractère du préfixe (toujours dans le subset A)
            $this->getValeur('A', intval($donnees[1])) .
            // Les cinq caractères du Numéro de Participant (L'enchainement des subset dépend du 1er digit)
            $this->encoderAvecEnchainementSubsets(static::TABLE_PARITE[intval($donnees[0])], substr($donnees, 2, 5)) .
            // Le séparateur central
            $this->separateur .
            // Les cinq caractères du Numéro d'Article (toujours Subset C)
            $this->encoderAvecEnchainementSubsets("CCCCC", substr($donnees, 7, 5)) .
            // Le check Digit
            $this->getValeur('C', substr($donnees, -1)) .
            // Le caractère de fin
            $this->startStop
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
