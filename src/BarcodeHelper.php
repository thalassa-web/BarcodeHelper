<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 12/02/2019
 * Time: 09:41
 */

namespace ThalassaWeb\BarcodeHelper;

use ThalassaWeb\BarcodeHelper\ancetre\BascodeInconnuException;
use ThalassaWeb\BarcodeHelper\symbologie\Code93Binaire;
use ThalassaWeb\BarcodeHelper\symbologie\Code93Font;
use ThalassaWeb\BarcodeHelper\symbologie\EAN13Binaire;
use ThalassaWeb\BarcodeHelper\symbologie\EAN13Font;

class BarcodeHelper
{
    /**
     * Obtenir le bon helper
     * @param int $mode
     * @return Barcode
     * @throws BascodeInconnuException
     */
    public static function getBarcode(int $mode): Barcode {
        switch ($mode) {
            case EnumBarcode::CODE_93_BIN:
                return new Code93Binaire();
            case EnumBarcode::CODE_93_FONT:
                return new Code93Font();
            case EnumBarcode::EAN_13_BIN:
                return new EAN13Binaire();
            case EnumBarcode::EAN_13_FONT:
                return new EAN13Font();
            default:
                throw new BascodeInconnuException("Le mode #$mode est inconnu !");
        }
    }
}
