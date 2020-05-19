<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index()
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('login');
        }  
        
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([],['id' => 'DESC']);
        foreach($tasks as $task){
            //echo $task->getUser()->getName() . ' : ' . $task->getHours() . '<br>';
        }
        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }
    
    public function view(EventDispatcherInterface $eventDispatcher, Task $task)
    {
        if(!$task){
            return $this->redirectToRoute('tasks');
        }
        
        //Practice events...
        $taskEvent = new \App\CustomEvents\TaskEvent($task);
        $eventDispatcher->dispatch($taskEvent,\App\CustomEvents\TaskEvent::NAME);
        
        return $this->render('task/view.html.twig', [
            'task' => $task
        ]);        
    }
    
    public function create(Request $request, UserInterface $user)
    {
        if($this->getUser() === null){
            return $this->redirectToRoute('tasks');
        }
        
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            //echo '<pre>';var_dump($task);die();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('tasks_view',['id' => $task->getId()]));
        }
        
        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);        
    }
    
    public function edit(Request $request, UserInterface $user, Task $task)
    {
        if($user === null || ($task->getUser()->getId() !== $user->getId())){
            return $this->redirectToRoute('tasks');
        }
        
        $form = $this->createForm(TaskType::class, $task);
        $form->add('submit', SubmitType::class, ['label' => 'Update Task']);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //$task->setCreatedAt(new \DateTime('now'));
            //$task->setUser($user);
            //echo '<pre>';var_dump($task);die();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            return $this->redirect($this->generateUrl('tasks_view',['id' => $task->getId()]));
        }

        return $this->render('task/edit.html.twig', [
            'edit' => true,
            'form' => $form->createView(),
            'form_title' => 'Edit Task "' . substr($task->getTitle(),0,15) . '"...'
        ]);        
    }
    
    public function list(User $user)
    {
        $tasks = $user->getTasks();
        //echo '<pre>';var_dump($tasks);die();
        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
            'user' => $user
        ]);        
    }
    
    public function delete(UserInterface $user,Task $task)
    {
        if($user === null || ($task->getUser()->getId() !== $user->getId())){
            return $this->redirectToRoute('tasks');
        }
        if(!$task){
            return $this->redirectToRoute('tasks');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('tasks');        
    }
}
