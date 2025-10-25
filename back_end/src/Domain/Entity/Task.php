<?php
namespace App\Domain\Entity;
namespace App\Domain\ValueObjects\Title;
namespace App\Domain\ValueObjects\TaskStatus;
namespace App\Domain\ValueObjects\DueDate;




//can do
//when it can do it
//what conditions dictate when it can do that thing

class Task{
    //Unique id which identifies this task. 
    private string $id;

    //Holds the title of the task. Type Title
    private Title $title;

    //The task not really need to have a description. It can be empty 
    private ?string $description;

    // either the task it complete or not. Type TaskStatus 
    private TaskStatus $status; 

    // Optional. Does not need to check for Due date. Type DueDate
    private ?Duedate $dueDate;


// We need a function to make the task. The task will need an input for Title, Description, Due date. ( For now)


// reference for naming standards: https://symfony.com/doc/current/contributing/code/standards.html
//Setters for Object 
public function __construct(Title $title, ?string $description = null, ?DueDate $dueDate = null ){
    // create unique id for task 
    $this -> id = Uuid::uuid4()->toString();
     
    $this -> title = $title;

    $this ->description = $description;

    $this -> status = TaskStatus::pending();
    $this ->dueDate = $dueDate;
}

//this function updates if task is completed 
public function markAsCompleted():void{
    $this->status = TaskStatus::completed();
}
public function updateTitle(Title $title):void{
    $this-> title = $title;
}


public function getId():string{
    return $this->id;
}

public function getTitle():Title{
    return $this->title;
}

public function getDescription():?string{
    return $this->description;
}

public function getStatus():TaskStatus{
    return $this->status;
}

public function getDueDate():?DueDate{
    return $this->dueDate;
}



}




?>