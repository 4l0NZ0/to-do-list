<?php
namespace App\Application\UseCase;

use App\Domain\Repository\TaskRepositoryInterface;

//Use Case for deleting a task. 
//No business logic here. Just delegates the operation to the repo which handles the DB operations.  


class DeleteTaskHandler{

  //Repo interface for interacting with tasks data. Interaction with the DB. 
  private TaskRepositoryInterface $taskRepositoryInterface;

  //Constructor for dependect Injection
  public function __construct( TaskRepositoryInterface $taskRepositoryInterface){
    $this->taskRepositoryInterface = $taskRepositoryInterface;
  }

  //Handles the delete task. 
  //Calls the repository to delete the task. 
  public function handle(string $taskId):void{

    $this->taskRepositoryInterface->deleteTask($taskId);

  }

}