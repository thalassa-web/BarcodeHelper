<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:50
 */

namespace ThalassaWeb\BarcodeHelper;

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
     * @var string
     */
    private static $patternInvalide = "#[^A-Z0-9 .$/+%-]#";

    /**
     * Table des caractères CODE93
     * @var array
     */
    private static $tableCharacteres = [
        '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6,
        '7' => 7, '8' => 8, '9' => 9, 'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13,
        'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20,
        'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27,
        'S' => 28, 'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34,
        'Z' => 35, '-' => 36, '.' => 37, ' ' => 38, '$' => 39, '/' => 40, '+' => 41,
        '%' => 42, '!' => 43, '#' => 44, '&' => 45, '@' => 46,
    ];

    /**
     * Caractère Start/Stop
     * @var string
     */
    private $startStop;

    /**
     * Generateur constructor.
     * @param string $startStop
     */
    public function __construct(string $startStop = '*')
    {
        $this->startStop = $startStop;
    }

    /**
     * Encoder des données en code 93
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    public function encoder(string $donnees): string {
        // Il y a autre chose que les caractères autorisés -> erreur
        if (preg_match(self::$patternInvalide, $donnees)) {
            throw new ValidationException("Les données d'entrées ne sont pas encodable en code 93 !");
        }
        return $this->startStop . $donnees . $this->calculer($donnees) . $this->startStop;
    }

    /**
     * Vérification des checks digit
     * @param string $chaine
     * @return bool
     */
    public function verifier(string $chaine): bool {
        $lenSs = count($this->startStop);
        if (substr($chaine, -$lenSs) !== $this->startStop || substr($chaine, 0, $lenSs) !== $this->startStop) {
            throw new ValidationException("Le charactère Start/Stop attendu est {$this->startStop} !");
        }
        $chaineSansStartStop = substr($chaine, $lenSs, count($chaine) - (2 * $lenSs));
        $checksum = substr($chaineSansStartStop, -2, 2);
        $donnees = substr($chaineSansStartStop, 0, -2);
        return $this->calculer($donnees) === $checksum;
    }

    /**
     * Calcul d'un check digit
     * @param string $chaine
     * @param int $maxPoids
     * @return string
     */
    private function calculerCheckDigit(string $chaine , int $maxPoids = 20): string {
        $valeur = 0;
        $data = str_split($chaine);
        $longueur = count($data) % $maxPoids;
        // Calcul de la somme des poids x valeur du caractère
        foreach ($data as $char) {
            $longueur = $longueur == 0 ? $maxPoids : $longueur;
            $valeur += self::$tableCharacteres[$char] * $longueur;
            --$longueur;
        }
        return array_search(($valeur % 47), self::$tableCharacteres);
    }

    /**
     * Calcul des 2 checks digit
     * @param string $chaine
     * @return string
     */
    private function calculer(string $chaine): string {
        // Calcul du 1er check digit
        $checkDigit1 = $this->calculerCheckDigit($chaine);
        // Le 1er digit est ajouté à la chaine initial pour le calcul du 2nd digit
        // On retourne ensuite les deux checks digits l'un derrière l'autre
        return $checkDigit1 . $this->calculerCheckDigit($chaine . $checkDigit1, 15);
    }
}
