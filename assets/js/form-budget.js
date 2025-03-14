document.addEventListener('turbo:load', function () {
	const openModalBudgetButtons = document.querySelectorAll('.open-modal-budget');
	openModalBudgetButtons.forEach((button) => {
		button.onclick = () => {
			const mode = button.dataset.mode;
			const id = button.dataset.id;
			openForm(mode, id);
		};
	});

	function openForm(mode, id = null) {
		const formBudget = document.querySelector('#form-budget');
		const modalTitle = document.querySelector('#modal-budget .modal-title');
		const budgetSpacesFields = formBudget.querySelectorAll('#budget_spaces .form-check-input');

		const modalTitleContent = 'Budget';
		if (mode === 'edit') {
			modalTitle.textContent = 'Edit ' + modalTitleContent;
			formBudget.action = formBudget.dataset.editAction.replace('PLACEHOLDER', id);

			fetch(`/api/budget/${id}`)
				.then((response) => response.json())
				.then((data) => {
					formBudget.querySelector('#budget_amount').value = data.amount;
					formBudget.querySelector('#budget_period').value = data.period;
					formBudget.querySelector('#budget_category').value = data.category;
					formBudget.querySelector('#budget_groupMember').value = data.groupMember;
					budgetSpacesFields.forEach((option) => {
						if (data.spaces.includes(parseInt(option.value))) {
							option.checked = true;
						}
					});
				});
		} else if (mode === 'new') {
			formBudget.action = formBudget.dataset.newAction;
			formBudget.reset();

			modalTitle.textContent = 'New ' + modalTitleContent;
			budgetSpacesFields.forEach((option) => {
				if (option.value == id) {
					option.checked = true;
				}
			});
		}
	}
});
