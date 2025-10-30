<?php
namespace App\Domain\Entity;
use App\Domain\ValueObjects\Title;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;






//can do
//when it can do it
//what conditions dictate when it can do that thing

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
//Setters for Object 
public function __construct(Title $title){
    // create unique id for task 
    $this -> id = Uuid::v4()->toString();
     
    $this -> title = $title->getValue();

    $this ->dateCreated = (new \DateTimeImmutable()->format('Y-m-d'));
}

//this function updates if task is completed 
public function markAsCompleted():void{
    $this->status = TaskStatus::completed();
}
public function updateTitle(Title $title):void{
    $this-> title = $title;
}



public function toggleTask():void{
    if ($this->isCompleted == true ){
        $this->isCompleted = false;  
    }
    elseif($this->isCompleted == false){
        $this->isCompleted = true; 
    }
}


public function getId():string{
    return $this->id;
}

public function getTitle():string{
    return $this->title;
}


public function getDateCreated():string{
    return $this->dateCreated;
}



}




?>