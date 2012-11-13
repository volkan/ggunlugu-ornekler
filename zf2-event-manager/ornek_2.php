<?php

require 'gereksinimler.php';

use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager;

class Example
{
    protected $events;
   
    public function setEventManager(EventManager $events)
    {
        $this->events = $events;
    }
   
    public function events()
    {
        if (!$this->events) {
            $this->setEventManager(new EventManager(
                array(__CLASS__, get_called_class())
            ));
        }
        return $this->events;
    }
   
    public function click($foo, $baz)
    {
        $params = compact('foo', 'baz');
        $this->events()->trigger(__FUNCTION__, $this, $params);
    }

}

$example = new Example();

$example->events()->attach('click', function($e) {
    $event  = $e->getName();
    $target = get_class($e->getTarget()); // "Example"
    $params = $e->getParams();
    printf(
        'Yakalanan Olay "%s"  hedef: "%s", parametreler %s',
        $event,
        $target,
        json_encode($params)
    );
});

$example->click('bar', 'bat');
//$params = array('bar' => 'bar2', 'bat' => 'bat2');
//$example->events()->trigger('click', null, $params);