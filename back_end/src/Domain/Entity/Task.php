<?php
namespace App\Domain\Entity;
use App\Domain\ValueObjects\Title;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


#[ORM\Entity]
#[ORM\Table(name:'tasks')]

class Task{

    #[ORM\Id]
    #[ORM\Column(type:'string',length:36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'string',length:255)]
    private string $dateCreated;

    #[ORM\Column(type:'boolean')]
    private bool $isCompleted = false ; 

// We need a function to make the task. The task will need an input for Title, Description, Due date. ( For now)


// reference for naming standards: https://symfony.com/doc/current/contributing/code/standards.html
// Constructor for Task entity: initializes ID, title, and creation date
public function __construct(Title $title){
    
    // create unique id for task 
    $this -> id = Uuid::v4()->toString();


    // Set the task title using the given title.  
    $this -> title = $title->getValue();

    //Record the date the task was created and format it to (Year, month, day);
    $this ->dateCreated = (new \DateTimeImmutable()->format('Y-m-d'));
}

//Toggle the task as completed or not completed. If a task is not completed then it marks is as completed. If the task is mark a comleted it is mark as not completed. 
public function toggleTask():void{
    if ($this->isCompleted == true ){
        $this->isCompleted = false;  
    }
    elseif($this->isCompleted == false){
        $this->isCompleted = true; 
    }
}

//Set title of the task to the new title. 
public function editTitle(string $title):void{
    $this->title = $title; 
}


public function getIsCompleted():bool{
    return $this->isCompleted;
}

//Get the id of the task.
public function getId():string{
    return $this->id;
}


//Get the title of the task. 
public function getTitle():string{
    return $this->title;
}


// Get the date for when the task was created. 
public function getDateCreated():string{
    return $this->dateCreated;
}


}




?>