<script>
    // showModal comes from parent. Hold the true or false in order to show. 
    //
    let {showModal = $bindable(),... props} = $props();

    //set dialog to state. 
    let dialog = $state();
   
    

    // if showModal is true then make the dialog show. 
    // reference to dialog : https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dialog
    $effect(()=>{
        if (showModal) dialog.showModal();
    })


</script>
<!-- assign html element <dialog> to the dialog variable when the component is mounted.-->
 <!-- We want to make use that no matter how the window is closed that showModal is set to false. So onclose helps to sync everything together. If the modal is closed using the button or esc or x then showModal always set to false. -->
<dialog
	bind:this={dialog}
   
	onclose={() => (showModal = false)}
>
    <p>Hello world</p>
       	<button  onclick={() => dialog.close()}>close modal</button>
</dialog>
