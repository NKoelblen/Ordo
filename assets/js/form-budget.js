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
		const budgetSpaceField = formBudget.querySelector('#budget_space');

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
					budgetSpaceField.value = data.space;
					updateCategories(data.space);
				});
		} else if (mode === 'new') {
			formBudget.action = formBudget.dataset.newAction;
			formBudget.reset();

			modalTitle.textContent = 'New ' + modalTitleContent;
			budgetSpaceField.value = id;
			updateCategories(id);
		}
	}

	function updateCategories(spaceId) {
		const budgetCategoryField = document.querySelector('#budget_category');
		budgetCategoryField.innerHTML = "<option value=''>Select category</option>";

		if (!spaceId) return;

		fetch(`/api/categories/space/${spaceId}`)
			.then((response) => response.json())
			.then((categories) => {
				categories.forEach((cat) => {
					const option = document.createElement('option');
					option.value = cat.id;
					option.textContent = cat.name;
					budgetCategoryField.appendChild(option);
				});
			});
	}

	// Écouter les changements manuels sur #budget_space
	const budgetSpaceField = document.querySelector('#budget_space');
	if (budgetSpaceField) {
		budgetSpaceField.addEventListener('change', function () {
			updateCategories(this.value);
		});
	}
});
