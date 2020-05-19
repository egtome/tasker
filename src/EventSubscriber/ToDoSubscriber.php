<?php
namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
/**
 * Description of EventSubscriber
 *
 * @author Gino Tome
 */
class ToDoSubscriber implements EventSubscriber
{
    
    public function getSubscribedEvents(){
        return [
            Events::postPersist
        ];
    }
    
    public function postPersist(){
        //dump('This comes from subscriber!');
    }
    
}
