<?php
//DDD design - controller 
// Frontend makes an HTTP request (Post request) to url. This controller then handles the request. No Business logic here. All this controller does is receive the request and call our applicatoin Service. 

namespace App\Presentation\Controller; 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\DTO\TaskDTO;
use App\Application\UseCase\AddTaskHandler;
use App\Application\UseCase\DeleteTaskHandler;
use App\Application\UseCase\ToggleTaskHandler;
use App\Application\UseCase\EditTaskHandler;
use App\Application\UseCase\LoadTasksHandler;






//Psudo Code 
//Controller receives a task from the user(frontend). 

class TaskController extends AbstractController{

    // Handles the use case for adding a new task to the system.
    private AddTaskHandler $addTaskHandler;

    // Handles the use case for deleting an existing task by its ID.
    private DeleteTaskHandler $deleteTaskHandler;

    // Handles the use case for toggling a task's completion status.
    private ToggleTaskHandler $toggleTaskHandler;

    // Handles the use case for editing/updating a task's title.
    private EditTaskHandler $editTaskHandler; 

    //Handles the use case for Loading tasks from DB 
    private LoadTasksHandler $loadTasksHandler; 




    //Dependecy Injection
    public function __construct(AddTaskHandler $addTaskHandler,DeleteTaskHandler $deleteTaskHandler,ToggleTaskHandler $toggleTaskHandler,EditTaskHandler $editTaskHandler,LoadTasksHandler $loadTasksHandler){
          $this->addTaskHandler = $addTaskHandler;
          $this->deleteTaskHandler = $deleteTaskHandler;
          $this->toggleTaskHandler = $toggleTaskHandler;
          $this->editTaskHandler = $editTaskHandler;
          $this->loadTasksHandler = $loadTasksHandler;
     }
//Load the tasks from the DB
//Use GET request
#[Route('/tasks',name:'loads_tasks',methods:['GET'])]
    public function loadTasks():JsonResponse{
        
        
        //Call the use case for adding task 
        try{
            //need to return an array of tasks
            $tasks = $this->loadTasksHandler->handle();
            
            if (empty($tasks)){
            return new JsonResponse (['Notice:'=>'You have no tasks. '],400);
            }
            //We return the tasks in DB 
            //Map  tasks to arrays
            $tasksArray = array_map(function($task) {
            return [
                    'id' => $task->getId(),
                    'title' => $task->getTitle(),
                    'dateCreated' => $task->getDateCreated(),
                    'isCompleted' => $task->getIsCompleted(),
                    ];
                    }, $tasks);
            return new JsonResponse($tasksArray,200);

            //if error happens we print it out 
        }catch(\RuntimeException $e){
            return new JsonResponse([
                'success'=> false,
                'message'=> $e->getMessage()
            ],500);
        }
    }






//Save Task 
//Route: POST api/task
// Need to handle the POST request. Extract data needed and send to DTO
#[Route('/task',name:'create_task',methods:['POST'])]
    public function createTask(Request $request):JsonResponse{
        
        //Using json_decode we extract the data and $data is now the extracted data from the request. 
        $data = json_decode($request->getContent(),true);

        //We need to check if the request is valid(not empty). Even if we checked in the frontend. 
        if (empty($data)){
            return new JsonResponse (['error'=>'Title is required'],400);
        }

        //if not empty we create the DTO 
        //Get the title from the data field title 
        $taskDTO = new TaskDTO($data['title']);

        //Call the use case for adding task 
        try{
            $task = $this->addTaskHandler->handle($taskDTO);

            //We return the added data 
            return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'dateCreated' => $task->getDateCreated(),
            ]);

            //if error happens we print it out 
        }catch(\RuntimeException $e){
            return new JsonResponse([
                'success'=> false,
                'message'=> $e->getMessage()
            ],500);
        }
    }

// Toggle Task 
// Since we only want partial modification(toggle isCompleted)use PATCH. 
#[Route('/task/{taskId}/toggle',name:'toggle_task',methods:['PATCH'])]
public function toggleTask(string $taskId):JsonResponse{
 
      //Check if task Id is missing or empty  
        if (empty($taskId)) {
             return new JsonResponse(['error' => 'Task ID is required'], 400);
        }
    try{
        
            //Call the case for toggling 
            $this->toggleTaskHandler->handle($taskId);
            return new JsonResponse([
                'message'=>'Task has been toggled'],200
            );
          
        }catch(\RuntimeException $e){
            //Error trying to delete the task. Cannot find task ...
            return new JsonResponse([
                'error'=> $e->getMessage()],404);
        }
        catch (\Exception $e) {
            //System error, connection, server, etc....
        return new JsonResponse([
            'error' => 'An unexpected error occurred.'], 500);
    }

}

//Edit Task 
//Use PATCH since we are only changing the title and not replacing entire entity. 
#[Route('/task/{taskId}/edit',name:'edit_task',methods:['PATCH'])]
public function editTask(string $taskId, Request $request):JsonResponse{
    //Check if task Id is missing or empty  
        if (empty($taskId)) {
             return new JsonResponse(['error' => 'Task ID is required'], 400);
        }
      //Using json_decode we extract the data and $data is now the extracted data from the request. 
      //Decode in order to get the new title. 
        $data = json_decode($request->getContent(),true);

        //We need to check title was provided. 
        if (empty($data)){
            return new JsonResponse (['error'=>'Title is required'],400);
        }
 
    try{
        //Use the case for editing the title 
           $this->editTaskHandler->handle($taskId,$data['title']);
            return new JsonResponse([
                'message'=>'Task has been updated'],200
            );
          
        }catch(\RuntimeException $e){
            //Error trying to delete the task. Cannot find task ...
            return new JsonResponse([
                'error'=> $e->getMessage()],404);
        }
        catch (\Exception $e) {
            //System error, connection, server, etc....
        return new JsonResponse([
            'error' => 'An unexpected error occurred.'], 500);
    }



}





//Delete Task 
    //Create Route for Deleting Task 
    #[Route('/task/{taskId}',name:'delete_task',methods:['DELETE'])]
    public function deleteTask(string $taskId):JsonResponse{
    
        //Check if task Id is missing or empty  
        if (empty($taskId)) {
             return new JsonResponse(['error' => 'Task ID is required'], 400);
        }

        try{
           //Use the case for deleting the task 
            $this->deleteTaskHandler->handle($taskId);
            return new JsonResponse([
                'message'=>'Task Deleted'],200
            );
          
        }catch(\RuntimeException $e){
            //Error trying to delete the task. Cannot find task ...
            return new JsonResponse([
                'error'=> $e->getMessage()],404);
        }
        catch (\Exception $e) {
            //System error, connection, server, etc....
        return new JsonResponse([
            'error' => 'An unexpected error occurred.'], 500);
    }
    }

}

