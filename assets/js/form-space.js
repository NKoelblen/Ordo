document.addEventListener('DOMContentLoaded', () => {
	const openModalSpaceButtons = document.querySelectorAll('.open-modal-space');
	openModalSpaceButtons.forEach((button) => {
		button.onclick = () => {
			const mode = button.dataset.mode;
			const id = button.dataset.id;
			openForm(mode, id);
		};
	});

	function openForm(mode, id = null) {
		const formSpace = document.querySelector('#form-space');
		const modalTitle = document.querySelector('#modal-space .modal-title');
		const spaceProfessionalField = document.querySelector('#space_professional');
		const spaceParentField = formSpace.querySelector('#space_parent');

		const modalTitleContent = 'Space';
		if (mode === 'edit') {
			modalTitle.textContent = 'Edit ' + modalTitleContent;
			formSpace.action = formSpace.dataset.editAction.replace('PLACEHOLDER', id);
			spaceProfessionalField.disabled = false;

			fetch(`/api/space/${id}`)
				.then((response) => response.json())
				.then((data) => {
					formSpace.querySelector('#space_name').value = data.name;
					spaceParentField.value = data.parent;
					if (data.parent) {
						updateProfessionalField(data.parent);
					} else {
						spaceProfessionalField.checked = data.professional;
					}
				});
		} else if (mode === 'new') {
			formSpace.action = formSpace.dataset.newAction;
			formSpace.reset();
			spaceProfessionalField.disabled = false;

			if (!id) {
				modalTitle.textContent = 'New ' + modalTitleContent;
			} else {
				modalTitle.textContent = 'New Child ' + modalTitleContent;
				spaceParentField.value = id;
				updateProfessionalField(id);
			}
		}

		spaceParentField.addEventListener('change', function () {
			updateProfessionalField(this.value);
		});

		formSpace.addEventListener('submit', function (event) {
			event.preventDefault();
			spaceProfessionalField.disabled = false;
			formSpace.submit();
		});

		function updateProfessionalField(spaceParentId) {
			if (spaceParentId) {
				fetch(`/api/space/${spaceParentId}`)
					.then((response) => response.json())
					.then((data) => {
						if (data && data.professional !== undefined) {
							spaceProfessionalField.checked = data.professional;
							spaceProfessionalField.disabled = true;
						}
					});
			} else {
				spaceProfessionalField.checked = false;
				spaceProfessionalField.disabled = false;
			}
		}
	}
});
