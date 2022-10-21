<?php
/**
 * Generic search form template
 *
 * @package Kent
 */
?>
<form method="get" class="searchform animated" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<fieldset>
		<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" class="searchfield" placeholder="<?php echo esc_attr_x( '搜索...', 'search input placeholder text', 'kent' ); ?>" />
		<button class="searchsubmit">&#62464;</button>
	</fieldset>
</form>
