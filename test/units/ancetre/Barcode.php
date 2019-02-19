<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 14:37
 */

namespace ThalassaWeb\BarcodeHelper\tests\units\ancetre;

use atoum;

class Barcode extends atoum
{
    /**
     * Valide
     */
    public function testValide() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->calling($validateur)->valider = true;
        $this->given($this->newTestedInstance($encodeur, $validateur))
            ->then
                ->boolean($this->testedInstance->valider("/PT/12AZERTY34"))
                    ->isTrue
        ;
    }

    /**
     * Non valide
     */
    public function testNonValide() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->calling($validateur)->valider = false;
        $this->given($this->newTestedInstance($encodeur, $validateur))
            ->then
                ->boolean($this->testedInstance->valider("/PT/12AZERTY34"))
                    ->isFalse
        ;
    }

    /**
     * Pas de validation = Tout le temps valide
     */
    public function testPasDeValidation() {
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->given($this->newTestedInstance($encodeur))
            ->then
                ->boolean($this->testedInstance->valider("/PT/12AZERTY34"))
                    ->isTrue
        ;
    }

    /**
     * Pas de clé de contrôle
     */
    public function testPasDeCleDeControle() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->calling($validateur)->valider = true;
        $this->given($this->newTestedInstance($encodeur, $validateur))
            ->then
                ->string($this->testedInstance->getChecksum("/PT/12AZERTY34"))
                    ->isEqualTo('')
        ;
    }

    /**
     * Récupération clé de contrôle si données valides
     */
    public function testCleDeControleDonneesValides() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $calculateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
        $this->calling($validateur)->valider = true;
        $this->calling($calculateur)->getCleControle = 'A';
        $this->given($this->newTestedInstance($encodeur, $validateur, $calculateur))
            ->then
                ->string($this->testedInstance->getChecksum("/PT/12AZERTY34"))
                    ->isEqualTo('A')
        ;
    }

    /**
     * Exception lors de la récupération de la clé de contrôle sur données non valides
     */
    public function testCleDeControleDonneesNonValides() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $calculateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
        $this->calling($validateur)->valider = false;
        $this->given($this->newTestedInstance($encodeur, $validateur, $calculateur))
            ->then
            ->exception(function() {
                $this->testedInstance->getChecksum("/PT/12AZERTY34");
            })
        ;
    }

    /**
     * Récupération clé de contrôle si données valides
     */
    public function testEncodageDonneesValides() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $this->calling($validateur)->valider = true;
        $calculateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
        $this->calling($calculateur)->getCleControle = 'AB';
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->calling($encodeur)->encoder = function ($chaine, $cle) {
            return "*$chaine{$cle}*";
        };
        $this->given($this->newTestedInstance($encodeur, $validateur, $calculateur))
            ->then
                ->string($this->testedInstance->encoder("/PT/12AZERTY34"))
                    ->isEqualTo('*/PT/12AZERTY34AB*')
        ;
    }

    /**
     * Récupération clé de contrôle si données valides
     */
    public function testTransformateur() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $this->calling($validateur)->valider = true;
        $transformateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ITransformateur;
        $this->calling($transformateur)->transformer = function ($chaine) {
            return str_split($chaine);
        };
        $calculateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
        $this->calling($calculateur)->getCleControle = 'AB';
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $this->calling($encodeur)->encoder = function ($array, $cle) {
            $chaine = implode($array);
            return "*$chaine{$cle}*";
        };
        $this->given($this->newTestedInstance($encodeur, $validateur, $calculateur, $transformateur))
            ->then
            ->string($this->testedInstance->encoder("/PT/12AZERTY34"))
            ->isEqualTo('*/PT/12AZERTY34AB*')
        ;
    }

    /**
     * Exception lors de la récupération de la clé de contrôle sur données non valides
     */
    public function testEncodageDonneesNonValides() {
        $validateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
        $encodeur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
        $calculateur = new \mock\ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
        $this->calling($validateur)->valider = false;
        $this->given($this->newTestedInstance($encodeur, $validateur, $calculateur))
            ->then
                ->exception(function() {
                    $this->testedInstance->encoder("/PT/12AZERTY34");
                })
        ;
    }
}
