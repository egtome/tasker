<?php
namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Task;
use App\CustomEvents\TaskEvent;
/**
 * Description of ToDoListener
 *
 * @author Gino Tome
 */
class TaskListener 
{
    public function postPersist(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if($entity instanceof Task){
            //dump('You just saved a task. Its title is ' . $entity->getTitle());
        }
    }
    public function prePersist(){
        //dump('BEFORE saving....');
    }
    
    public function taskOpened(TaskEvent $taskEvent)
    {
        $title = $taskEvent->getTask()->getTitle();
        //echo "A task with title '$title' has been opened!";
    }
}
