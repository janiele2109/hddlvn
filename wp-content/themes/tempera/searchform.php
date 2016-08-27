<?php
/**
 * The searchform
 *
 * @package Tempera
 */
?> 

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" placeholder="<?php _e( 'Search', 'tempera' ); ?>" name="s" class="s" value="<?php echo get_search_query(); ?>" />
	<input type="submit" class="searchsubmit" value="&#xe816;" />
</form>