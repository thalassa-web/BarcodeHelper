<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 14/02/2019
 * Time: 14:50
 */

namespace ThalassaWeb\BarcodeHelper\calculateur;


class Code128Enchainement
{
    const VALEURS_START = ['A' => 103, 'B' => 104, 'C' => 105];
    const VALEURS_TRANSFERT = ['A' => 101, 'B' => 100, 'C' => 99];

    private $lastType = '';
    private $enchainement = [];

    public function ajouterValeur(int $valeur, string $type): Code128Enchainement
    {
        if ($this->lastType !== $type) {
            $valeurs = [];
            if (empty($this->lastType)) {
                $valeurs[] = static::VALEURS_START[$type];
            } else {
                $valeurs[] = static::VALEURS_TRANSFERT[$type];
            }
            $valeurs[] = $valeur;
            $this->enchainement[] = ['type' => $type, 'valeurs' => $valeurs];
            $this->lastType = $type;
        } else {
            $this->enchainement[count($this->enchainement) - 1]['valeurs'][] = $valeur;
        }
        return $this;
    }

    public function getLastType(): string
    {
        return $this->lastType;
    }

    public function getEnchainement(): array
    {
        return $this->enchainement;
    }

    public function getValeurs(): array
    {
        $valeurs = [];
        foreach ($this->enchainement as $enchainement) {
            $valeurs = array_merge($valeurs, $enchainement['valeurs']);
        }
        return $valeurs;
    }
}
