<?php
//Use Case AddTaskHandler
//Here the use case represents what we want to do with the data. 
//Add a task to the system (DB)
namespace App\Application\UseCase;

use App\Application\DTO\TaskDTO;
use App\Domain\ValueObjects\Title;
use App\Domain\Entity\Task;
use App\Domain\Repository\TaskRepositoryInterface;


//Use Case for adding  a task. 
//No business logic here. Just delegates the operation to the repo which handles the DB operations.  


class AddTaskHandler{

    //Repo interface for interacting with tasks data. Interaction with the DB. 
    private TaskRepositoryInterface $taskRepositoryInterface;

     //Constructor for dependect Injection
    public function __construct(TaskRepositoryInterface $taskRepositoryInterface){
        
        $this->taskRepositoryInterface = $taskRepositoryInterface;

    }

 //Handles adding(saving task to DB) a task. 
//Calls the repository to save a task. 

    //We need a function to convert our DTO into a Domain Entity, which is our Task. 
    public function handle(TaskDTO $taskDTO): Task{

        //We take in a DTO
        //extract the title and set it to $title. 
        $title = new Title($taskDTO->title);

        //Put this information or title into the Domain Entity. Which only has a title
        $task = new Task($title);

        $this->taskRepositoryInterface->save($task);

        //Return the task entity (where to include id and date ?). 
        return $task;
    }

}


