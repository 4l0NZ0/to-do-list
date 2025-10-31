<script>
    import Button from "./Button.svelte";
    //svelt 5 need to use $props instead of export let 
    //task is the task object we are going to edit. 
    //onUpdate is our function used to call the handleEditTask in order to edit the task. 
    //Show Error used to call function to an error window within the modal.
    let {task = $bindable(),onUpdate = () =>{},showError = () =>{}} = $props();


    // svelte-ignore non_reactive_update
    let newTitle = "" //Will hold the value from the input field. 

    //Place holder for our input 
    let placeholder ="Edit Task title .....";

    function editTaskTitle(){
        if (newTitle.trim() === ""){
            console.log("Need to put title")
            //Need to call error 
            showError();

        }
        else{
        //functon used to call the handleEditTask and passes the new title of the task to update it in the backed. 
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