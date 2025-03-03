import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
	static targets = ['text', 'form', 'input'];

	connect() {
		document.addEventListener('click', this.handleClickOutside.bind(this));
		document.addEventListener('keydown', this.handleKey.bind(this));
	}

	disconnect() {
		document.removeEventListener('click', this.handleClickOutside.bind(this));
		document.removeEventListener('keydown', this.handleKey.bind(this));
	}

	edit() {
		this.inputTarget.value = this.inputTarget.dataset.initialValue;
		this.textTarget.classList.add('d-none');
		this.formTarget.classList.remove('d-none');
		this.inputTarget.focus();
		this.inputTarget.select();
	}

	submitOnEnter(event) {
		if (event.key === 'Enter') {
			this.formTarget.submit();
		}
	}

	handleClickOutside(event) {
		if (!this.element.contains(event.target)) {
			this.resetForm();
		}
	}

	handleKey(event) {
		if (event.key === 'Escape' || event.key === 'Tab') {
			this.resetForm();
		}
	}

	resetForm() {
		this.textTarget.classList.remove('d-none');
		this.formTarget.classList.add('d-none');
		this.inputTarget.value = this.inputTarget.dataset.initialValue;
	}
}
