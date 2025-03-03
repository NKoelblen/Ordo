import { Controller } from '@hotwired/stimulus';
import Sortable from 'sortablejs';
import axios from 'axios';

export default class extends Controller {
	static targets = ['list'];

	connect() {
		this.initSortable();
	}

	initSortable() {
		const nestedSortables = this.element.querySelectorAll('.sortable-list');

		nestedSortables.forEach((list) => {
			new Sortable(list, {
				group: {
					name: 'nested',
					pull: true,
					put: true,
				},
				handle: '.sortable-handle',
				animation: 150,
				fallbackOnBody: true,
				swapThreshold: 0.65,
				emptyInsertThreshold: 10,
				onMove: (event) => {
					let targetItem = event.related;

					if (targetItem.classList.contains('sortable-item')) {
						let targetList = targetItem.querySelector('.sortable-list');
						if (targetList.children.length === 0) {
							targetList.style.minHeight = '4rem';
							targetList.style.border = '1px dashed white';
							targetList.style.borderRadius = '0.25rem';
						}

						let targetCollapse = targetItem.querySelector('.collapse');
						targetCollapse.classList.add('show');

						let targetToggle = targetItem.querySelector('.btn-toggle');
						targetToggle.classList.remove('d-none');
						targetToggle.setAttribute('aria-expanded', 'true');
					}

					this.element.querySelectorAll('.collapse').forEach((collapse) => {
						let otherList = collapse.querySelector('.sortable-list');
						if (!targetItem.contains(collapse) && targetItem !== otherList && otherList.children.length === 0) {
							collapse.classList.remove('show');
						}
					});
					this.element.querySelectorAll('.btn-toggle').forEach((toggle) => {
						let otherList = toggle.closest('.sortable-item').querySelector('.sortable-list');
						if (!targetItem.contains(toggle) && targetItem !== otherList && otherList.children.length === 0) {
							toggle.classList.add('d-none');
							toggle.setAttribute('aria-expanded', 'false');
						}
					});
				},
				onEnd: (event) => {
					nestedSortables.forEach((list) => {
						list.style.minHeight = '';
						list.style.border = '';
						list.style.borderRadius = '';
					});
					this.element.querySelectorAll('.sortable-item:has(.sortable-item) > .nav-summary .btn-toggle').forEach((toggle) => {
						toggle.classList.remove('d-none');
						toggle.setAttribute('aria-expanded', 'true');
					});
					this.element.querySelectorAll('.sortable-item:not(:has(.sortable-item)) .btn-toggle').forEach((toggle) => {
						toggle.classList.add('d-none');
						toggle.setAttribute('aria-expanded', 'false');
					});
					this.element.querySelectorAll('.collapse:not(:has(.sortable-item))').forEach((collapse) => {
						collapse.classList.remove('show');
					});
					this.updateOrder(event);
				},
			});
		});
	}

	updateOrder(event) {
		console.log('test');
		const item = event.item;
		const parent = item.parentElement.closest('.sortable-item');
		const newParentId = parent ? parent.dataset.id : null;
		const itemId = item.dataset.id;

		axios
			.post('/api/space/hierarchy', {
				id: itemId,
				parentId: newParentId,
			})
			.then((response) => {
				console.log('Mise à jour réussie', response.data);
			})
			.catch((error) => {
				console.error('Erreur lors de la mise à jour', error);
			});
	}
}
