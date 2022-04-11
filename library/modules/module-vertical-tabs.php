
<?php
	$tabs = $zeile['inhaltstyp'][0]['vtabs'];
	$count = 0;
	$count_content = 0;
	$defaultActiveTab = '';
?>
<div class="tab-omt">
	<?php foreach ($tabs as $tab) :
		if($count == 0){ $defaultActiveTab =  'defaultOpen'; }
	?>
    <button class="tablinks-omt" onclick="openVertTab(event, 'tab_<?=$count;?>')" id="<?=$defaultActiveTab;?>">
       <?=$tab['tab_lin'];?> 
    </button>
	<?php $count++; 
	endforeach; ?>
</div>
<?php foreach ($tabs as $tab) :?>
	<div id="tab_<?=$count_content;?>" class="tabcontent-omt">
		<img src="<?=$tab['tab_image']['url']?>" alt="<?=$tab['tab_lin'];?>" width="550" height="290">
	    <p><?=$tab['tab_content'];?></p>
  	</div>
<?php $count_content++;
endforeach; ?>
