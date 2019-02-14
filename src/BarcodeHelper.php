<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:41
 */

namespace ThalassaWeb\BarcodeHelper;

use ThalassaWeb\BarcodeHelper\ancetre\Barcode;
use ThalassaWeb\BarcodeHelper\ancetre\BarcodeInconnuException;
use ThalassaWeb\BarcodeHelper\ancetre\ICalculateur;
use ThalassaWeb\BarcodeHelper\ancetre\IEncodeur;
use ThalassaWeb\BarcodeHelper\ancetre\IValidateur;
use ThalassaWeb\BarcodeHelper\calculateur\Code128Calculator;
use ThalassaWeb\BarcodeHelper\calculateur\Code93Calculator;
use ThalassaWeb\BarcodeHelper\calculateur\DefaultCalculator;
use ThalassaWeb\BarcodeHelper\calculateur\EanCalculator;
use ThalassaWeb\BarcodeHelper\encodeur\Code128BinEncodeur;
use ThalassaWeb\BarcodeHelper\encodeur\Code93BinEncodeur;
use ThalassaWeb\BarcodeHelper\encodeur\Code93FontEncodeur;
use ThalassaWeb\BarcodeHelper\encodeur\Ean13BinEncodeur;
use ThalassaWeb\BarcodeHelper\encodeur\Ean13FontEncodeur;
use ThalassaWeb\BarcodeHelper\validateur\Code128Validator;
use ThalassaWeb\BarcodeHelper\validateur\Code93Validator;
use ThalassaWeb\BarcodeHelper\validateur\DefaultValidator;
use ThalassaWeb\BarcodeHelper\validateur\Ean13Validator;

class BarcodeHelper
{
    /**
     * Obtenir le bon helper
     * @param int $mode
     * @return Barcode
     * @throws BarcodeInconnuException
     */
    public static function getBarcode(int $mode): Barcode {
        return new Barcode(static::getEncodeur($mode), static::getValidator($mode), static::getCalculator($mode));
    }

    /**
     * Obtenir le validateur
     * @param int $mode
     * @return IValidateur
     */
    private static function getValidator(int $mode): IValidateur {
        switch ($mode) {
            case EnumBarcode::EAN_13_FONT:
            case EnumBarcode::EAN_13_BIN:
                return new Ean13Validator();
            case EnumBarcode::CODE_93_FONT:
            case EnumBarcode::CODE_93_BIN:
                return new Code93Validator();
            case EnumBarcode::CODE_128_BIN:
                return new Code128Validator();
            default:
                return new DefaultValidator();
        }
    }

    /**
     * Obtenir le calculateur
     * @param int $mode
     * @return ICalculateur
     */
    private static function getCalculator(int $mode): ICalculateur {
        switch ($mode) {
            case EnumBarcode::EAN_13_FONT:
            case EnumBarcode::EAN_13_BIN:
                return new EanCalculator(13);
            case EnumBarcode::CODE_93_FONT:
            case EnumBarcode::CODE_93_BIN:
                return new Code93Calculator();
            case EnumBarcode::CODE_128_BIN:
                return new Code128Calculator();
            default:
                return new DefaultCalculator();
        }
    }

    /**
     * Obtenir l'encodeur
     * @param int $mode
     * @return IEncodeur
     * @throws BarcodeInconnuException
     */
    private static function getEncodeur(int $mode): IEncodeur {
        switch ($mode) {
            case EnumBarcode::CODE_93_BIN:
                return new Code93BinEncodeur();
            case EnumBarcode::CODE_93_FONT:
                return new Code93FontEncodeur();
            case EnumBarcode::EAN_13_BIN:
                return new Ean13BinEncodeur();
            case EnumBarcode::EAN_13_FONT:
                return new Ean13FontEncodeur();
            case EnumBarcode::CODE_128_BIN:
                return new Code128BinEncodeur();
        }
        throw new BarcodeInconnuException("Le mode #$mode est inconnu !");
    }
}
