<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:50
 */

namespace ThalassaWeb\BarcodeHelper;

use ThalassaWeb\BarcodeHelper\correspondance\Element;
use ThalassaWeb\BarcodeHelper\correspondance\Table;

/**
 * Généra
 * @package Code93
 */
class Code93
{
    /**
     * Le code 93 permet de codifier :
     *   - les 26 lettres majuscules (A à Z),
     *   - les 10 chiffres (0 à 9 ) ainsi que
     *   - les 7 caractères (- , . , Espace,  $ , / , + , % )
     */
    const PATTERN_INVALIDE = "#[^A-Z0-9 .$/+%-]#";
    /**
     * Table de caractères sous forme [[caractère, valeur, représentation binaire],…]
     */
    const TABLE_CARACTERES = [
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
    ];

    /**
     * Représentations binaires de caractères d'encadrement
     */
    const START_STOP_BINAIRE = 0b101011110;
    const TERMINAISON_BINAIRE = 0b100000000;

    /**
     * @var Table
     */
    private static $tableCorrespondance;

    /**
     * Generateur constructor.
     */
    public function __construct()
    {
        if (self::$tableCorrespondance === null) {
            self::$tableCorrespondance = Table::getInstanceFromTableSimple(self::TABLE_CARACTERES);
        }
    }

    /**
     * Encoder des données en code 93 sous forme de chaîne
     * @param string $donnees
     * @param string $startStop
     * @param string $terminaison
     * @return string
     * @throws ValidationException
     * @throws correspondance\ElementNotFoundException
     */
    public function encoder(string $donnees, string $startStop = '*', string $terminaison = '|'): string {
        // Il y a autre chose que les caractères autorisés -> erreur
        $this->verifierDonnees($donnees);
        $strDigits = implode('', $this->getCheckDigits(static::donneesToElements($donnees)));
        // Données agrémentées des données de vérification
        return $startStop . $donnees . $strDigits . $startStop . $terminaison;
    }

    /**
     * Encodage en représentation binaire
     * Le retour est un tableau d'entier chaque entier peyt être comvertit er sa représentation binaire par la fonction decbin
     * @see http://php.net/manual/fr/function.decbin.php
     * @param string $donnees
     * @return int[]
     * @throws ValidationException
     * @throws correspondance\ElementNotFoundException
     */
    public function encoderBinaire(string $donnees): array {
        // Il y a autre chose que les caractères autorisés -> erreur
        $this->verifierDonnees($donnees);
        // Transformer en liste d'éléments
        $dataEntree = static::donneesToElements($donnees);
        // Ajout des éléments de controle
        $data = array_merge($dataEntree, $this->getCheckDigits($dataEntree));
        // Récupération sous forme binaire
        $dataBinaires = array_map(function (Element $element) {return $element->getRepresentationBinaire();}, $data);
        // Encadrement
        return array_merge([static::START_STOP_BINAIRE], $dataBinaires, [static::START_STOP_BINAIRE, static::TERMINAISON_BINAIRE]);
    }

    /**
     * Vérification des checks digit
     * @param string $chaine
     * @return bool
     * @throws correspondance\ElementNotFoundException
     */
    public function verifier(string $chaine): bool {
        $nbCheckDigit = 2;
        $checksum = substr($chaine, -$nbCheckDigit);
        $elements = static::donneesToElements(substr($chaine, 0, -$nbCheckDigit));
        return implode('', $this->getCheckDigits($elements)) === $checksum;
    }

    /**
     * Vérification des données d'entrée
     * @param string $donnees
     * @throws ValidationException
     */
    private function verifierDonnees(string $donnees) {
        if (preg_match(self::PATTERN_INVALIDE, $donnees)) {
            throw new ValidationException("Les données d'entrées ne sont pas encodable en code 93 !");
        }
    }

    /**
     * Calcul des 2 checks digit
     * @param Element[] $data
     * @return Element[]
     * @throws correspondance\ElementNotFoundException
     */
    private function getCheckDigits(array $data): array {
        // Calcul du 1er check digit
        $checkDigits[] = static::calculerCheckDigit($data);
        // Le 1er digit est ajouté à la chaine initial pour le calcul du 2nd digit
        $checkDigits[] = static::calculerCheckDigit(array_merge($data, $checkDigits),15);
        // On retourne ensuite les deux checks digits l'un derrière l'autre
        return $checkDigits;
    }

    /**
     * Transformer une chaine en liste d'éléments
     * @param string $donnees
     * @return Element[]
     */
    private static function donneesToElements(string $donnees): array {
        return array_map(function (string $char) {
            return self::$tableCorrespondance->getElementParCaractere($char);
        } ,str_split($donnees));
    }

    /**
     * Calcul d'un check digit
     * @param Element[] $data
     * @param int $maxPoids
     * @return Element
     * @throws correspondance\ElementNotFoundException
     */
    private static function calculerCheckDigit(array $data , int $maxPoids = 20): Element {
        $valeur = 0;
        $longueur = count($data) % $maxPoids;
        // Calcul de la somme des poids x valeur du caractère
        foreach ($data as $element) {
            $longueur = $longueur == 0 ? $maxPoids : $longueur;
            $valeur += ($element->getValeur() * $longueur--);
        }
        return self::$tableCorrespondance->getElementParValeur($valeur % 47);
    }
}
