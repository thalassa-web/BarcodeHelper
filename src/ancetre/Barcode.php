<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 11/02/2019
 * Time: 17:10
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;

/**
 * Classe abstraite permettant de définir comment :
 *     - Obtenir le checksum d'un codebarre
 *     - Valider une chaîne d'entrée
 *     - Encoder en un format de sortie
 * @package ThalassaWeb\BarcodeHelper\ancetre
 */
class Barcode
{
    /**
     * @var IValidateur
     */
    private $validateur;

    /**
     * @var ICalculateur
     */
    private $calculateur;

    /**
     * @var IEncodeur
     */
    private $encodeur;

    /**
     * Barcode constructor.
     * @param IValidateur $validateur
     * @param ICalculateur $calculateur
     */
    public function __construct(IEncodeur $encodeur, IValidateur $validateur = null, ICalculateur $calculateur = null)
    {
        $this->validateur = $validateur;
        $this->calculateur = $calculateur;
        $this->encodeur = $encodeur;
    }

    /**
     * Validation des données
     * @param string $donnees
     * @return bool
     */
    final public function valider(string $donnees): bool {
        if ($this->validateur === null) {
            return true;
        }
        return $this->validateur->valider($donnees);
    }

    /**
     * Vérification des données d'entrée
     * @param string $donnees
     * @throws ValidationException
     */
    private function validerDonnees(string $donnees) {
        if (!$this->valider($donnees)) {
            throw new ValidationException("Données d'entrée non cohérentes !");
        }
    }

    /**
     * Validation + calcul checksum
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    final public function getChecksum(string $donnees): string {
        $this->validerDonnees($donnees);
        if ($this->calculateur === null) {
            return '';
        }
        return $this->calculateur->getCleControle($donnees);
    }

    /**
     * Validation + calcul encodage
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    public function encoder(string $donnees): string {
        $this->validerDonnees($donnees);
        return $this->encodeur->encoder($donnees . $this->getChecksum($donnees));
    }
}
