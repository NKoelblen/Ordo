document.addEventListener('DOMContentLoaded', () => {
	const formSpaceStatus = document.querySelector('#form-space-status');
	const spaceStatusField = formSpaceStatus.querySelector('#status_space_status');

	const archiveSpaceButtons = document.querySelectorAll('.archive-space');
	archiveSpaceButtons.forEach((button) => {
		button.onclick = () => {
			updateSpaceStatus(button.dataset.id, 'archived');
		};
	});

	const restoreSpaceButtons = document.querySelectorAll('.restore-space');
	restoreSpaceButtons.forEach((button) => {
		button.onclick = () => {
			updateSpaceStatus(button.dataset.id, 'open');
		};
	});

	function updateSpaceStatus(id, status) {
		formSpaceStatus.action = formSpaceStatus.dataset.action.replace('PLACEHOLDER', id);
		spaceStatusField.value = status;
		formSpaceStatus.submit();
	}
});
