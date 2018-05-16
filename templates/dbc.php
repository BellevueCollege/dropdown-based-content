<?php

defined( 'ABSPATH' ) || exit; ?>
<div class="dbc panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><label for="dbc-combobox"><?php echo $label; ?></label></h2>
	</div>
	<div class="panel-body">
		<?php echo do_shortcode( $content ); ?>
	</div>
</div>