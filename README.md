# yii2-yac
yii2 yac cache


适用于Yii2的[Yac](https://github.com/laruence/yac)API接口类。

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xutl/yii2-yac
```

or add

```
"xutl/yii2-yac": "~1.0.0"
```

to the require section of your `composer.json` file.

配置
----

To use this extension, you have to configure the Connection class in your application configuration:

```php
return [
    //....
    'components' => [
        'cache' => [
            'class' => 'xutl\caching\FileCache',
        ],
    ]
];
```

资源
-----

* [YAC](https://github.com/laruence/yac)