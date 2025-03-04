document.addEventListener('turbo:load', function () {
	const showArchivedSpacesButton = document.querySelector('#show-archived-spaces');
	const archivedSpaces = document.querySelectorAll('.archived-space');

	const showArchived = localStorage.getItem('showArchivedSpaces') === 'true';

	if (showArchived) {
		archivedSpaces.forEach((space) => space.classList.remove('d-none'));
		showArchivedSpacesButton.querySelector('span').textContent = 'Hidde Archived Spaces';
	}

	showArchivedSpacesButton.addEventListener('click', () => {
		const status = localStorage.getItem('showArchivedSpaces') === 'true';

		if (status) {
			archivedSpaces.forEach((space) => space.classList.add('d-none'));
			localStorage.setItem('showArchivedSpaces', 'false');
			showArchivedSpacesButton.querySelector('span').textContent = 'Show Archived Spaces';
		} else {
			archivedSpaces.forEach((space) => space.classList.remove('d-none'));
			localStorage.setItem('showArchivedSpaces', 'true');
			showArchivedSpacesButton.querySelector('span').textContent = 'Hidde Archived Spaces';
		}
	});
});
