<script>
    import Button from "./Button.svelte";
    //svelt 5 need to use $props instead of export let 
    //task is the task value from the input field. 
    // onAdd hold the function, if no function provided default to empty function. 
    //Get the props from parent 

    let {task = $bindable(),onUpdate = () =>{},showError = () =>{}} = $props();
    // svelte-ignore non_reactive_update
        let newTitle = ""
    
    let placeholder ="Edit Task title .....";

     /* 
    addTask() is called when the user presses the Add task button. 
    Checks if the value of task is empty. If it is not empty then send it to the parent and then clear the value. 
    Else if the value is empty you do not need to clear it but send the empty value to the parent. 
    Empty value is sent in order for the parent to then let the user know " Field is empty you cannot add a task"
    This should be handled by the parent. Input should only handle the value. 

     */

    function editTaskTitle(){
        if (newTitle.trim() === ""){
            console.log("Need to put title")
            //Need to call error 
            showError();

        }
        else{
        onUpdate(newTitle);

        }

    }
</script>



<div> 
<input 
    type = "text" 
    bind:value={newTitle} 
    placeholder={placeholder}
    style="color:red"
    class = "mt-4"
    />
    <div class = "mt-4">
    <Button  on:click={editTaskTitle} text="Update Task Title"/>

    </div>

</div>