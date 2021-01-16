<script type="text/javascript">
	$.notify({
		icon:"fas fa-exclamation-circle",
		message: "<?= $message ?>"
	},{
		allow_dismiss: true,
		type: 'danger',
		animate: {
			enter: 'animated fadeInDown',
			exit: 'animated fadeOutUp'
		},
		placement: {
			from: 'top',
			align: 'center'
		}
	});
</script>