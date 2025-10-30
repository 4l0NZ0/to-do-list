<?php
namespace App\Application\UseCase;


//Use Case for editing a tasks title. 
//No business logic here. Just delegates the operation to the repo which handles the DB operations.  

use App\Domain\Repository\TaskRepositoryInterface;

class EditTaskHandler{

//Repo interface for interacting with tasks data. Interaction with the DB. 

  private TaskRepositoryInterface $taskRepositoryInterface;

//Constructor for dependect Injection

  public function __construct( TaskRepositoryInterface $taskRepositoryInterface){
    $this->taskRepositoryInterface = $taskRepositoryInterface;
  }

   //Handles the editing of an existing tasks title. 
  //Calls the repository to edit the task. 
  public function handle(string $taskId , string $title):void{

    $this->taskRepositoryInterface->editTask($taskId,$title);

  }

}