

<?php

use OMT\Model\User;

$current_user_id = get_current_user_id();

switch ($backend) {
    case "toolanbieter-tools-bearbeiten":
        $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
        $i = 0;
        foreach ($zugewiesenes_tool as $tool) {
            $tool_id = $tool->ID;
            $i++;
            ?>
            <a href="#" <?php if (1 == $i) { ?> class="active" <?php } ?>
                data-backend="toolanbieter-tools-bearbeiten"
                data-tool="<?php print $tool_id; ?>"><?php print get_the_title($tool_id); ?></a>
        <?php }
        break;

    case "toolanbieter-bids":
        $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
        $i = 0;
        ?>
        <a href="#" class="active" data-backend="toolanbieter-bids" data-tool="budget">Guthaben/Budgets</a>
        <?php foreach ($zugewiesenes_tool as $tool) {
        $tool_id = $tool->ID;
        $i++;
        ?>
        <a href="#" <?php if (1 == $i) { ?> class="" <?php } ?> data-backend="toolanbieter-bids"
            data-tool="<?php print $tool_id; ?>"><?php print get_the_title($tool_id); ?></a>
    <?php }
        break;

    case "links":
        ?>
        <?php foreach (User::init()->tools($current_user_id) as $key => $tool) : ?>
            <a href="#" <?php if ($key == 0) { ?> class="active" <?php } ?> data-backend="links" data-tool="<?php echo $tool->ID ?>"><?php echo get_the_title($tool->ID) ?></a>
        <?php endforeach;
        break;

    case "toolanbieter-statistik": 
        $zugewiesenes_tool = get_field('zugewiesenes_tool', 'user_' . $current_user_id);
        $i = 0;
        foreach ($zugewiesenes_tool as $tool) {
            $tool_id = $tool->ID;
            $i++;
            ?>
            <a href="#" <?php if (1 == $i) { ?> class="active" <?php } ?>
                data-backend="toolanbieter-statistik"
                data-tool="<?php print $tool_id; ?>"><?php print get_the_title($tool_id); ?></a>
        <?php }
        break;

    case "toolanbieter-url-insights":
        $urls = User::init()->salesViewerUrls($current_user_id);
        $requestedUrl = $_REQUEST['url'] ?: $_COOKIE['toolanbieter-url-insights-url'] ?: '';
        $activeUrl = reset(array_filter($urls, fn ($url) => !$requestedUrl || $requestedUrl == $url->url));
        ?>
        <?php if (count($urls)) : ?>
            <?php foreach ($urls as $key => $url) : ?>
                <a 
                    href="#"
                    class="<?php echo $activeUrl->url == $url->url ? 'active' : '' ?>"
                    data-backend="toolanbieter-url-insights"
                    data-url="<?php echo $url->url ?>"
                >
                    <?php echo $url->url ?>
                </a>
            <?php endforeach ?>
        <?php else : ?>
            <p> 
                Aktuell keine URLs hinzugefügt.<br>
                Um zu sehen, wer Deine Toolseite besucht hat wende Dich bitte an Deinen persönlichen Kundenbetreuer <a class="url-insights-contact" href="mailto:christos.pipsos@omt.de">Christos Pipsos ( christos.pipsos@omt.de )</a>
            </p>
        <?php endif ?>
        <?php

        break;
}