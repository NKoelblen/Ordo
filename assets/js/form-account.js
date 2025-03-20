document.addEventListener('turbo:load', function () {
	const openModalAccountButtons = document.querySelectorAll('.open-modal-account');
	openModalAccountButtons.forEach((button) => {
		button.onclick = () => {
			const mode = button.dataset.mode;
			const id = button.dataset.id;
			openForm(mode, id);
		};
	});

	function openForm(mode, id = null) {
		const formAccount = document.querySelector('#form-account');
		const modalTitle = document.querySelector('#modal-account .modal-title');
		const accountSpacesFields = formAccount.querySelectorAll('#account_spaces .form-check-input');

		const modalTitleContent = 'Account';
		if (mode === 'edit') {
			modalTitle.textContent = 'Edit ' + modalTitleContent;
			formAccount.action = formAccount.dataset.editAction.replace('PLACEHOLDER', id);

			fetch(`/api/account/${id}`)
				.then((response) => response.json())
				.then((data) => {
					formAccount.querySelector('#account_name').value = data.name;
					accountSpacesFields.forEach((option) => {
						if (data.spaces.includes(parseInt(option.value))) {
							option.checked = true;
						}
					});
				});
		} else if (mode === 'new') {
			formAccount.action = formAccount.dataset.newAction;
			formAccount.reset();

			modalTitle.textContent = 'New ' + modalTitleContent;
			accountSpacesFields.forEach((option) => {
				if (option.value == id) {
					option.checked = true;
				}
			});
		}
	}
});
