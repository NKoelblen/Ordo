document.addEventListener('DOMContentLoaded', function () {
	const dropdowns = document.querySelectorAll('.dropdown');
	dropdowns.forEach((dropdown) => {
		const toggle = dropdown.querySelector('.dropdown-toggle');
		const menu = dropdown.querySelector('.dropdown-menu');

		function updateDropdownPosition() {
			const rect = toggle.getBoundingClientRect();
			const scrollTop = document.documentElement.scrollTop;
			const scrollLeft = document.documentElement.scrollLeft;
			menu.style.top = `${rect.bottom + scrollTop}px`;
			menu.style.left = `${rect.left + scrollLeft}px`;

			const menuRect = menu.getBoundingClientRect();
			if (menuRect.right > window.innerWidth) {
				menu.style.left = `${window.innerWidth - menuRect.width - 10}px`; // Adjust to the left
			}
			if (menuRect.bottom > window.innerHeight) {
				menu.style.top = `${rect.top + scrollTop - menuRect.height}px`; // Adjust to the top
			}
		}

		toggle.addEventListener('click', updateDropdownPosition);

		window.addEventListener('resize', updateDropdownPosition());

		window.addEventListener('scroll', updateDropdownPosition());

		const scrollableAncestors = [];
		let parent = dropdown.parentNode;
		while (parent && parent !== document) {
			if (parent.scrollHeight > parent.clientHeight || parent.scrollWidth > parent.clientWidth) {
				scrollableAncestors.push(parent);
			}
			parent = parent.parentNode;
		}

		scrollableAncestors.forEach((ancestor) => {
			ancestor.addEventListener('scroll', updateDropdownPosition);
		});
	});
});
