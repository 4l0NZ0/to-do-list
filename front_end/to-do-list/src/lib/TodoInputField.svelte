<script>
    import Button from "./Button.svelte";
    //svelt 5 need to use $props instead of export let 
    //task is the task value from the input field. We bind it so when user types error message goes away. 
    // onAdd hold the function, if no function provided default to empty function. 
    //Get the props from parent 

    let {task = $bindable(""),onAdd = () =>{}} = $props();
    
    
    let placeholder ="Add Task .....";

     /* 
    addTask() is called when the user presses the Add task button. 
    Checks if the value of task is empty. If it is not empty then send it to the parent and then clear the value. 
    Else if the value is empty you do not need to clear it but send the empty value to the parent. 
    Empty value is sent in order for the parent to then let the user know " Field is empty you cannot add a task"
    This should be handled by the parent. Input should only handle the value. 

     */

    function addTask(){
        //If task is not empty, send it to the parents and clear the value. 
        if (task != ""){
        onAdd(task);
        task="";
        }
        //else if empty still send it. Parent should handle case if empty. 
        else{
            onAdd(task);
        }
    }
</script>



<div> 
<input 
    type = "text" 
    bind:value={task} 
    placeholder={placeholder}
    style="color:red"
    class = "mt-4"
    />
    <Button  on:click={addTask} text="Add Task"/>
  

</div>