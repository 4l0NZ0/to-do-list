<?php
// Repository Interface
// We define the operations that can be performed on tasks. 
//Here we do not implement the operations. We just specific the "contract".
//Doing this allows us to later implement a change(for example if we want to change DB) without having to touch other areas of the code. If we need to use a new DB we just implement class foo implements RepositoryInterface. 
namespace App\Domain\Repository;

use App\Domain\Entity\Task;

interface TaskRepositoryInterface{
    // We need to save
    // Delete
    // Update
    // If we need to update or delete then we need to find the task by id. 


    // save the task to DB
    public function save(Task $task):void; 
    // delete task from DB 
    public function delete(Task $task):void;
    // find a task by given ID
    public function findById(Task $task):void;
    
}
