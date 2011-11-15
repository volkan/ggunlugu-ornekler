<?php

require 'gereksinimler.php';


use Zend\EventManager\EventManager;

$events = new EventManager();

$events->attach('yap', function($e) {
    $event  = $e->getName();
    $params = $e->getParams();
    printf(
        'Yakalanan Olay "%s", parametreleri %s',
        $event,
        json_encode($params)
    );
});

$params = array('foo' => 'bar', 'baz' => 'bat');
$events->trigger('yap', null, $params);



