document.addEventListener('turbo:load', function () {
	const dropdowns = document.querySelectorAll('.dropdown');
	dropdowns.forEach((dropdown) => {
		const toggle = dropdown.querySelector('.dropdown-toggle');
		const menu = dropdown.querySelector('.dropdown-menu');

		function updateDropdownPosition() {
			const rect = toggle.getBoundingClientRect();
			const scrollTop = document.documentElement.scrollTop;
			const scrollLeft = document.documentElement.scrollLeft;
			menu.style.top = `${rect.top + scrollTop - 4}px`;
			menu.style.left = `${rect.right + scrollLeft + 2}px`;

			const menuRect = menu.getBoundingClientRect();
			if (menuRect.right > window.innerWidth) {
				menu.style.left = `${window.innerWidth - menuRect.width - 10}px`;
			}
			if (menuRect.bottom > window.innerHeight) {
				menu.style.top = `${rect.top + scrollTop - menuRect.height}px`;
			}
		}

		toggle.addEventListener('click', updateDropdownPosition);

		window.addEventListener('resize', updateDropdownPosition);

		window.addEventListener('scroll', updateDropdownPosition);

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
