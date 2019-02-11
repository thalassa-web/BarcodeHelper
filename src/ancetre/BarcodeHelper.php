<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 08/02/2019
 * Time: 16:46
 */

namespace ThalassaWeb\BarcodeHelper\ancetre;

use ThalassaWeb\BarcodeHelper\correspondance\Element;
use ThalassaWeb\BarcodeHelper\correspondance\Table;
use ThalassaWeb\BarcodeHelper\ValidationException;

abstract class BarcodeHelper
{
    /**
     * @var Table
     */
    private $tableCorrespondance;

    /**
     * BarcodeHelper constructor.
     */
    public function __construct()
    {
        $this->tableCorrespondance = $this->initTableCorrespondance();
    }

    /**
     * Le nom siwple pour des messages
     * @return string
     */
    abstract protected function getNomSimple(): string;

    /**
     * Le nombre de digits de vérification
     * @return int
     */
    abstract protected function getNbCheckDigits(): int;

    /**
     * Méthode de vérification des données d'entrée
     * @param string $donnees
     * @return bool
     */
    abstract protected function verifierDonneesEntree(string $donnees): bool;

    /**
     * Méthode retournant les digits de vérification
     * Le tableau doit donc être de même taille que définit par getNbCheckDigits()
     * @param Element[] $data
     * @return Element[]
     */
    abstract protected function getCheckDigits(array $data): array;

    /**
     * Obtenir la table de correspondance
     * @return Table
     */
    abstract protected function initTableCorrespondance(): Table;

    /**
     * Obtenir l'élément de démarrage
     * @return Element
     */
    abstract protected function getStartElement(): Element;

    /**
     * Obtenir l'élément de fin
     * Par défaut = début
     * @return Element
     */
    protected function getStopElement(): Element {
        return $this->getStartElement();
    }

    /**
     * Obtenir l'élément terminal
     * Aucun par défaut
     * @return Element
     */
    protected function getElementTerminal(): Element {
        return new Element('', 0, 0);
    }

    /**
     * Transformer une chaine en liste d'éléments
     * @param string $donnees
     * @return Element[]
     */
    final protected function donneesToElements(string $donnees): array {
        return array_map(function (string $char) {
            return $this->tableCorrespondance->getElementParCaractere($char);
        } ,str_split($donnees));
    }

    /**
     * La table de correspondance
     * @return Table
     */
    final protected function getTableCorrespondance(): Table {
        return $this->tableCorrespondance;
    }

    /**
     * Vérification des données d'entrée
     * @param string $donnees
     * @throws ValidationException
     */
    private function validerDonnees(string $donnees) {
        if (!$this->verifierDonneesEntree($donnees)) {
            throw new ValidationException("Les données d'entrées ne sont pas encodable en {$this->getNomSimple()} !");
        }
    }

    /**
     * Encoder des données en code 93 sous forme de chaîne
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    final public function encoder(string $donnees): string {
        // Il y a autre chose que les caractères autorisés -> erreur
        $this->validerDonnees($donnees);
        $strDigits = implode('', $this->getCheckDigits($this->donneesToElements($donnees)));
        // Données agrémentées des données de vérification
        return $this->getStartElement() . $donnees . $strDigits . $this->getStopElement() . $this->getElementTerminal();
    }

    /**
     * Encodage en représentation binaire (sous forme de «0» et de «1»)
     * @see http://php.net/manual/fr/function.decbin.php
     * @param string $donnees
     * @return string
     * @throws ValidationException
     */
    final public function encoderBinaire(string $donnees): string {
        // Il y a autre chose que les caractères autorisés -> erreur
        $this->validerDonnees($donnees);
        // Transformer en liste d'éléments
        $dataEntree = $this->donneesToElements($donnees);
        // Ajout des éléments de controle
        $data = array_merge($dataEntree, $this->getCheckDigits($dataEntree));
        // Encadrement
        array_unshift($data, $this->getStartElement());
        array_push($data, $this->getStopElement(), $this->getElementTerminal());
        $dataFiltrees = array_filter($data, function (Element $element) {return $element->getRepresentationBinaire() > 0;});
        // Récupération sous forme binaire
        return implode('', array_map(function (Element $element) {return decbin($element->getRepresentationBinaire());}, $dataFiltrees));
    }

    /**
     * Vérification des checks digit
     * @param string $chaine
     * @return bool
     */
    final public function verifier(string $chaine): bool {
        if ($this->getNbCheckDigits() <= 0) {
            return true;
        }
        $checksum = substr($chaine, -$this->getNbCheckDigits());
        $elements = static::donneesToElements(substr($chaine, 0, -$this->getNbCheckDigits()));
        return implode('', $this->getCheckDigits($elements)) === $checksum;
    }
}
