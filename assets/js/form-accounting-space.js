document.addEventListener('turbo:load', function () {
	const formSpaceAccounting = document.querySelectorAll('.form-space-accounting');

	formSpaceAccounting.forEach((form) => {
		const spaceAccountingCheckbox = form.querySelector('.space-accounting');

		spaceAccountingCheckbox.onchange = () => {
			form.submit();
		};
	});
});
