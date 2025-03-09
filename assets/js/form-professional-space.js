document.addEventListener('DOMContentLoaded', () => {
	const formSpaceProfessional = document.querySelectorAll('.form-space-professional');

	formSpaceProfessional.forEach((form) => {
		const spaceProfessionalCheckbox = form.querySelector('#professional_space_professional');

		spaceProfessionalCheckbox.onchange = () => {
			form.submit();
		};
	});
});
