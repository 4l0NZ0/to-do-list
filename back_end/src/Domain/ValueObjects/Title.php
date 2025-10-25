<?php
namespace App\Domain\ValueObjects;

class Title{

    // Holds our title value 
    private string $value;


    public function __construct(string $value){
        // We want to check if not empty. If empty throw InvalidArgument
        if (empty($value)){
            throw new InvalidArgumentException("The title is empty. Please provide a title.");
        }

        //else the value is not empty and you set the given value to the object value 
        $this-> value = $value;

    }

    //Used to get the value 
    public function getValue():string{
        return $this->value;
    }



}



?>