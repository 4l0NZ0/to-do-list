<script>
    import {createTask,loadTasks,deleteTask} from "$lib/api";
    import Button from '$lib/Button.svelte';
    import TodoInputField from '$lib/TodoInputField.svelte';
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    import SuccessMessage from "$lib/SuccessMessage.svelte";
    import TaskCard from '$lib/TaskCard.svelte';
    import {onMount} from 'svelte';
 // import tailwindcss from "@tailwindcss/vite";
    /*
    newTask holds value entered in the TodoInputField component. 
    
    */
   let showErrorMessage = false;
   let showSuccessMessage = false; 

   // feature: listen to new task. If string not empty i.e user is typing then error message disapears. 
   let newTask = ""; 
   let responseMessage = "";


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
            <TaskCard bind:checked={task.isCompleted} task = {task} deleteTask = {handledeleteTask}/>

            {/each}
        </div>

        </div>
        </div>

    </div>
</main>