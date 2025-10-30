<?php
namespace App\Application\UseCase;


use App\Domain\Repository\TaskRepositoryInterface;



class ToggleTaskHandler{

  private TaskRepositoryInterface $taskRepository;

  public function __construct( TaskRepositoryInterface $taskRepository){
    $this->taskRepository = $taskRepository;
  }

  public function handle(string $taskId):void{

    $this->taskRepository->toggleTask($taskId);

  }

}