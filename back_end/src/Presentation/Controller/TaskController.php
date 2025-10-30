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




//Psudo Code 
//Controller receives a task from the user(frontend). 

class TaskController extends AbstractController{

    // Add Task  
    private AddTaskHandler $addTaskHandler;

    //Delete Task 
    private DeleteTaskHandler $deleteTaskHandler;

    private ToggleTaskHandler $toggleTaskHandler;



    //Dependecy Injection
    public function __construct(AddTaskHandler $addTaskHandler,DeleteTaskHandler $deleteTaskHandler,ToggleTaskHandler $toggleTaskHandler){
          $this->addTaskHandler = $addTaskHandler;
          $this->deleteTaskHandler = $deleteTaskHandler;
          $this->toggleTaskHandler = $toggleTaskHandler;
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

        //Call the use case 
        // In this case we want to save it to the DB 
        //Call handleDTO form our AddTaskHandler class to save the data. 

        try{
            $task = $this->addTaskHandler->handle($taskDTO);
            return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'dateCreated' => $task->getDateCreated(),
            ]);
        }catch(\RuntimeException $e){
            return new JsonResponse([
                'success'=> false,
                'message'=> $e->getMessage()
            ],500);
        }
    }

// Task is Complete 
// Since we only want partial modification(only to isCompleted)use PATCH. 
#[Route('/task/{taskId}/toggle',name:'completed_task',methods:['PATCH'])]
public function toggleTask(string $taskId):JsonResponse{
 
 
    try{
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






//Delete Task 
    //Create Route for Deleting Task 
    #[Route('/task/{taskId}',name:'delete_task',methods:['DELETE'])]
    public function deleteTask(string $taskId):JsonResponse{

       


        try{
           
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

