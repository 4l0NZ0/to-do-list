<script>
    import Button from '$lib/Button.svelte';
    import TodoInputField from '$lib/TodoInputField.svelte';
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    /*
    newTask holds value entered in the TodoInputField component. 
    
    */
   let showErrorMessage = false;

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
            showErrorMessage = true; 
        }
        
    }

// If newTask is changed, meaning it is not empty, close the error message. User can either use the close button or when they start to type into the input field. Better UX. 
  $: if (newTask.trim() != ""){
    showErrorMessage = false;
  }
</script>


<main class="min-h-screen bg-gray-900 text-gray-100 p-6 font-mono ">
 
<div class =" flex flex-col items-center" >
         <h1 class="text-3xl font-bold mb-4">To Do List</h1>
<div>
    {#if showErrorMessage}
    <ErrorMessage bind:showErrorMessage = {showErrorMessage}/>
    {/if}

  <TodoInputField  bind:task={newTask} onAdd = {addTask} />

</div>

</div>
</main>