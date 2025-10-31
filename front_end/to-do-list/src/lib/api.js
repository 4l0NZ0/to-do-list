// Add all our api calls to make everything much cleaner. Add task, Toggle Task, Edit Task, Delete Task


//The base url for making the backend calls.
const BASE_URL = "http://localhost:8000"

// function for adding a task 
/**
 * @param {string} title
 */
export async function createTask(title){
    
    const response = await fetch(`${BASE_URL}/task`,{
        method:'POST',
        headers:{"Content-type":"application/json"},
        body:JSON.stringify({title})
    });

    //If error 
    if (!response.ok){
        const err = await response.json().catch(()=>({}));
        console.log(err);
       // throw new Error(err.details || "Failed to add task. ")
        
    }
    // if okay 
    //NOTE TO SELF POTENTIAL BUG? 
    return await response.json();

}

export async function loadTasks(){
    
    const response = await fetch(`${BASE_URL}/tasks`,{
        method:'GET',
        headers:{"Content-type":"application/json"}
       
    });

    //If error 
    if (!response.ok){
        const err = await response.json().catch(()=>({}));
        console.log(err);
       // throw new Error(err.details || "Failed to add task. ")
        
    }
    // if okay 
    //NOTE TO SELF POTENTIAL BUG? 
    return await response.json();

}


/**
 * @param {any} taskId
 */
export async function deleteTask(taskId){

    try{
        const response = await fetch(`${BASE_URL}/task/${taskId}`,{
        method:'DELETE',
        headers:{"Content-type":"application/json"}
       
    });
       //If error 
    if (!response.ok){
        const err = await response.json().catch(()=>({}));
        console.log(err);
       // throw new Error(err.details || "Failed to add task. ")
    }

    }catch(err){
        console.log(err);
    }
    

}


/**
 * @param {any} taskId
 */
export async function isCompleted(taskId){

    try{
        const response = await fetch(`${BASE_URL}/task/${taskId}/toggle`,{
        method:'PATCH',
        headers:{"Content-type":"application/json"}
       
    });
       //If error 
    if (!response.ok){
        const err = await response.json().catch(()=>({}));
        console.log(err);
       // throw new Error(err.details || "Failed to add task. ")
    }

    }catch(err){
        console.log(err);
    }
    

}


/**
 * @param {any} taskId
 */
// @ts-ignore
export async function editTask(taskId, newTitle){

    try{
        const response = await fetch(`${BASE_URL}/task/${taskId}/edit`,{
        method:'PATCH',
        headers:{"Content-type":"application/json"},
        body:JSON.stringify({title:newTitle})
       
    });
       //If error 
    if (!response.ok){
        const err = await response.json().catch(()=>({}));
        console.log(err);
       // throw new Error(err.details || "Failed to add task. ")
    }

     return await response.json();

    }catch(err){
        console.log(err);
    }
   

}