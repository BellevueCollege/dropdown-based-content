<?php

defined( 'ABSPATH' ) || exit; ?>

<div class="input-group input-group-lg">
	<div class="combo-wrap">
		<input type="text" class="combobox form-control" id="dbc-combobox" placeholder="<?php echo $placeholder; ?>">
		<div class="listbox" aria-labelledby="dbc-combobox">
			<?php echo do_shortcode( $content ); ?>
		</div>
	</div>
	<span class="input-group-btn">';
		<button type="button" class="btn btn-default trigger" aria-hidden="true" id="dbc-combobox-trigger" tabindex="-1">
			<span class="glyphicon glyphicon-menu-down" data-trigger="dbc-combobox"></span>
		</button>
		<button type="button" class="btn btn-success disabled" id="dbc-combobox-action"><?php echo $button; ?></button>
	</span>
</div>
