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
* **Code 128**
  * Format police de caractère (_EnumBarcode::CODE_128_FONT_)
  * Format binaire (_EnumBarcode::CODE_128_BIN_)


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
Des polices de caractères ont été générées afin de simplifier l'utilisation.  
Il y a une police générique (GenericBarcode) utilisable lorsque le code à barres à été encodé sous format binaire.  
Il y a également des polices spécifiques par symbologie (TIW_Code93, TIW_EAN13) utilisables lorsque le code à barres a été encodé sous forme de chaîne.

### TIW_Code93
La police encode les 47 caractères valides du Code93 plus un caractère Start/Stop et un caractère de terminaison.  
Le Start/Stop est représenté par le caractère «asterisk» (*).  
Le caractère de terminaison est représenté par le caractère «pipe» (|).  
Le présent helper est configuré pour fonctionner avec cette police.
```php
echo BarcodeHelper::getBarcode(EnumBarcode::CODE_93_FONT)->encoder("/PT/12AZE_RTY34"); 
```

### TIW_EAN13
La police encode les 10 chiffres dans les 3 subsets utilisés par l'EAN13 plus un caractère Start/Stop et un caractère de séparation.  
Le Start/Stop est représenté par le caractère «asterisk» (*).  
Le caractère de séparation est représenté par le caractère «moins» (-).  
Le présent helper est configuré pour fonctionner avec cette police.
```php
echo BarcodeHelper::getBarcode(EnumBarcode::EAN_13_FONT)->encoder("123456789012"); 
```

### TIW_CODE128
La police encode les 102 valeurs utilisées par le code 128 plus trois caractères Start (1 par subset) et un caractère Stop.  
Les caractères Start contiennent une zone de silence en début équivalent à un espace vide de 10 barres.   
Le caractère Stop contient une zone de silence à la fin équivalent à un espace vide de 10 barres.  
La table de composition suivante a été utilisée : http://www.gomaro.ch/Specifications/code128.htm.  
Le présent helper est configuré pour fonctionner avec cette police.
```php
echo BarcodeHelper::getBarcode(EnumBarcode::CODE_128_FONT)->encoder("/PT/12AZE_RTY34"); 
```

### GenericBarcode
Cette police n'encode que les caractères «0» et «1».  
«0» représente un espace et «1» une barre.  
Pour obtenir le résultat sous forme de «0» et de «1», il suffit d'utiliser la classe de cette manière :
```php
echo BarcodeHelper::getBarcode(EnumBarcode::EAN_13_BIN)->encoder("123456789012"); 
echo BarcodeHelper::getBarcode(EnumBarcode::CODE_93_BIN)->encoder("/PT/12AZERTY34");
echo BarcodeHelper::getBarcode(EnumBarcode::CODE_128_BIN)->encoder("/PT/12AZE_RTY34");
```
