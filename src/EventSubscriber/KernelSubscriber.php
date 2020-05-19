<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
/**
 * Description of EventSubscriber
 *
 * @author Gino Tome
 */
class KernelSubscriber implements EventSubscriberInterface
{
    
    public static function getSubscribedEvents(){
        return [
            KernelEvents::EXCEPTION => [
                ['showMyErrorMessage',10]
            ]
        ];
    }
    
    public function showMyErrorMessage(){
        //dump('ERROR');
    }
    
}
