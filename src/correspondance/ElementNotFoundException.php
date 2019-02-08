<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 08/02/2019
 * Time: 12:23
 */

namespace ThalassaWeb\BarcodeHelper\correspondance;


class ElementNotFoundException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
