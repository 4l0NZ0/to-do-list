<?php
namespace App\Application\UseCase;

use App\Domain\Repository\TaskRepositoryInterface;


class LoadTasksHandler{

    private TaskRepositoryInterface $taskRepositoryInterface;

    public function __construct (TaskRepositoryInterface $taskRepositoryInterface){
        $this->taskRepositoryInterface = $taskRepositoryInterface;
    }
    

    public function handle():array{
        return $this->taskRepositoryInterface->loadTasks();
    }

}