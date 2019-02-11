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

$code93 = new Code93();
$chaineEncodee = $code93->encoder("/PT/12AZERTY34");

echo $chaineEncodee;
```
> \*/PT/12AZERTY34TM*|
```php
echo $code93->encoderBinaire('/PT/12AZERTY34');
```
> 101011110101101110100010110110100110101101110101001000101000100110101000100111010110010010110110010110100110100110110101000010100101000110100110101001100101011110100000000
```php
echo $code93->verifier('/PT/12AZERTY34TM');
```
> 1

## Informations sur les polices de caractères
### TIW_Code93
La police encode les 47 caractères valides du Code93 plus un caractère Start/Stop et un caractère de terimaison.  
Le Start/Stop est représenté par le caractère «asterisk» (*).  
Le caractère de terminaison est représenté par le caractère «pipe» (|).  
Le présent helper est configuré par défaut pour fonctionner avec cette police.  
Si vous souhaitez utiliser une autre police, il faudra instancier Code93 de la manière suivante (exemple si la police utilise le caractère «Ä» comme Start/Stop et le caractère «Ö» comme terminaison) :  
```php
$code93 = new Code93("Ä", "Ö");
```
### GenericBarcode
Cette police n'encode que les caractères «0» et «1».  
«0» représente un espace et «1» une barre.  
Pour obtenir le résultat sous forme de «0» et de «1», il suffit d'utiliser la classe de cette manière :
```php
$code93 = new Code93();
echo $code93->encoderBinaire("/PT/12AZERTY34"); 
```
