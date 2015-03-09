<div class="cc_admin">
	<form method="post" action="options.php">
		<?php
		$this->options = get_option( 'cc_options' );
		settings_fields( 'cc_options' );
		do_settings_sections( 'code_contest' );
		submit_button();
		?>
	</form>
</div>