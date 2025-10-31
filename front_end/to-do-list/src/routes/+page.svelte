<script>
    import {createTask,loadTasks,deleteTask, isCompleted, editTask} from "$lib/api";
    import Button from '$lib/Button.svelte';
    import TodoInputField from '$lib/TodoInputField.svelte';
    import EditTaskField from "$lib/EditTaskField.svelte";
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    import SuccessMessage from "$lib/SuccessMessage.svelte";
    import TaskCard from '$lib/TaskCard.svelte';
    import {onMount} from 'svelte';
  import Modal from "$lib/Modal.svelte";
  import { updated } from "$app/stores";
 // import tailwindcss from "@tailwindcss/vite";
    /*
    newTask holds value entered in the TodoInputField component. 
    
    */
   let showErrorMessage = false;
   let showSuccessMessage = false; 

   let showModal = false; 

   // feature: listen to new task. If string not empty i.e user is typing then error message disapears. 
   let newTask = ""; 
   let responseMessage = "";
  /**
   * @type {null}
   */

   //Our task "object"
    let taskToEdit = null;


   
  
  

    onMount(async()=>{
        try {
            const data = await loadTasks();
            tasks = data;
            console.log(tasks);


        }catch(error){
            console.log('Error loading taks:', error);

        }
    });


   

    


   //need an array to hold our tasks 
   /**
   * @type {any[]}
   */
   let tasks = [];

    /**
     * @param {any} task
     */

     
    async function addTask(task){
        if (task.length == 0){
            showErrorMessage = true;
            responseMessage = 'You need to add a task. '
        }
        else{
        try {
            // call backend to add task. Response is now = to data. 
            const data = await createTask(task);
            //Update the tasks array locally. 
            tasks = [data,...tasks]
            
            //Show success message 
            showSuccessMessage = true; 
            responseMessage = 'Task Added';
            //tasks = await fetchTasks();

        }catch(err){
            //Error handling if task fails to be added 
            responseMessage = "Failed to add task. "
            showErrorMessage = true; 
        }
    }
    }


       /**
   * @param {string | any[]} taskId
   */
       async function handledeleteTask(taskId){
        if (taskId.length == 0){
            console.log("No id")
            
        }
        else{
            console.log(taskId);
           await deleteTask(taskId);
            tasks = tasks.filter(task=> task.id !== taskId); 
    }

       }

  /**
   * @param {string | any[]} taskId
   */
async function handleisCompleted(taskId){
    if (taskId.length == 0){
            console.log("No id")
            
        }
            else{
            console.log(taskId);
           await isCompleted(taskId);
             
    }
}



      /**
   * @param {null} task
   */
      function showEditModal(task){
        taskToEdit = task;
        showModal = true; 
        console.log("Modal triggered for",taskToEdit);


    
   }


     /**
   * @param {string | any[]} newTitle
   */
async function handleEditTask(newTitle){
    //Check that we have a task to edit. Get it from the edit button. 
    //If we do not have a task we return. 
    if(!taskToEdit)return;

    // If we do have a task 
    try{
        // @ts-ignore
    const upDatedTitle =  await editTask(taskToEdit.id, newTitle);

    tasks = tasks.map((t)=>
        // @ts-ignore
        t.id === taskToEdit.id ? {...t, title:upDatedTitle.title } :t);

    
    // @ts-ignore
    //console.log(upDatedTitle);
    
    showModal = false; 
        
        //we now update the front end. 

    }catch(error){
        console.error("Failed to edit task:",error);

    }









}






// If newTask is changed, meaning it is not empty, close the error message. User can either use the close button or when they start to type into the input field. Better UX. 
  $: if (newTask.trim() != ""){
    showErrorMessage = false;
  }
</script>


<main class="min-h-screen bg-white  p-6 font-mono ">

    <div class =" flex flex-col items-center" >
  
        <div class= " rounded shadow-lg p-6 max-w-fit self-center">

            <h1 class="text-3xl font-bold mb-4 ">To Do List</h1>
        <div>
            
            {#if showErrorMessage}
            <ErrorMessage bind:showErrorMessage = {showErrorMessage} message={responseMessage}/>
            {:else if showSuccessMessage}
            <SuccessMessage bind:showSuccessMessage = {showSuccessMessage} message = {responseMessage}/>
            {/if}

            <TodoInputField  bind:task={newTask} onAdd = {addTask} />
        <div class="self-center w-auto">
            {#each tasks as task }
            <TaskCard 
                bind:checked={task.isCompleted} 
                task = {task} 
                deleteTask = {handledeleteTask} 
                toggleTask = {handleisCompleted} 
                showModal = {showEditModal}/>

            {/each}


            
        </div>

       
        </div>
        </div>

    </div>

    {#if showModal}
    <Modal bind:showModal>
	{#snippet header()}
		 <h1 class="text-3xl font-bold mb-4 ">Edit Task Title </h1>
	{/snippet}
<div class="flex justify-center">
    <div class = "w-full max-w-md px-6 mt-4">
            <EditTaskField task = {taskToEdit} onUpdate = {handleEditTask}/>

        </div>
</div>
	
</Modal>
{/if}

    
   
          

</main>