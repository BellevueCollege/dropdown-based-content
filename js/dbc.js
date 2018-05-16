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
	selectionValue: function (selecteds) {
		return selecteds.map( function(s) {
			return s.innerText.trim();
		}).join(' - ')
	},
	optionValue: 'underline', // wrap the matched portion of the option (if applicable) in a span with class "underline"
	announcement: {
		count: function(n) {
			return n + ' options available'
		},
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
		//document.getElementById(combobo.config.listTriggerID).focus();
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

		element.querySelector('span').classList.replace(
			combobo.config.listTriggerClosedClass,
			combobo.config.listTriggerOpenClass
		);

		element.classList.toggle(combobo.config.activeClass, true);

	})
	.on('list:close', function () {
		var element = document.getElementById( combobo.config.listTriggerID );

		element.querySelector('span').classList.replace(
			combobo.config.listTriggerOpenClass,
			combobo.config.listTriggerClosedClass
		);
		
		element.classList.toggle( combobo.config.activeClass );
		
	})
	.on('selection', function ( e ) {
		var targetID = e.option.getAttribute('data-target') ? e.option.getAttribute('data-target') : 'dbc-content-default';
		var submitButton = document.getElementById('dbc-combobox-action');
		submitButton.setAttribute('data-target', targetID);
		submitButton.removeAttribute('disabled');
	})
	.on('deselection', function () {
		var submitButton = document.getElementById('dbc-combobox-action');
		submitButton.removeAttribute('data-target');
		submitButton.setAttribute('disabled', 'disabled');
	});



/**
 * Set list width
 */
function setListWidth() {
	var listWidth = document.querySelector(combobo.config.input).offsetWidth;
	var triggerWidth = document.getElementById(combobo.config.listTriggerID).offsetWidth;
	document.querySelector('.listbox').style.width = ( listWidth + triggerWidth - 8 ) + 'px';
}
window.addEventListener('resize', setListWidth);
setListWidth();

/**
 * Display content associated with option
 */
document.getElementById('dbc-combobox-action').addEventListener("click", function (e) {
	var previouslyOpen = document.querySelector('.dbc-content.open');

	if ( previouslyOpen ) {
		previouslyOpen.classList.remove('open');
	}

	var targetID = document.getElementById('dbc-combobox-action').getAttribute('data-target');
	var element = document.getElementById(targetID);
	
	if ( element ) {
		element.classList.add('open');
	}
	
});