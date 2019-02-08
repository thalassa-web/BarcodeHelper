<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 08/02/2019
 * Time: 12:16
 */

namespace ThalassaWeb\BarcodeHelper\correspondance;


class Table
{
    /**
     * @var array
     */
    private $mapByCaractere = [];

    /**
     * @var array
     */
    private $mapByValeur = [];

    /**
     * Table constructor.
     * @param Element[] $elements
     */
    public function __construct(array $elements = [])
    {
        array_walk($elements, function (Element $element) {$this->ajouterElement($element);});
    }

    /**
     * Table à partir d'un tableau de la forme
     * [
     *  [caractère, valeur, représentationBinaire],
     *  …
     * ]
     * @param array $tableSimple
     * @return Table
     */
    public static function getInstanceFromTableSimple(array $tableSimple): Table {
        return new Table(array_map(function (array $ligne) {return new Element($ligne[0], $ligne[1], $ligne[2]);}, $tableSimple));
    }

    /**
     * Ajouter un élément à la table
     * @param Element $element
     * @return Table
     */
    public function ajouterElement(Element $element): Table {
        $this->mapByValeur[$element->getValeur()] = $element;
        $this->mapByCaractere[$element->getCaractere()] = $element;
        return $this;
    }

    /**
     * Retrouver un élément par sa valeur
     * @param int $valeur
     * @return Element
     * @throws ElementNotFoundException
     */
    public function getElementParValeur(int $valeur): Element {
        if (!array_key_exists($valeur, $this->mapByValeur)) {
            throw new ElementNotFoundException("Élément avec la valeur {$valeur} introuvable !");
        }
        return $this->mapByValeur[$valeur];
    }

    /**
     * Retrouver un élément par son caractère
     * @param string $caractere
     * @return Element
     * @throws ElementNotFoundException
     */
    public function getElementParCaractere(string $caractere): Element {
        if (!array_key_exists($caractere, $this->mapByCaractere)) {
            throw new ElementNotFoundException("Élément avec le caractère {$caractere} introuvable !");
        }
        return $this->mapByCaractere[$caractere];
    }
}
