Piwik Extension for Yii 2
===========================

This extension adds a javascript tracking of [Piwik](http://piwik.org/) for [Yii framework 2.0](http://www.yiiframework.com).

For license information check the [LICENSE](LICENSE)-file.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require sitawit/yii2-piwik *
```

or add

```json
"sitawit/yii2-piwik": "*"
```

to the `require` section of your composer.json.


Usage & Documentation
---------------------

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'bootstrap' => [
        ...
        'piwik',
        ...
    ],
    ...
    'components' => [
        ...
        'piwik' => [
            'class' => 'sitawit\piwik\Piwik',
            'trackerUrl' => 'tracker-url',
            'siteId' => 'id-of-website'
        ],
        ...
    ],
    ...
];
```
