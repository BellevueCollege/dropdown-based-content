<?php

defined( 'ABSPATH' ) || exit; ?>
<div class="dbc panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</div>
	<div class="panel-body">
		<?php echo do_shortcode( $content ); ?>
	</div>
</div>