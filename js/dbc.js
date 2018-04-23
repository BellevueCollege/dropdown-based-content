var combobo = new Combobo({
	input: '#combobox-single-with-groups',
	list: '.listbox',
	options: '.option', // qualified within `list`
	groups: null, // qualified within `list`
	openClass: 'open',
	activeClass: 'active',
	selectedClass: 'selected',
	useLiveRegion: true,
	multiselect: false,
	noResultsText: null,
	selectionValue: (selecteds) => selecteds.map((s) => s.innerText.trim()).join(' - '),
	optionValue: 'underline', // wrap the matched portion of the option (if applicable) in a span with class "underline"
	announcement: {
		count: (n) => `${n} options available`,
		selected: 'Selected.'
	},
	filter: 'contains' // 'starts-with', 'equals', or funk
});



document.getElementById( 'open-combobox' ).addEventListener( "click", function ( e ) {
	e.stopPropagation();

	if ( combobo.isOpen ) {
		combobo.closeList();
	} else {
		combobo.openList();
	}
});

combobo
	.on('list:open', function () {
		var element = document.getElementById('open-combobox');
		element.firstChild.classList.remove('glyphicon-menu-down');
		element.firstChild.classList.add('glyphicon-menu-up');

		element.classList.add('active');
	})
	.on('list:close', function () {
		var element = document.getElementById('open-combobox');
		element.firstChild.classList.remove('glyphicon-menu-up');
		element.firstChild.classList.add('glyphicon-menu-down');
		
		element.classList.remove('active');
		
	});
