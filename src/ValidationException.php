<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 06/02/2019
 * Time: 15:56
 */

namespace ThalassaWeb\BarcodeHelper;


class ValidationException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
