<?php

require 'gereksinimler.php';


use Zend\EventManager\EventCollection,
    Zend\EventManager\EventManager,
    Zend\EventManager\StaticEventManager;

$events = StaticEventManager::getInstance();
$events->attach('Example', 'click', function($e) {
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


$example = new Example();
$example->click('bar', 'bat');



class Example
{
    protected $events;
   
    public function setEventManager(EventCollection $events)
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



