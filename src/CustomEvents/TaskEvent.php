<?php
namespace App\CustomEvents;
use App\Entity\Task;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Psr\Log\LoggerInterface;
/**
 * Description of TaskEvent
 *
 * @author Gino Tome
 */
class TaskEvent extends EventDispatcher
{
    public const NAME = 'task.opened';
    protected $task;
    public function __construct(Task $task) 
    {
        $this->task = $task;
    }
    
    public function getTask()
    {
        return $this->task;
    }
}
