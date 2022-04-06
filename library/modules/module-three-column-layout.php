<?php
	$boxes = $zeile['inhaltstyp'][0]['layout'];
?>
<div class="omt-three-column-container">
<?php foreach ($boxes as $box) : ?>
		<div>
			<img src="<?=$box['image']['url'];?>">
			<h6><?=$box['title'];?></h6>
			<p><?=$box['text'];?></p>
		</div>
<?php endforeach;?>
</div>