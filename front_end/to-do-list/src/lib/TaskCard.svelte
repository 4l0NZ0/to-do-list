<script>
          import '@fortawesome/fontawesome-free/css/all.min.css';

    // Used to check if the check button on a card has been checked. 
    let {checked = $bindable(), task, deleteTask = () =>{},toggleTask = () =>{} } = $props();



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

  
    function handleDeleteTask(){
        deleteTask(task.id)
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
                            <button onclick={chekedButton}>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg> 
                        </button>
                         {:else}
                         <button onclick={chekedButton}>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-slate-500 hover:text-indigo-600 hover:cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
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
                    <button onclick={handleDeleteTask}>
                    <i class='fas fa-edit' style='font-size:24px'></i>
                      </button> 
                   
                    <!-- svelte-ignore a11y_consider_explicit_label -->
                    <button onclick={handleDeleteTask}>
                   <i class='fas fa-trash' style='font-size:24px'></i>
                      </button>            
                </div>
            </div>

            </div>




