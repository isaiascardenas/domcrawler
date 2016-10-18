# domcrawler_correos

domcrawler correos chile

## Instalación

```
composer require isaiascardenas/correoschile
```

## Uso (PHP)

```php
require 'vendor/autoload.php';

$domCrawler = new IsaiasCardenas\CorreosChile\Domcrawler('RT993112324DE');

var_dump($domCrawler->getData());
```

## Salida

Una petición exitosa se retorna un objeto json con 5 atributos:

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
