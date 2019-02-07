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
    const FORMAT_CHAINE = 0;
    const FORMAT_BINAIRE = 1;

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
     * Représentations binaire des charactères du code 93
     * @var array
     */
    private static $tableBinaires = [
        '0' => '100010100', '1' => '101001000', '2' => '101000100', '3' => '101000010', '4' => '100101000', '5' => '100100100', '6' => '100100010',
        '7' => '101010000', '8' => '100010010', '9' => '100001010', 'A' => '110101000', 'B' => '110100100', 'C' => '110100010', 'D' => '110010100',
        'E' => '110010010', 'F' => '110001010', 'G' => '101101000', 'H' => '101100100', 'I' => '101100010', 'J' => '100110100', 'K' => '100011010',
        'L' => '101011000', 'M' => '101001100', 'N' => '101000110', 'O' => '100101100', 'P' => '100010110', 'Q' => '110110100', 'R' => '110110010',
        'S' => '110101100', 'T' => '110100110', 'U' => '110010110', 'V' => '110011010', 'W' => '101101100', 'X' => '101100110', 'Y' => '100110110',
        'Z' => '100111010', '-' => '100101110', '.' => '111010100', ' ' => '111010010', '$' => '111001010', '/' => '101101110', '+' => '101110110',
        '%' => '110101110', '!' => '100100110', '#' => '111011010', '&' => '111010110', '@' => '100110010',
    ];

    /**
     * Représentation binaire du caractère Start/Stop
     * @var string
     */
    private static $startStopBinaire = '101011110';

    /**
     * Représentation binaire du caractère de terminaison
     * @var string
     */
    private static $terminaisonBinaire = '100000000';

    /**
     * Caractère Start/Stop
     * @var string
     */
    private $startStop;

    /**
     * Caractère de terminaison
     * @var string
     */
    private $terminaison;

    /**
     * Generateur constructor.
     * @param string $startStop
     */
    public function __construct(string $startStop = '*', string $terminaison = '|')
    {
        $this->startStop = $startStop;
        $this->terminaison = $terminaison;
    }

    /**
     * Encoder des données en code 93
     * Sous forme de chaîne normale ou sous forme de chaîne au format binaire
     * @param string $donnees
     * @param int $format @see FORMAT_STRING et FORMAT_BINAIRE
     * @return string
     * @throws ValidationException
     */
    public function encoder(string $donnees, int $format = self::FORMAT_CHAINE): string {
        // Il y a autre chose que les caractères autorisés -> erreur
        if (preg_match(self::$patternInvalide, $donnees)) {
            throw new ValidationException("Les données d'entrées ne sont pas encodable en code 93 !");
        }
        // Données agrémentées des données de vérification
        $donneesChecks = $donnees . $this->calculer($donnees);
        // Données au bon format
        $donneesCompletes = '';
        if ($format === static::FORMAT_BINAIRE) {
            foreach (str_split($donneesChecks) as $char) {
                $donneesCompletes .= self::$tableBinaires[$char];
            }
        } else {
            $donneesCompletes = $donneesChecks;
        }
        // Données finales
        return $this->ajouterCaracteresEntourants($donneesCompletes, $format);
    }

    /**
     * Entourer la chaîne par les startStop
     * @param string $chaine
     * @param int $format
     * @return string
     */
    private function ajouterCaracteresEntourants(string $chaine, int $format = self::FORMAT_CHAINE) {
        $startStop = $format === self::FORMAT_CHAINE ? $this->startStop : self::$startStopBinaire;
        $terminaison = $format === self::FORMAT_CHAINE ? $this->terminaison : self::$terminaisonBinaire;
        return $startStop . $chaine . $startStop . $terminaison;
    }

    /**
     * Vérification des checks digit
     * @param string $chaine
     * @return bool
     */
    public function verifier(string $chaine): bool {
        $checksum = substr($chaine, -2, 2);
        $donnees = substr($chaine, 0, -2);
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
