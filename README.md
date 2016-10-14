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

* exist: Es un booleano que representa se existe o no el codigo tracking.
* delivered: Es un booleano que representa si el tracking fue entregado o no.
* tracking_number: Es un string que contiene el codigo de tracking.
* data: Es un json que contiene el ultimo estado del tracking y los datos de entrega si existen.
* history: Es un json que contiene todo el historial del seguimiento del tracking.

![Output](/screenshots/output.png?raw=true "Sii respuesta")

## Formatos del RUT

Los formatos validos para el rut pueden venir con puntos o sin estos, aunque es **necesario que venga el guion que separa el digito verificador**.

Ejemplo de rut valido:

* 76.170.582-2
* 76170582-2

## Dependencias

* [Guzzle](https://github.com/guzzle/guzzle)
* [DomCrawler](https://github.com/symfony/DomCrawler)

## Tests

``` php
composer install --dev
./vendor/bin/phpunit
```
