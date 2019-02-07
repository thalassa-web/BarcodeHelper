# BarcodeHelper

Un helper pour générer / vérifier des codebarres.

## Install
```
composer require thalassa-web/barcode-helper
```


## Usage
```php
include "vendor/autoload.php";

use ThalassaWeb\BarcodeHelper\Code93;

$code93 = new Code93('*', '|');
$chaineEncodee = $code93->encoder("/PT/12AZERTY34");

echo $chaineEncodee;
```
> */PT/12AZERTY34TM*|
```php
echo $code93->verifier('/PT/12AZERTY34TM');
```
> 1
