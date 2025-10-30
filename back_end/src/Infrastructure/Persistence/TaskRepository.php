<?php
//Reference for self : https://symfony.com/doc/current/doctrine.html
namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


class TaskRepository implements TaskRepositoryInterface{
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    //Save to DB 
    public function save(Task $task):void{

       

        try{
 
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $this->entityManager->persist($task);
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
        }catch(\Exception $e){
        throw new \RuntimeException("Failed to save task.");

        }
       
    }

    //delete 
    public function deleteTask(string $taskId):void{


        // We need to find the task by id. If the Task is found set it to $task
            $task = $this->entityManager->getRepository(Task::class)->find($taskId);
        
        //If no task is found we throw an error 
            if(!$task){
                throw $this->createNotFoundException(
                    'No task found'
                );
            }
        //If the task is found we want to remove it from the DB. 
        $this->entityManager->remove($task);
        $this->entityManager->flush();


    }


    public function toggleTask(string $taskId):void{

        // We need to find the task by id. If the Task is found set it to $task
            $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        //If no task is found we throw an error 
            if(!$task){
                throw $this->createNotFoundException(
                    'No task found'
                );
            }
        //If the task is found we want to remove it from the DB. 


        $task->toggleTask();

        $this->save($task);


    }



}