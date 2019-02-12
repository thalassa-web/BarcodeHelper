# BarcodeHelper

Un helper pour générer / vérifier des codebarres.

## Installation
```
composer require thalassa-web/barcode-helper
```

## Liste des modes gérés
* **Code 93**
  * Format police de caractère (_EnumBarcode::CODE_93_FONT_)
  * Format binaire (_EnumBarcode::CODE_93_BIN_)
* **EAN 13**
  * Format police de caractère (_EnumBarcode::EAN_13_FONT_)
  * Format binaire (_EnumBarcode::EAN_13_BIN_)


## Usage
```php
use ThalassaWeb\BarcodeHelper\BarcodeHelper;
use ThalassaWeb\BarcodeHelper\EnumBarcode;

$code93Bin = BarcodeHelper::getBarcode(EnumBarcode::CODE_93_BIN);
$code93Font = BarcodeHelper::getBarcode(EnumBarcode::CODE_93_FONT);

// Encodage à destination d'une police de caractères
echo $code93Font->encoder("/PT/12AZERTY34");
```
> \*/PT/12AZERTY34TM*|
```php
// Encodage à destination de la police générique
echo $code93Bin->encoder('/PT/12AZERTY34');
```
> 101011110101101110100010110110100110101101110101001000101000100110101000100111010110010010110110010110100110100110110101000010100101000110100110101001100101011110100000000
```php
// Obtention de la clé de contrôle
echo $code93Bin->getChecksum('/PT/12AZERTY34');
```
> TM
```php
// Validation des données
echo $code93Bin->valider('/PT/12AZERTY34');
```
> 1
```php
// Le code 93 n'autorise pas les soulignées «_»
echo $code93Bin->valider('/PT/12AZE_RTY34');
```
> 0

## Informations sur les polices de caractères
### TIW_Code93
La police encode les 47 caractères valides du Code93 plus un caractère Start/Stop et un caractère de terimaison.  
Le Start/Stop est représenté par le caractère «asterisk» (*).  
Le caractère de terminaison est représenté par le caractère «pipe» (|).  
Le présent helper est configuré pour fonctionner avec cette police.

### GenericBarcode
Cette police n'encode que les caractères «0» et «1».  
«0» représente un espace et «1» une barre.  
Pour obtenir le résultat sous forme de «0» et de «1», il suffit d'utiliser la classe de cette manière :
```php
echo BarcodeHelper::getBarcode(EnumBarcode::EAN_13_BIN)->encoder("123456789012"); 
```
