<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">
	<?php if (is_active_sidebar('standard')) : ?>
		<?php dynamic_sidebar( 'standard' ); ?>
	<?php else : ?>
		<div class="alert alert-info">
			<p><?php _e('Sidebar Placeholder', 'bonestheme'); ?></p>
		</div>
	<?php endif; ?>
</div>