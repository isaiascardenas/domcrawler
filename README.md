# domcrawler

domcrawler for trackingapp

## Instalación

```
composer require isaiascardenas/domcrawler
```

## Uso

La clase 'Domcrawler' tiene un único método público y estático 'parse()' el cual requiere dos parámetros string:

* tracking code: el código de tracking o seguimiento.

* platform: plataforma de tracking, actualmente soporta:

** correos: Correos de Chile
** chilexpress: Chilexpress
** starken: Starken
** dhlgm: Dhl GlobalMail



```php
require 'vendor/autoload.php';

use IsaiasCardenas\Domcrawler\Domcrawler;

var_dump(Domcrawler::parse('RT914943865HK', 'correos'));
```

## Salida

Una petición exitosa se retorna un objeto JSON con 5 atributos:

* exist: Es un booleano que representa se existe o no el código tracking.
* delivered: Es un booleano que representa si el tracking fue entregado o no.
* tracking_number: Es un string que contiene el código de tracking.
* data: Es un json que contiene el ultimo estado del tracking y los datos de entrega si existen.
* history: Es un json que contiene todo el historial del seguimiento del tracking.

![Output](/screenshots/output1.png?raw=true "Sii respuesta")

En caso de que el tracking no haya sido entregado aun el json tendría la siguiente forma:

![Output](/screenshots/output2.png?raw=true "Sii respuesta")

Una petición en la que el código de tracking no exista tendrá la siguiente estructura:

![Output](/screenshots/output3.png?raw=true "Sii respuesta")


## Dependencias

* [Guzzle](https://github.com/guzzle/guzzle)
* [DomCrawler](https://github.com/symfony/DomCrawler)
* [Css-Selector](https://github.com/symfony/css-selector)
