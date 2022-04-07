<?php
	$partners = $zeile['inhaltstyp'][0]['partners'];
?>
<div class="omt-partner-container">
<?php foreach ($partners as $partner) : ?>

	<a href="<?=$partner['link'];?>">
		<img src="<?=$partner['image']['url'];?>" class="partner-logo">
	</a>

<?php endforeach;?>
</div>



	
