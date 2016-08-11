yii2-double-model-gii
=====================

[![Latest Stable Version](https://poser.pugx.org/claudejanz/yii2-mygii/v/stable.svg)](https://packagist.org/packages/claudejanz/yii2-mygii) [![Total Downloads](https://poser.pugx.org/claudejanz/yii2-mygii/downloads.svg)](https://packagist.org/packages/claudejanz/yii2-mygii) [![Latest Unstable Version](https://poser.pugx.org/claudejanz/yii2-mygii/v/unstable.svg)](https://packagist.org/packages/claudejanz/yii2-mygii) [![License](https://poser.pugx.org/claudejanz/yii2-mygii/license.svg)](https://packagist.org/packages/claudejanz/yii2-mygii)


This generator generates two ActiveRecord class for the specified database table. An empty one you can extend and a Base one which is the same as the original model generatior.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require "nhockizi/yii2-gii": "dev-master"
```

or add

```
"nhockizi/yii2-gii": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
//if your gii modules configuration looks like below:
    $config['modules']['gii'] = 'yii\gii\Module';

//remove this lines
```

```php
//Add this into common/config/main-local.php
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'Generator Model' => [
                'class' => 'nhockizi\gii\generators\model\Generator',
            ],
            'Generator Crud' => [
                'class'     => 'nhockizi\gii\generators\backend\Generator',
            ],
        ],
    ];
```
