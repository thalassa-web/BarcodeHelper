<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 08/02/2019
 * Time: 12:16
 */

namespace ThalassaWeb\BarcodeHelper\correspondance;


class Element
{
    /**
     * @var string
     */
    private $caractere;

    /**
     * @var int
     */
    private $valeur;

    /**
     * @var int
     */
    private $representationBinaire;

    /**
     * Element constructor.
     * @param string $caractere
     * @param int $valeur
     * @param int $representationBinaire
     */
    public function __construct(string $caractere, int $valeur, int $representationBinaire)
    {
        $this->caractere = $caractere;
        $this->valeur = $valeur;
        $this->representationBinaire = $representationBinaire;
    }

    /**
     * @return string
     */
    public function getCaractere(): string
    {
        return $this->caractere;
    }

    /**
     * @return int
     */
    public function getValeur(): int
    {
        return $this->valeur;
    }

    /**
     * @return int
     */
    public function getRepresentationBinaire(): int
    {
        return $this->representationBinaire;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->caractere;
    }
}
