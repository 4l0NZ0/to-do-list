<?php
namespace App\Domain\ValueObjects;

class TaskStatus{
    //Future features? 

    // Status of a task can either be completed 
    //Status can also be pending(not yet completed)
    //These value need to be constant because they should not be changed 
    // A task only only have these 2 value in our Domain. Either completed or pending

    //Note: to self with DDD Value Objects should be immutable.
    //If their value needs to “change,” you replace the object with a new instance rather than modifying the old one.
    //In DDD, Value Objects are immutable. This means we don’t change them once they are created.
//If the value needs to change, we create a new object.
//This makes our code predictable, avoids accidental bugs from shared references, and clearly represents real-world values that don’t really change on their own.

    private const PENDING = 'pending';
    private const COMPLETED = 'completed';
    private string $status ; 



    public function __construct(string $status){
        $this->status = $status;
    }

    //sets the status to pending 
    public static function pending():self{
        return new self(self::PENDING);
    }
    
    //sets the status to completed
    public static function completed():self{
        return new self(self::COMPLETED);
    }

    // get the value of status. Either completed or pending 
    public function value():string{
        return $this->status; 
    }



}


?>