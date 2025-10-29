<?php
//Use Case AddTaskHandler
//Here the use case represents what we want to do with the data. 
//Add a task to the system (DB)
namespace App\Application\UseCase;

use APP\Application\DTO\TaskDTO;
use APP\Application\Domain\ValueObjects\Title;


class AddTaskHandler{

    private TaskRepositoryInterface $taskRepository;


    public function __construct(TaskRepositoryInterface $taskRepository){
        $this->taskRepository = $taskRepository;

    }

    //We need a function to convert our DTO into a Domain Entity, which is our Task. 
    public function handleDTO(TaskDTO $taskDTO): Task{

        //We take in a DTO
        //extract the title and set it to $title. 
        $title = new Title($taskDTO->title);

        //Put this information or title into the Domain Entity. Which only has a title
        $task = new Task($title);

        $this->taskRepository->save($task);

        //Return the task entity (where to include id and date ?). 
        return new $task;
    }

}


