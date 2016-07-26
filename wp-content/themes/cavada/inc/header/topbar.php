<div class="topbar-header">
	<div class="container">
		<div class="row">
			<?php
			if ( is_active_sidebar( 'topbar_left' ) ) :
				echo '<div class="widget-topbar-left">';
					dynamic_sidebar( 'topbar_left' );
				echo '</div>';
			endif;
			if ( is_active_sidebar( 'topbar_right' ) ) :
				echo '<div class="widget-topbar-right">';
				dynamic_sidebar( 'topbar_right' );
				echo '</div>';
			endif;
			?>
		</div>
	</div>
</div>