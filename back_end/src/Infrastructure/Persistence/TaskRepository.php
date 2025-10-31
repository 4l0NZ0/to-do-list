<?php

//
//Reference for self : https://symfony.com/doc/current/doctrine.html

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;


//Handles all DB operations related to Task entities. 
class TaskRepository implements TaskRepositoryInterface{

    //Doctrine's Entity Manager. Responsible for persisting,updating, and removing entities in the DB. 
    private EntityManagerInterface $entityManager;
    
    // Inject the EntityManager through the constructor for database operations
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    // Get all task from the DB to display 
    public function loadTasks():array{
        try{
            $tasks = $this->entityManager->getRepository(Task::class)->findAll();
            return $tasks; 

        }catch(\Exception $e){
        // If anything goes wrong, throw a RuntimeException so the caller can handle it
        throw new \RuntimeException("Failed to save task.");

        }
    }









    //Save a new task to the Db. 
    public function save(Task $task):void{
        try{
 
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $this->entityManager->persist($task);
        // actually executes the queries (i.e. the INSERT query)
        $this->entityManager->flush();
        }catch(\Exception $e){
        // If anything goes wrong, throw a RuntimeException so the caller can handle it
        throw new \RuntimeException("Failed to save task.");

        }
       
    }

    //Delete a task from the DB by its Id
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

    //Toggle the completion status of a task(either completed or not completed)
    public function toggleTask(string $taskId):void{

        // We need to find the task by id. If the Task is found set it to $task
            $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        //If no task is found we throw an error 
            if(!$task){
                throw $this->createNotFoundException(
                    'No task found'
                );
            }
        //Use the Task entity to toggle the completion. 
        $task->toggleTask();

        $this->save($task);


    }

   // Edit the task title for an existing task 
    public function editTask(string $taskId, string $title):void{

        // We need to find the task by id. If the Task is found set it to $task
         $task = $this->entityManager->getRepository(Task::class)->find($taskId);

        //If no task is found we throw an error 
            if(!$task){
                throw $this->createNotFoundException(
                    'No task found'
                );
            }
        // Once the title is found we need to replace the title with the new title. 
        // In the Task we have a method to change the title. 
        $task->editTitle($title);

       
        // save changes 
        $this->save($task);
     


    }







}