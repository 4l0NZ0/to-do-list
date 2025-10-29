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


//Psudo Code 
//Controller receives a task from the user(frontend). 

class TaskController extends AbstractController{

    // Declare constructor 
    private AddTaskHandler $addTaskHandler;


    //Dependecy Injection
    public function __construct(AddTaskHandler $addTaskHandler){
          $this->$addTaskHandler = $addTaskHandler;
     }

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
        $task = $this->addTaskHandler->handleDTO($taskDTO);

        // We now want to return the task as JSON (with id and dateCreated)
        

        //Dummy Data to check if POST request works
        return new JsonResponse([
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'dateCreated' => $task->getDateCreated()
        ]);


    }

    //Test for checking if route works
    // #[Route('/task',name:'task_index',methods:['GET'])]
    // public function index():Response{
    //     return new Response('Task route works from Presnation layer!');
    // }


}

