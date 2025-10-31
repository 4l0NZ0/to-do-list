<script>
          import '@fortawesome/fontawesome-free/css/all.min.css';

    // Used to check if the check button on a card has been checked. 
    let {checked = $bindable(), task, deleteTask = () =>{},toggleTask = () =>{},showModal = () =>{} } = $props();



    // Checks if the button has been clicked. If it has been clicked then it sets checked to false if it is true. Sets it to true if it is false. We do this because if a user clicks the button by accident and the task has not been completed, we want them to be able to reverse this. Or uncheck the task. 
    function chekedButton(){
        
        if (checked){
            toggleTask(task.id)
            checked = false;
        }
        else{
            toggleTask(task.id)
        checked = true;

        }
    }

   
    /**
   * @param {any} task
   */
    function handleShowModal(task){
        console.log("Child");
        showModal(task);
      
    }
  
    function handleDeleteTask(){
        deleteTask(task.id);
    }
    //when the check mark is clicked. We change the class to line through and the text color 
    // When the check is not clicked we have no change. 
</script>

<div >
             <div id="task" class="flex justify-between items-center border-b border-slate-200 py-3 px-2 border-l-4  border-l-transparent">
                <div class="inline-flex items-center space-x-2">
                    <div>
                        <!-- svelte-ignore a11y_consider_explicit_label -->
                         {#if task.isCompleted}
                            <button onclick={chekedButton}> <i class="fa-solid fa-circle-check" style='font-size:24px'></i>
                            
                        </button>
                         {:else}
                         <button onclick={chekedButton}>
                            <i class="fa-regular fa-circle-check" style='font-size:24px'></i>
                          
                                      </button>        

                         {/if}
                       
                                                
                    </div>
                    {#if task.isCompleted}
                    <div class = "flex flex-col ">
                         <div class="text-slate-500 line-through">{task.title}</div>
                        <div class="text-sm text-slate-500 line-through">Date created: {task.dateCreated} </div>
                        </div>
                              

                     {:else}
                      <div class = "flex flex-col ">
                        <div >{task.title}</div>
                        <div class = "text-sm text-grey-100 ">Date created: {task.dateCreated} </div>
                        </div>
                        {/if}
                 
                </div>

             

                <div>

                     {#if task.isCompleted}
                        <!-- svelte-ignore a11y_consider_explicit_label -->
                        <button onclick={()=>handleShowModal(task)}>
                         <i class='fas fa-edit ' style='font-size:24px'></i>
                      </button> 

                      {:else}
                       <!-- svelte-ignore a11y_consider_explicit_label -->
                        <button onclick={()=>handleShowModal(task)}>
                         <i class='fas fa-edit ' style='font-size:24px'></i>
                      </button> 
                     {/if}

                    <!-- svelte-ignore a11y_consider_explicit_label -->
                    
                   
                    <!-- svelte-ignore a11y_consider_explicit_label -->
                    <button onclick={handleDeleteTask}>
                   <i class='fas fa-trash' style='font-size:24px'></i>
                      </button>            
                </div>
            </div>

            </div>




