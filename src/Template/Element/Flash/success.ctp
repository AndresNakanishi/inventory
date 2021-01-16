<script type="text/javascript">
	$.notify({
		icon:"fas fa-check-circle",
		message: "<?= $message ?>"
	},{
		allow_dismiss: true,
		type: 'info',
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