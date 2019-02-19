<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:41
 */

namespace ThalassaWeb\BarcodeHelper;

use ThalassaWeb\BarcodeHelper\ancetre as Ancetre;
use ThalassaWeb\BarcodeHelper\code128 as Code128;
use ThalassaWeb\BarcodeHelper\code93 as Code93;
use ThalassaWeb\BarcodeHelper\dft as Dft;
use ThalassaWeb\BarcodeHelper\ean as Ean;
use ThalassaWeb\BarcodeHelper\ean\_13 as Ean13;

class BarcodeHelper
{
    /**
     * Obtenir le bon helper
     * @param int $mode
     * @return Ancetre\Barcode
     * @throws Ancetre\BarcodeInconnuException
     */
    public static function getBarcode(int $mode): Ancetre\Barcode {
        return new Ancetre\Barcode(static::getEncodeur($mode), static::getValidator($mode), static::getCalculator($mode), static::getTransformateur($mode));
    }

    /**
     * Obtenir le validateur
     * @param int $mode
     * @return Ancetre\IValidateur
     */
    private static function getValidator(int $mode): Ancetre\IValidateur {
        switch ($mode) {
            case EnumBarcode::EAN_13_FONT:
            case EnumBarcode::EAN_13_BIN:
                return new Ean13\Validator();
            case EnumBarcode::CODE_93_FONT:
            case EnumBarcode::CODE_93_BIN:
                return new Code93\Validator();
            case EnumBarcode::CODE_128_BIN:
            case EnumBarcode::CODE_128_FONT:
                return new Code128\Validator();
            default:
                return new Dft\Validator();
        }
    }

    /**
     * Obtenir le calculateur
     * @param int $mode
     * @return Ancetre\ICalculateur
     */
    private static function getCalculator(int $mode): Ancetre\ICalculateur {
        switch ($mode) {
            case EnumBarcode::EAN_13_FONT:
            case EnumBarcode::EAN_13_BIN:
                return new Ean\Calculator(13);
            case EnumBarcode::CODE_93_FONT:
            case EnumBarcode::CODE_93_BIN:
                return new Code93\Calculator();
            case EnumBarcode::CODE_128_BIN:
            case EnumBarcode::CODE_128_FONT:
                return new Code128\Calculator();
            default:
                return new Dft\Calculator();
        }
    }

    /**
     * Obtenir l'encodeur
     * @param int $mode
     * @return Ancetre\IEncodeur
     * @throws Ancetre\BarcodeInconnuException
     */
    private static function getEncodeur(int $mode): Ancetre\IEncodeur {
        switch ($mode) {
            case EnumBarcode::CODE_93_BIN:
                return new Code93\BinEncodeur();
            case EnumBarcode::CODE_93_FONT:
                return new Code93\FontEncodeur();
            case EnumBarcode::EAN_13_BIN:
                return new Ean13\BinEncodeur();
            case EnumBarcode::EAN_13_FONT:
                return new Ean13\FontEncodeur();
            case EnumBarcode::CODE_128_BIN:
                return new Code128\BinEncodeur();
            case EnumBarcode::CODE_128_FONT:
                return new Code128\FontEncodeur();
        }
        throw new Ancetre\BarcodeInconnuException("Le mode #$mode est inconnu !");
    }

    /**
     * @param int $mode
     * @return Ancetre\ITransformateur
     */
    private static function getTransformateur(int $mode): Ancetre\ITransformateur {
        if ($mode === EnumBarcode::CODE_128_BIN || $mode === EnumBarcode::CODE_128_FONT) {
            return new Code128\Transformateur();
        }
        return new Dft\Transformator();
    }
}
