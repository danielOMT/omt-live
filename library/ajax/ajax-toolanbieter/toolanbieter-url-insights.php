<?php

use OMT\API\Salesviewer;
use OMT\Model\User;
use OMT\Services\Date;
use OMT\Services\FlashMessages;
use OMT\Services\SalesViewerExport;

$page = $_REQUEST['page'] ?: $_COOKIE['toolanbieter-url-insights-page'] ?: 1;
$requestedUrl = $_REQUEST['url'] ?: $_COOKIE['toolanbieter-url-insights-url'] ?: '';

$url = reset(array_filter(
    User::init()->salesViewerUrls(get_current_user_id()),
    fn ($url) => !$requestedUrl || $requestedUrl == $url->url
));

$info = Salesviewer::init()->urlInfo($url, $page);

if ($info && isset($_GET['export'])) {
    (new SalesViewerExport)->handle($url->url, $page, $info);
}
?>
<div>
    <?php echo FlashMessages::render() ?>

    <?php if ($url) : ?>
        <div class="x-flex x-justify-between x-items-baseline">
            <h4 style="margin-bottom: 0 !important">URL insights für: <?php echo $url->url ?></h4>

            <!-- <a href="<?php echo site_url() ?>/toolanbieter/?updated=true&area=url-insights&url=<?php echo urlencode($url->url) ?>&page=<?php echo $page ?>&export=1" class="button button-red x-whitespace-nowrap">
                Nach Google Sheets exportieren
            </a> -->
        </div>

        <div class="x-text-right x-mb-2 x-flex x-justify-end">
            <span class="x-mr-2">Powered by</span> 

            <a class="x-border-0 x-flex" href="https://www.salesviewer.com/omt" target="_blank">
                <img class="x-m-0 x-w-5" src="https://www.salesviewer.com/img/front/salesviewer-logo-retina.png" alt="Salesviewer">
                <span class="x-ml-1">Salesviewer</span>
            </a>
        </div>

        <?php if ($info) : ?>
            <table>
                <thead>
                    <th style="width: 50px;">#</th>
                    <th>Unternehmen</th>
                    <th>Datum</th>
                    <th>Stadt</th>
                    <th>Dauer</th>
                    <th>Interesse</th>
                    <th>Quelle</th>
                    <th class="x-w-16"></th>
                </thead>
                <tbody>
                    <?php foreach ((array) $info->result as $key => $result) : ?>
                        <tr x-data="{ showModal: false }">
                            <td><?php echo $key + 1 ?></td>
                            <td>
                                <?php echo $result->company->name ?>
                            </td>
                            <td>
                                <?php echo Date::get($result->startedAt)->format('d.m.Y H:i') ?>
                            </td>
                            <td>
                                <?php echo $result->company->city ?>
                            </td>
                            <td>
                                <?php echo Date::secondsToMinutes($result->duration_secs) ?>
                            </td>
                            <td>
                                <?php echo implode(",", array_map(fn ($interest) => $interest->name, $result->interests)) ?>
                            </td>
                            <td>
                                <div class="ellipsis-text" title="<?php echo $result->referer->url ?>">
                                    <?php echo $result->referer->url ?>
                                </div>
                            </td>
                            <td>
                                <button @click="showModal = true" type="button" class="x-border-0 x-bg-transparent" title="Einzelheiten">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="x-h-6 x-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </button>

                                <!-- Modal -->
                                <div x-show="showModal" x-cloak class="x-bottom-0 x-fixed x-h-full x-left-0 x-w-full x-z-999 omt-modal-window">
                                    <div class="x-flex x-items-center x-justify-center x-min-h-screen">
                                        <div 
                                            @click.away="showModal = false"
                                            class="x-bg-white x-flex x-flex-col x-p-4 x-rounded omt-modal-content"
                                        >
                                            <div class="x-flex x-items-center x-w-full">
                                                <div class="x-text-lg"><strong>Zusätzliche Information</strong></div>

                                                <button @click="showModal = false" type="button" class="x-ml-auto x-border-0 x-bg-transparent">
                                                    <svg class="x-w-6 x-h-6 x-align-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <hr class="x-my-4 x-border-t-0 x-border-b x-border-blue-300 x-w-full">

                                            <!-- Modal content -->
                                            <div class="x-overflow-y-auto">
                                                <div class="x-flex x-w-full">
                                                    <div class="x-flex-50 x-pr-4">
                                                        <div class="x-text-lg x-text-red-800 x-mb-4"><strong>Allgemein</strong></div>

                                                        <div>
                                                            <strong><?php echo $result->company->name ?></strong>
                                                        </div>

                                                        <div class="x-mb-4 x-text-sm">
                                                            <?php echo $result->company->sector->name ?>
                                                        </div>

                                                        <div>
                                                            <?php echo $result->company->street ?>
                                                        </div>
                                                        <div class="x-mb-4">
                                                            <?php echo $result->company->zip ?> <?php echo $result->company->city ?>
                                                        </div>

                                                        <?php if (isset($result->company->phone)) : ?>
                                                            <div class="x-mb-4">
                                                                <?php echo $result->company->phone ?>
                                                            </div>
                                                        <?php endif ?>
                                                       
                                                    </div>
                                                </div>

                                                <hr class="x-w-full x-my-4 x-border-t-0 x-border-b x-border-blue-300">

                                            </div>
                                            <!-- End modal content -->

                                            <div class="x-flex x-justify-between x-w-full">
                                                <div class="x-flex">
                                                    <a target="_blank" class="button button-dark-blue" href="<?php echo $result->company->url ?>">
                                                        Website
                                                    </a>
                                                    <a target="_blank" class="button x-ml-4" href="<?php echo $result->company->linkedinUrl ?>">
                                                        LinkedIn
                                                    </a>
                                                    <a target="_blank" class="button button-red x-ml-4" href="<?php echo $result->company->xingUrl ?>">
                                                        XING
                                                    </a>
                                                </div>

                                                <button @click="showModal = false" class="button button-grey" type="button">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <?php if ($info->pagination->total > 1) : ?>
                <div class="url-insights-pagination">
                    <div>
                        Seite: <?php echo $info->pagination->current ?> / <?php echo $info->pagination->total ?>
                    </div>
                    <div class="toolanbieter-subnav-wrap">
                        <div class="backend-area-subnav">
                            <?php if (!$info->pagination->isFirst) : ?>
                                <a href="#" data-backend="toolanbieter-url-insights" data-url="<?php echo $url->url ?>" data-page="<?php echo $info->pagination->current - 1 ?>">Vorherige Seite</a>
                            <?php endif ?>

                            <?php if (!$info->pagination->isLast) : ?>
                                <a href="#" data-backend="toolanbieter-url-insights" data-url="<?php echo $url->url ?>" data-page="<?php echo $info->pagination->current + 1 ?>">Nächste Seite</a>
                            <?php endif ?>                    
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php else : ?>
            Salesviewer-API-Fehler
        <?php endif ?>
    <?php endif ?>
</div>