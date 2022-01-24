window.addEventListener('load', function() {
	// show section if anchor is in URL
	if(window.location.hash) {
		sv100_module_block_group_section_visibility(document.querySelector(window.location.hash));
	}else{
		sv100_module_block_group_section_visibility(document.querySelector(document.querySelector('a[href*="#section_"]:first-of-type').getAttribute('href')));
	}

	// find all section links
	[...document.querySelectorAll('a[href*="#section_"]')].forEach(section_link => {

		// show section if achor is clicked
		section_link.addEventListener('click', function() {
			sv100_module_block_group_section_visibility(document.querySelector(this.getAttribute('href')))
			history.replaceState(undefined, undefined, this.getAttribute('href'))
		});

		// allow styling links when section is in view
		window.addEventListener('scroll', function(event) {
			document.querySelectorAll(section_link.getAttribute('href')).forEach(element => {
				if (isInViewport(element)) {
					element.classList.add("section_in_view");
					section_link.classList.add("section_in_view");
				}else{
					element.classList.remove("section_in_view");
					section_link.classList.remove("section_in_view");
				}
			});
		}, false);
	});
});

function sv100_module_block_group_section_visibility(section){
	// hide all sections
	[...document.querySelectorAll('section.wp-block-group')].map(el => el.classList.remove('section_in_view')); // remove class from all section elements
	[...document.querySelectorAll('section.wp-block-group')].map(el => el.classList.remove('section_active')); // remove class from all section elements
	[...document.querySelectorAll('section.wp-block-group')].map(el => el.classList.add('section_not_active')); // add class to all section elements

	// show active section
	section.classList.remove('section_not_active'); // remove class from section selement
	section.classList.add('section_active'); // add class to section element
	section.classList.add('section_in_view'); // add class to section element
	document.querySelector('a[href*="'+section.id+'"]').classList.add('section_in_view'); // add class to navigation element


	window.dispatchEvent(new Event('resize')); // allow sliders etc. to recalculate/reinit
	window.dispatchEvent(new Event('scroll')); // allow sliders etc. to recalculate/reinit
}

let isInViewport = function(elem) {
	let distance = elem.getBoundingClientRect();

	return (
		elem.offsetHeight > 0 &&
		distance.top >= 0 &&
		distance.left >= 0 /*&&
		distance.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
		distance.right <= (window.innerWidth || document.documentElement.clientWidth)*/
	);
};

//let findMe = document.querySelectorAll('.thisisatest');