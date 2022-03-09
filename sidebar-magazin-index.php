<div id="sidebar1" class="sidebar sidebar-archive" role="complementary">
    <h2>Themen</h2>
    <p>Achtung: wir müssen hier noch die Magazin-Struktur besprechen, Stichwort Custom Permalinks</p>
	<?php if (is_active_sidebar('sidebar1')) : ?>
		<?php dynamic_sidebar( 'sidebar1' ); ?>
	<?php else : ?>
		<div class="alert alert-info">
			<p><?php _e('Sidebar Placeholder', 'bonestheme'); ?></p>
		</div>
	<?php endif; ?>
</div>