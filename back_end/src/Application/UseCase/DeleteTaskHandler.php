<?php
namespace App\Application\UseCase;

class DeleteTaskHandler{

  private TaskRepositoryInterface $taskRepositoryInterface;

  public function __construct( TaskRepositoryInterface $taskRepositoryInterface){
    $this->taskRepositoryInterface = $taskRepositoryInterface;
  }

  public function handle(string $taskId):void{
    $this->taskRepositoryInterface->deleteTask($taskId);
  }

}