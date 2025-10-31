<?php
// Repository Interface
// We define the operations that can be performed on tasks. 
//Here we do not implement the operations. We just specific the "contract".
//Doing this allows us to later implement a change(for example if we want to change DB) without having to touch other areas of the code. If we need to use a new DB we just implement class foo implements RepositoryInterface. 
namespace App\Domain\Repository;

use App\Domain\Entity\Task;

interface TaskRepositoryInterface{
  


    // Save the task to DB. 
    public function save(Task $task):void; 

    // Delete task from DB by its unique Id.
    public function deleteTask(string $taskId):void;
   
   // Toggle a task as complete or not complete by its unique Id. 
   public function toggleTask(string $taskId):void;

   //Edit the title of a task by its unique Id. 
   public function editTask(string $taskId, string $title):void;

   //Load Tasks from DB 
   public function loadTasks():array;
    
}
