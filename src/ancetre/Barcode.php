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
abstract class Barcode
{
    /**
     * Calcul du checksum
     * @param string $donnees
     * @return string
     */
    abstract protected function calculerChecksum(string $donnees): string;

    /**
     * Calcul de l'encodage
     * @param string $donnees
     * @return string
     */
    abstract protected function calculerEncodage(string $donnees): string;

    /**
     * Définir comment valider les données
     * @param string $donnees
     * @return bool
     */
    abstract public function valider(string $donnees): bool;

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
    public function getChecksum(string $donnees): string {
        $this->validerDonnees($donnees);
        return $this->calculerChecksum($donnees);
    }

    /**
     * Validation + calcul encodage
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    public function encoder(string $donnees): string {
        $this->validerDonnees($donnees);
        return $this->calculerEncodage($donnees);
    }
}
