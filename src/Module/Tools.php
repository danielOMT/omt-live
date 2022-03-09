<?php

namespace OMT\Module;

use OMT\Ajax\LoadTools;
use OMT\Model\Datahost\MarketingTool;
use OMT\Model\PostModel;
use OMT\View\View;

class Tools extends Module
{
    protected $useFilter;
    protected $useSorting;
    protected $type;
    protected $table;
    protected $category;

    public function __construct(array $data)
    {
        $this->useFilter = $data['mit_filter'] == 1 ? true : false;
        $this->useSorting = $data['mit_sortierfunktion'] == 1 ? true : false;
        $this->type = $data['tabelle_kategorie'];
        $this->table = $data['tabelle_auswahlen'];
        $this->category = $this->type == 'kategorie' && $data['kategorie_auswahlen']
            ? $data['kategorie_auswahlen']
            : null;

        LoadTools::getInstance()->enqueueScripts();
    }

    public function render()
    {
        $filters = [
            // Fetch published and private tools, logic migrated from JSON solution
            'status' => [PostModel::POST_STATUS_PUBLISH, PostModel::POST_STATUS_PRIVATE]
        ];
        
        $worthColumn = $this->category ? 't2c.`worth`' : 'worth';
        $options = [
            // Default sorting is by Sponsored/Worth/$wert (=> Rating => Count of reviews => Alphabetical)
            'order' => [$worthColumn => 'DESC', 'rating' => 'DESC', 'reviews_count' => 'DESC', 'preview_title' => 'ASC'],
            'with' => ['categories', 'tracking_links', 'details']
        ];

        if ($this->category) {
            $filters['category'] = $this->category->term_id;
        }

        if ($this->type == 'tabelle') {
            // Get all tools assigned to the "Tooltabelle" post type
            $filters['id'] = array_map(fn ($item) => $item['tool']->ID, (array) get_field('tools_auswahlen', $_GET['table']));
        }

        $tools = $filters['category'] || $filters['id']
            ? MarketingTool::init()->items($filters, $options)
            : [];

        return View::loadTemplate(['modules' => 'tools'], [
            'useFilter' => $this->useFilter,
            'useSorting' => $this->useSorting,
            'type' => $this->type,
            'table' => $this->table,
            'category' => $this->category,
            'tools' => $tools,
            'usePriceFreeFilter' => count(array_filter($tools, fn ($tool) => $tool->has_free_plan)) ? true : false,
            'usePricePaidFilter' => count(array_filter($tools, fn ($tool) => $tool->has_paid_plan)) ? true : false,
            'usePriceTestFilter' => count(array_filter($tools, fn ($tool) => $tool->has_test_plan)) ? true : false,
            'usePriceTrialFilter' => count(array_filter($tools, fn ($tool) => $tool->has_trial_plan)) ? true : false,
            'moreButtonTitle' => $this->category ? $this->category->name : 'Tools'
        ]);
    }
}
