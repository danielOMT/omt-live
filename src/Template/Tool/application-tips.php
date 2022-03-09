<?php foreach ((array) $this->applicationTips as $applicationTip) : ?>
    <div class="anwendungstipp">
        <h2 class="anwendungstipp-title"><?php echo $applicationTip['anwendungstipp_headline'] ?></h2>

        <div class="anwendungstipp-content">
            <?php echo $applicationTip['beschreibungstext'] ?>
        </div>
    </div>
<?php endforeach ?>