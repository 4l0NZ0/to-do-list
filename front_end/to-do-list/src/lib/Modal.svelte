<script>
	let { showModal = $bindable(),showErrorMessageForModal= $bindable(), header,children } = $props();

	let dialog = $state(); // HTMLDialogElement

	$effect(() => {
		if (showModal) dialog.showModal();
	});

	function handleError(){
		showModal = false;
		showErrorMessageForModal = false;
	}
</script>

<!-- svelte-ignore a11y_click_events_have_key_events, a11y_no_noninteractive_element_interactions -->
<dialog
	bind:this={dialog}
	onclose={handleError}

	onclick={(e) => { if (e.target === dialog) dialog.close(); }}
	class="fixed inset-0 m-auto w-96 p-6 rounded-lg bg-white shadow-lg flex flex-col items-center justify-center"
>
<!-- svelte-ignore a11y_consider_explicit_label -->
<button  class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" autofocus onclick={() => dialog.close()}><i class="fa-solid fa-circle-xmark" style='font-size:24px'></i></button>

<div class="w-full">
			{@render header?.()}
		<hr />
		{@render children?.()}
		<hr />
		
		<!-- svelte-ignore a11y_autofocus -->
		
	</div>
</dialog>

