import { Controller } from '@hotwired/stimulus';
import Sortable from 'sortablejs';
import axios from 'axios';

export default class extends Controller {
	static targets = ['list'];

	connect() {
		this.initSortable();
	}

	initSortable() {
		// Sélectionne tous les éléments imbriqués avec la classe correspondante
		const nestedSortables = this.element.querySelectorAll('.sortable-list');

		nestedSortables.forEach((list) => {
			new Sortable(list, {
				group: 'nested',
				animation: 150,
				fallbackOnBody: true,
				swapThreshold: 0.65,
				onEnd: this.updateOrder.bind(this),
			});
		});
	}

	updateOrder(event) {
		const item = event.item;
		const parent = item.parentElement.closest('.sortable-item');
		const newParentId = parent ? parent.dataset.id : null;
		const itemId = item.dataset.id;

		console.log('Updating order:', { parent: parent, id: itemId, parentId: newParentId });

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
