<script>
    import {createTask,loadTasks,deleteTask, isCompleted, editTask} from "$lib/api";
    import TodoInputField from '$lib/TodoInputField.svelte';
    import EditTaskField from "$lib/EditTaskField.svelte";
    import ErrorMessage from '$lib/ErrorMessage.svelte';
    import SuccessMessage from "$lib/SuccessMessage.svelte";
    import TaskCard from '$lib/TaskCard.svelte';
    import {onMount} from 'svelte';
    import Modal from "$lib/Modal.svelte";
    /*
    newTask holds value entered in the TodoInputField component. 
    
    */
   //Error Message for adding a Task 
   let showErrorMessage = false;

   //Error message for no input in the edit modal. 
   let showErrorMessageForModal = false;

   //Show the Success message if a task is succesfully added. 
   let showSuccessMessage = false; 

   //Show the edit modal
   let showModal = false; 

   // feature: listen to new task. If string not empty i.e user is typing then error message disapears. 
   let newTask = ""; 
   //If no task is added this message is shown in the Error message. 
   let responseMessage = "";

  //need an array to hold our tasks 
   /**
   * @type {any[]}
   */
  //tasks hold the array from task for the loading. 
   let tasks = [];


  /**
   * @type {null}
   */

   //Our task "object"
   //Used for editing. When a user click on the edit button the task is sent and taskEdit is now equal to the task. 
    let taskToEdit = null;

    //Used to show the error message for the modal.
   function showeModalError(){
    showErrorMessageForModal = true; 
   }

  // Call when component is first ran. 
    onMount(async()=>{
        try {
            //Call function that loads tasks from the backend. 
            const data = await loadTasks();
            //Store the loaded tasks into the tasks array. 
            tasks = data;

        }catch(error){
            //Log error if error occurs.
            console.log('Error loading taks:', error);

        }
    });


 

    /**
     * @param {any} task
     */

     
     //Gets called when the Add button is clicked. Make call to backend using the createTask(task);
    async function addTask(task){
        //check if task is not empty
        //If is empty then we need to let the user know they did not put anything into the input field. 
        if (task.length == 0){
            showErrorMessage = true;
            responseMessage = 'You need to add a task. The field is empty. '
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
   * 
   */
  // Function for halding the deletion of a task. 
  //When the delete button is clicked on a task this gets called. We pass a task.id. 
  //Then we pass that id to our backend to know which task we want to delete. 
    async function handledeleteTask(taskId){
        if (taskId.length == 0){
            //Need to show error message 
            console.log("No id")
            
        }
        else{
           // call the delete api 
           await deleteTask(taskId);
           // We update the array,tasks, to show the newly updated tasks. 
            tasks = tasks.filter(task=> task.id !== taskId); 
    }

    }

  /**
   * @param {string | any[]} taskId
   */

   // Function for marking a task as completed. 
        async function handleisCompleted(taskId){
    //If the taskId is empty we have no id. 
    if (taskId.length == 0){
        //Handle Error
            console.log("No id")
            
        }
            else{
            //console.log(taskId);
            //We pass the is to the isCompleted located in our api.js file. 
           await isCompleted(taskId);
             
    }
    }



      /**
   * @param {null} task
   */

   //Function used to show the Modal for when user clicks the edit button. 
      function showEditModal(task){
        //If the user clicked the edit button we pass the entire task. We know this is the task they want to edit. We set the task now to taskToEdit. 
        taskToEdit = task;
        //We set the modal for editig to true because the edit button was clicked. 
        showModal = true; 


    
   }


     /**
   * @param {string | any[]} newTitle
   */

   // Function used to edit the task 
    async function handleEditTask(newTitle){
    //Check that we have a task to edit. Get it from the edit button. 
    //If we do not have a task we return. 
    if(!taskToEdit)return;

    // Since the button to update the title was clicked we also want to close the error message, If is was shown. 
    showErrorMessageForModal = false; 

    // If we do have a task 
    try{
        // @ts-ignore
    // upDatedTitle is now a new task. Contains, id, title, dateCreated, isCompleted. 
    const upDatedTitle =  await editTask(taskToEdit.id, newTitle);

    // Go into our task array. For each task we want to check the id matched the edited tasks id. 
    //If it matched then we return a new object {..t} and override the title of the matched id. If we do not find anything then we returb task t as is. 
    tasks = tasks.map((t)=>
        // @ts-ignore
        t.id === taskToEdit.id ? {...t, title:upDatedTitle.title } :t);

    
    // @ts-ignore
    //console.log(upDatedTitle);
    
    // Want to set the editshowmodal back to false when the update Title button is clicked. 
    showModal = false; 

    }catch(error){
        console.error("Failed to edit task:",error);

    }
    }

///Reactive
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
    <Modal bind:showModal bind:showErrorMessageForModal>
	{#snippet header()}
		 <h1 class="text-3xl font-bold mb-4 ">Edit Task Title </h1>
	{/snippet}
<div class="flex justify-center">
    <div class = "w-full max-w-md px-6 mt-4">
         {#if showErrorMessageForModal}
            <ErrorMessage bind:showErrorMessage = {showErrorMessageForModal} message={responseMessage}/>
            {/if}
            <EditTaskField task = {taskToEdit} onUpdate = {handleEditTask} showError= {showeModalError} />

        </div>
</div>
	
</Modal>
    {/if}

</main>