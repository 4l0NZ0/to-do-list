<script>
    import Button from '$lib/Button.svelte';
    import TodoInputField from '$lib/TodoInputField.svelte';
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    /*
    newTask holds value entered in the TodoInputField component. 
    
    */
   let errorMessage = false;

   // feature: listen to new task. If string not empty i.e user is typing then error message disapears. 
   let newTask = ""; 

    /**
     * @param {any} task
     */
    function addTask(task){
        if (task != "")
        console.log(task)
        else{
            console.log("Show empty field need to write a task. ")
            errorMessage = true; 
        }
        
    }

  
</script>


<main class="min-h-screen bg-gray-900 text-gray-100 p-6 font-mono ">
 
<div class =" flex flex-col items-center" >
         <h1 class="text-3xl font-bold mb-4">To Do List</h1>
<div>
    {#if errorMessage}
      <ErrorMessage/>

    {/if}

  <TodoInputField  bind:task={newTask} onAdd = {addTask} />




</div>

</div>
</main>