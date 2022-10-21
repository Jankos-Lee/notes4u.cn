<?php
/**
 * Theme Footer
 *
 * @package Kent
 */

	get_sidebar();
?>
		<footer role="contentinfo" id="footer">
<?php
	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link( '', '<span class="sep"> | </span>' );
	}
?>
			<a href="http://notes4u.cn/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'kent' ); ?>" rel="generator"><?php printf( __( '', 'kent' ), '' ); ?></a>
			<span class="sep"> </span>
			<?php printf( __( 'Author: %1$s  %2$s.', 'kent' ), 'Jankos', '蜀ICP备2022012165号' ); ?>
		</footer>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
