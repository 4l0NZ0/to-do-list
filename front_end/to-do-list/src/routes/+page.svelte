<script>
    import Button from '$lib/Button.svelte';
    import TodoInputField from '$lib/TodoInputField.svelte';
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    import TaskCard from '$lib/TaskCard.svelte';
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


<main class="min-h-screen bg-white  p-6 font-mono ">
 
    <div class =" flex flex-col items-center" >
        <div class= " rounded shadow-lg p-6 max-w-fit self-center">

            <h1 class="text-3xl font-bold mb-4 ">To Do List</h1>
        <div>
            {#if showErrorMessage}
            <ErrorMessage bind:showErrorMessage = {showErrorMessage}/>
            {/if}
            <TodoInputField  bind:task={newTask} onAdd = {addTask} />
        <div class="self-center w-auto">
            <TaskCard/>
        </div>

        </div>
        </div>

    </div>
</main>