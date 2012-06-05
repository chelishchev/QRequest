QRequest
========

Yii. Расширенный класс CHttpRequest.
С помощью данного класса можно обращаться к элементам массивов $_GET, $_POST, $_REQUEST по вложенным ключам.

Пример:
Пусть в $_GET есть данные следующего вида: 
$_GET['Example'][0]['name']

Выполенение QRequest::getQuery('Example[0][name]') позволит получить эти данные.
Если не существует такой цепочки вложенных массивов, то вернется null.


Подключение
===========
Положить QRequest.php в /protected/extensions/

main.php

    'components'=>array(
        ...
        'request' => array(
            'class' => 'ext.QRequest',
        ),


Использование
=============
    Yii::app()->request->getParam('Example[0][name]');

    Yii::app()->request->getPost('Example[0][name]');

    Yii::app()->request->getQuery('Example[0][name]');
