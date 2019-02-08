<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:50
 */

namespace ThalassaWeb\BarcodeHelper;

use ThalassaWeb\BarcodeHelper\ancetre\BarcodeHelper;
use ThalassaWeb\BarcodeHelper\correspondance\Element;
use ThalassaWeb\BarcodeHelper\correspondance\Table;

/**
 * Généra
 * @package Code93
 */
class Code93 extends BarcodeHelper
{
    /**
     * Caractère Start/Stop
     * @var string
     */
    private $startStop = '*';

    /**
     * Caractère de terminaison
     * @var string
     */
    private $terminaison = '|';

    /**
     * Generateur constructor.
     * @param string $startStop
     * @param string $terminaison
     */
    public function __construct(string $startStop = '*', string $terminaison = '|')
    {
        parent::__construct();
        $this->startStop = $startStop;
        $this->terminaison = $terminaison;
    }

    /**
     * Le nom siwple pour des messages
     * @return string
     */
    protected function getNomSimple(): string
    {
        return 'Code 93';
    }

    /**
     * Méthode de vérification des données d'entrée
     * @param string $donnees
     * @return bool
     */
    protected function verifierDonneesEntree(string $donnees): bool
    {
        /*
         * Le code 93 permet de codifier :
         *   - les 26 lettres majuscules (A à Z),
         *   - les 10 chiffres (0 à 9 ) ainsi que
         *   - les 7 caractères (- , . , Espace,  $ , / , + , % )
         */
        return !preg_match("#[^A-Z0-9 .$/+%-]#", $donnees);
    }

    /**
     * Le nombre de digits de vérification
     * @return int
     */
    protected function getNbCheckDigits(): int
    {
        return 2;
    }

    /**
     * Obtenir l'élément de démarrage
     * @return Element
     */
    protected function getStartElement(): Element
    {
        return new Element($this->startStop, -1, 0b101011110);
    }

    /**
     * Élément terminal
     * @return Element
     */
    protected function getElementTerminal(): Element
    {
        return new Element($this->terminaison, -1, 0b100000000);
    }

    /**
     * Obtenir la table de correspondance
     * @return Table
     */
    protected function initTableCorrespondance(): Table
    {
        return Table::getInstanceFromTableSimple([
            ['0', 0, 0b100010100], ['1', 1, 0b101001000], ['2', 2, 0b101000100], ['3', 3, 0b101000010],
            ['4', 4, 0b100101000], ['5', 5, 0b100100100], ['6', 6, 0b100100010], ['7', 7, 0b101010000],
            ['8', 8, 0b100010010], ['9', 9, 0b100001010], ['A', 10, 0b110101000], ['B', 11, 0b110100100],
            ['C', 12, 0b110100010], ['D', 13, 0b110010100], ['E', 14, 0b110010010], ['F', 15, 0b110001010],
            ['G', 16, 0b101101000], ['H', 17, 0b101100100], ['I', 18, 0b101100010], ['J', 19, 0b100110100],
            ['K', 20, 0b100011010], ['L', 21, 0b101011000], ['M', 22, 0b101001100], ['N', 23, 0b101000110],
            ['O', 24, 0b100101100], ['P', 25, 0b100010110], ['Q', 26, 0b110110100], ['R', 27, 0b110110010],
            ['S', 28, 0b110101100], ['T', 29, 0b110100110], ['U', 30, 0b110010110], ['V', 31, 0b110011010],
            ['W', 32, 0b101101100], ['X', 33, 0b101100110], ['Y', 34, 0b100110110], ['Z', 35, 0b100111010],
            ['-', 36, 0b100101110], ['.', 37, 0b111010100], [' ', 38, 0b111010010], ['$', 39, 0b111001010],
            ['/', 40, 0b101101110], ['+', 41, 0b101110110], ['%', 42, 0b110101110], ['!', 43, 0b100100110],
            ['#', 44, 0b111011010], ['&', 45, 0b111010110], ['@', 46, 0b100110010]
        ]);
    }

    /**
     * Calcul des checks digit
     * @param Element[] $data
     * @return Element[]
     * @throws correspondance\ElementNotFoundException
     */
    protected function getCheckDigits(array $data): array {
        // Calcul du 1er check digit
        $checkDigits[] = $this->calculerCheckDigit($data);
        // Le 1er digit est ajouté à la chaine initial pour le calcul du 2nd digit
        $checkDigits[] = $this->calculerCheckDigit(array_merge($data, $checkDigits),15);
        // On retourne ensuite les deux checks digits l'un derrière l'autre
        return $checkDigits;
    }

    /**
     * Calcul d'un check digit
     * @param Element[] $data
     * @param int $maxPoids
     * @return Element
     * @throws correspondance\ElementNotFoundException
     */
    private function calculerCheckDigit(array $data , int $maxPoids = 20): Element {
        $valeur = 0;
        $longueur = count($data) % $maxPoids;
        // Calcul de la somme des poids x valeur du caractère
        foreach ($data as $element) {
            $longueur = $longueur == 0 ? $maxPoids : $longueur;
            $valeur += ($element->getValeur() * $longueur--);
        }
        return $this->getTableCorrespondance()->getElementParValeur($valeur % 47);
    }
}
