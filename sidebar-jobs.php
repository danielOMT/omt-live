<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary" >	
	<?php if (is_active_sidebar('jobs')) : ?>

		<?php if(false):?>
		<div class="job_filter_box">
			<form id="jobs_filter_form">
				<h5 class="filter_title"><?php _e('Kategorien', 'jobs'); ?></h5>
				<?php displayCategoryFilter();?>

					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Erfahrung', 'jobs'); ?></h5>
					<?php  displayErfahrungFilter(); ?>

					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Ort', 'jobs'); ?></h5>
					<div id="stadt_div">
						<?=getCitiesForFilter();?>
					</div>

					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Art der Beschäftigung', 'jobs'); ?></h5>
					<?php  displayOccupationsFilter(); ?>

			</form>
		</div>
	<?php endif;?>


		<?php dynamic_sidebar( 'jobs' ); ?>
	<?php else : ?>
		<div class="alert alert-info">
			<p><?php _e('Sidebar Placeholder', 'bonestheme'); ?></p>
		</div>
	<?php endif; ?>
</div>