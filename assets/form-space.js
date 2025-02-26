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
		const spaceIdField = formSpace.querySelector('#space_id');
		const spaceParentField = formSpace.querySelector('#space_parent');

		const modalTitleContent = 'Space';
		if (mode === 'edit') {
			modalTitle.textContent = 'Edit ' + modalTitleContent;
			formSpace.action = formSpace.dataset.editAction.replace('PLACEHOLDER', id);
			spaceIdField.value = id;

			fetch(`/api/space/${id}`)
				.then((response) => response.json())
				.then((data) => {
					console.log(data);
					formSpace.querySelector('#space_name').value = data.name;
					spaceParentField.value = data.parent;
				});
		} else if (mode === 'new') {
			formSpace.action = formSpace.dataset.newAction;
			formSpace.reset();

			if (!id) {
				modalTitle.textContent = 'New ' + modalTitleContent;
			} else {
				modalTitle.textContent = 'New Child' + modalTitleContent;
				spaceParentField.value = id;
			}
		}
	}
});
