<?php
	$partners = $zeile['inhaltstyp'][0]['partners'];
?>
<div class="omt-partner-container">
<?php foreach ($partners as $partner) : 
		if ($partner['link'] == '') : ?>
			<div>
				<img src="<?=$partner['image']['url'];?>" class="partner-logo">
			</div>
		<?php else: ?>
			<a href="<?=$partner['link'];?>">
				<img src="<?=$partner['image']['url'];?>" class="partner-logo">
			</a>
		<?php endif;

	?>


	

<?php endforeach;?>
</div>



	
