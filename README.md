# Form renderer for Nette Framework forms

-----

[![Build Status](https://travis-ci.org/surda/forms-rendering.svg?branch=master)](https://travis-ci.org/surda/forms-rendering)
[![Licence](https://img.shields.io/packagist/l/surda/forms-rendering.svg?style=flat-square)](https://packagist.org/packages/surda/forms-rendering)
[![Latest stable](https://img.shields.io/packagist/v/surda/forms-rendering.svg?style=flat-square)](https://packagist.org/packages/surda/forms-rendering)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)


## Installation

The recommended way to is via Composer:

```
composer require surda/forms-rendering
```

## Form rendering

Horizontal orientation form

```php
use Surda\Forms\Rendering\Bs4HorizontalFormRenderer;
use Nette\Application\UI\Form;

$form = new Form();
$form->setRenderer(new Bs4HorizontalFormRenderer());
```

Vertical  orientation form

```php
use Surda\Forms\Rendering\Bs4VerticalFormRenderer;
use Nette\Application\UI\Form;

$form = new Form();
$form->setRenderer(new Bs4VerticalFormRenderer());
```
