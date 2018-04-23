/**
 * Instantiate combobo element
 */
var combobo = new Combobo({
	input: '#dbc-combobox',
	list: '.listbox',
	options: '.option', // qualified within `list`
	groups: null, // qualified within `list`
	openClass: 'open',
	activeClass: 'active',
	selectedClass: 'selected',
	useLiveRegion: true,
	multiselect: false,
	noResultsText: 'no results',
	selectionValue: (selecteds) => selecteds.map((s) => s.innerText.trim()).join(' - '),
	optionValue: 'underline', // wrap the matched portion of the option (if applicable) in a span with class "underline"
	announcement: {
		count: (n) => `${n} options available`,
		selected: 'Selected.'
	},
	filter: 'contains', // 'starts-with', 'equals', or funk

	// Add some custom configs - not part of combobo core
	listTriggerID: 'dbc-combobox-trigger',
	listTriggerOpenClass: 'glyphicon-menu-up',
	listTriggerClosedClass: 'glyphicon-menu-down'
});

/**
 * Open combobo list when trigger is clicked
 */
document.getElementById( combobo.config.listTriggerID ).addEventListener( "click", function ( e ) {
	e.stopPropagation();

	if ( combobo.isOpen ) {
		combobo.closeList();
	} else {
		combobo.openList();
	}
});


/**
 * Add classes to modify icon and active state when list transitions
 */
combobo
	.on('list:open', function () {
		var element = document.getElementById( combobo.config.listTriggerID );
		element.firstChild.classList.remove( combobo.config.listTriggerClosedClass );  //down
		element.firstChild.classList.add( combobo.config.listTriggerOpenClass );  //up

		element.classList.add(combobo.config.activeClass);
	})
	.on('list:close', function () {
		var element = document.getElementById( combobo.config.listTriggerID );
		element.firstChild.classList.remove( combobo.config.listTriggerOpenClass );  //up
		element.firstChild.classList.add( combobo.config.listTriggerClosedClass );  //down
		
		element.classList.remove( combobo.config.activeClass );
		
	});

/**
 * Set list width
 */
function setListWidth() {
	var listWidth = document.querySelector(combobo.config.input).offsetWidth;
	var triggerWidth = document.getElementById(combobo.config.listTriggerID).offsetWidth;
	document.querySelector('.listbox').style.width = ( listWidth + triggerWidth - 8 ) + 'px';
	console.log('width set');
}
window.addEventListener('resize', setListWidth);
setListWidth();
