# BarcodeHelper

Un helper pour générer / vérifier des codebarres.  
Ici une version compatible PHP 5.4 sans composer.

## Usage
```php
include "barcode-helper/require.php";

$code93 = new ThalassaWeb\BarcodeHelper\Code93();
$chaineEncodee = $code93->encoder("/PT/12AZERTY34");

echo $chaineEncodee;
```
> \*/PT/12AZERTY34TM*|
```php
echo $code93->verifier('/PT/12AZERTY34TM');
```
> 1

## Informations sur la police de caractères
La police encode les 47 caractères valides du Code93 plus un caractère Start/Stop et un caractère de terimaison.  
Le Start/Stop est représenté par le caractère «asterisk» (*).  
Le caractère de terminaison est représenté par le caractère «pipe» (|).  
Le présent helper est configuré par défaut pour fonctionner avec cette police.  
Si vous souhaitez utiliser une autre police, il faudra instancier Code93 de la manière suivante (exemple si la police utilise le caractère «Ä» comme Start/Stop et le caractère «Ö» comme terminaison) :  
```php
$code93 = new Code93("Ä", "Ö");
```
