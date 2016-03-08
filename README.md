# Searchmetrics API

[![Build Status](https://travis-ci.org/inviqa/searchmetrics.svg?branch=develop)](https://travis-ci.org/inviqa/searchmetrics)

## Overview

Connection library for the Searchmetrics v3 API.

## Installation

```bash
composer require inviqa/searchmetrics
```

## Quickstart

* Create a configuration object

```php
new Searchmetrics\Config\ConnectionConfig($apikey, $apisecret);
```

* Create an API endpoint class

```php
$api = Searchmetrics\Factory\Api\ProjectApiFactory::create($config, 'Optimization');
```

## Useful pages

* [Searchmetrics API endpoint documentation](http://api.searchmetrics.com/v3/documentation/api-calls)

## Contributing

Please ensure any contributions:

* Are submitted with accompanying specs
* Follow PSR-2 (with the exceptions of spec classes, which should follow the
  format currently used by spec classes)
