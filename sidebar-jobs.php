<?php 
	$count_cat = 0;
	$count_erf = 0;
	$count_der = 0;
	$hide_cat = 'hide_cat';
	$args = array(
       'taxonomy' => 'jobs-categories',
       'orderby' => 'name',
       'order'   => 'ASC'
    );
    $erfahrung = GFFormsModel::get_form_meta(24);
    $cats = get_categories($args);
    $choices = $erfahrung['fields'][9]['choices'];//get form data
    $occupations = $erfahrung['fields'][7]['choices']; //get form data
?>
<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary" >	
	<?php if (is_active_sidebar('jobs')) : ?>

		<?php if(is_page(315098)):?>
		<div class="job_filter_box">
			<form id="jobs_filter_form">
				<h5 class="filter_title"><?php _e('Kategorien', 'jobs'); ?></h5>
				<?php				    
				   	foreach($cats as $cat) : ?>
				   		<div >
						   	<input type="checkbox"  name="category" value="<?=$cat->name; ?>" id="<?=$cat->term_id;?>" class="omt-input jobs_filter cat_f <?php if($count_cat > 2){ echo $hide_cat; }?>" />
						   	<label class="cat_f <?php if($count_cat > 2){ echo $hide_cat; }?>" for="<?=$cat->term_id;?>"><?=$cat->name; ?> 
						   		<label id="showCat_<?=$cat->term_id;?>" class="post_count category_c <?=$cat->name?>">(<?=countByCategory($cat->name);?>)</label>
						    </label>
					   </div>
						<?php  $count_cat++;
					endforeach;?>
					<button class="show_categories" onclick="show_cat()"> <span>Mehr anzeigen</span> <i class="arrow_ down_"></i></button>
					<button style="display: none;" class="hide_categories" onclick="hide_cat()"> <span>Weniger anzeigen</span> <i class="arrow_ up_"></i></button>


					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Erfahrung', 'jobs'); ?></h5>
					<?php foreach ($choices as $choice) : ?>
						<input type="checkbox"  name="erfahrung" value="<?=$choice['value'];?>" class="omt-input jobs_filter" id="erf_<?=$count_erf;?>"/>
				   		<label class="cat_f" for="erf_<?=$count_erf;?>"><?=$choice['text'];?>
				   			<label id="showErf_<?=$count_erf;?>" class="post_count erfahrung_c <?=$choice['value'];?>">(<?=countJobByErfahrung($choice['value']);?>)</label>
				   		</label><br>
					<?php $count_erf++; endforeach;?>

					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Ort', 'jobs'); ?></h5>
					<div id="stadt_div">
						<?=getCitiesForFilter();?>
					</div>


					<div class="space_"></div>
					<h5 class="filter_title"><?php _e('Art der Beschäftigung', 'jobs'); ?></h5>
					<?php foreach ($occupations as $occupation) : ?>
						<input type="checkbox" name="occupation" value="<?=$occupation['value'];?>" class="omt-input jobs_filter" id="ccu_<?=$count_der;?>"/>
				   		<label class="cat_f" for="ccu_<?=$count_der;?>"><?=$occupation['text'];?>
				   			<label id="showBesch_<?=$count_der;?>" class="post_count besch_c <?=$occupation['value'];?>">(<?=countJobByBeschäftigung($occupation['value']);?>)</label>
				   		</label><br>
					<?php $count_der++; endforeach;?>


					
											                       
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