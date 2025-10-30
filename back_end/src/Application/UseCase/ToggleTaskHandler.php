<?php
namespace App\Application\UseCase;


use App\Domain\Repository\TaskRepositoryInterface;



class ToggleTaskHandler{

  private TaskRepositoryInterface $toggleTaskHan;

  public function __construct( TaskRepositoryInterface $taskRepositoryInterface){
    $this->taskRepositoryInterface = $taskRepositoryInterface;
  }

  public function handle(string $taskId):void{

    $this->taskRepositoryInterface->toggleTask($taskId);

  }

}