<script>
import Button from "./Button.svelte";
// showErrorMessage is bindable prop. Shared with the parent component. 
//Allow parent to control the error message. Close or show. 
let {showErrorMessage = $bindable(false)} = $props();


</script>

<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
  <strong class="font-bold">Input Field Empty!</strong>
  <span class="block sm:inline">Please type somthing in the input field to add a task. </span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
  </span>
    <Button on:click={()=> (showErrorMessage = false)} text="Close"/>


</div>