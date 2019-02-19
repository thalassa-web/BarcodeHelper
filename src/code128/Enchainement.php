<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 14/02/2019
 * Time: 14:50
 */

namespace ThalassaWeb\BarcodeHelper\code128;

/**
 * Class Enchainement
 * Classe permettant de conserver les valeurs par subset (dans l'ordre)
 * ainsi que le dernier subset utilisé
 * @package ThalassaWeb\BarcodeHelper\code128
 */
class Enchainement
{
    const VALEURS_START = ['A' => 103, 'B' => 104, 'C' => 105];
    const VALEURS_TRANSFERT = ['A' => 101, 'B' => 100, 'C' => 99];

    private $lastSubset = '';
    private $valeurs = [];

    /**
     * Ajouter une valeur, si le subset est le même on ajoute à la liste en cours
     * Sinon on débute une nouvelle liste avec le subset défini
     * @param int $valeur
     * @param string $subset
     * @return Enchainement
     */
    public function ajouterValeur(int $valeur, string $subset): Enchainement
    {
        if (empty($this->lastSubset) && !in_array($valeur, static::VALEURS_START)) {
            $this->ajouterValeur(static::VALEURS_START[$subset], $subset);
        } elseif ($this->lastSubset !== $subset && !empty($this->lastSubset)) {
            $this->ajouterValeur(static::VALEURS_TRANSFERT[$subset], $this->lastSubset);
        }
        $this->valeurs[] = $valeur;
        $this->lastSubset = $subset;
        return $this;
    }

    /**
     * Obtenir le dernier subset utilisé
     * @return string
     */
    public function getLastSubset(): string
    {
        return $this->lastSubset;
    }

    /**
     * Obtenir les valeurs regroupées dans une liste simple
     * Ici on pert l'info de subset pour chaque valeur
     * @return array
     */
    public function getValeurs(): array
    {
        return $this->valeurs;
    }

    /**
     * L'enchainement sous forme de JSON
     * [{"type": 'B', "valeurs": [1, 2, 3 …]], …]
     * @return string
     */
    public function __toString(): string
    {
        return json_encode(['lastSubset' => $this->getLastSubset(), 'valeurs' => $this->getValeurs()]);
    }
}
