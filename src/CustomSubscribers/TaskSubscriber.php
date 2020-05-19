<?php
namespace App\CustomSubscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\CustomEvents\TaskEvent;
/**
 * Description of TaskSubscriber
 *
 * @author Gino Tome
 */
class TaskSubscriber implements EventSubscriberInterface{
    //put your code here
    public static function getSubscribedEvents()
    {
        return[
            TaskEvent::NAME => 'taskOpened'
        ];
        
    }
    
    public function taskOpened(TaskEvent $taskEvent)
    {
        $title = $taskEvent->getTask()->getTitle();
        //echo "From custom subscribers; A task with title '$title' has been opened!";        
    }
}
