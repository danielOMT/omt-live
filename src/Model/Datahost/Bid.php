<?php

namespace OMT\Model\Datahost;

use OMT\Model\Tool;
use OMT\Services\Date;
use stdClass;

class Bid extends Model
{
    protected $tablePrefix = 'omt';

    public function currentToolsBids()
    {
        $toolModel = Tool::init();
        $groupedBids = [];

        foreach ($this->active() as $bid) {
            $groupedBids[$bid->tool_id] ??= new stdClass;
            $groupedBids[$bid->tool_id]->name ??= get_the_title($bid->tool_id);
            $groupedBids[$bid->tool_id]->categories ??= $toolModel->getToolCategoriesWithActiveLinks($bid->tool_id);
            $groupedBids[$bid->tool_id]->bids ??= [];

            if (array_key_exists($bid->toolkategorie_id, $groupedBids[$bid->tool_id]->categories)) {
                $bid->category = $groupedBids[$bid->tool_id]->categories[$bid->toolkategorie_id]['term'] ?? null;
                $groupedBids[$bid->tool_id]->bids[] = $bid;
            }
        }

        return $groupedBids;
    }

    public function active()
    {
        return $this->db->get_results("SELECT * FROM `" . $this->table() . "` WHERE `is_active` = 1");
    }

    public function set(int $toolId, int $categoryId, float $bid, int $userId, string $userIp)
    {
        $timestamp = Date::get()->getTimestamp();

        // Deactivate old bid if exist
        $query = $this->db->update(
            $this->table(),
            $this->db->prepareDataToInsertion(['is_active' => 0, 'timestamp_valid_until' => $timestamp]),
            ['tool_id' => $toolId, 'toolkategorie_id' => $categoryId, 'is_active' => 1]
        );

        if ($query === false) {
            $this->addError('Fehler beim Deaktivieren des alten Gebots');

            return false;
        }

        // Create new bid
        $query = $this->store([
            'tool_id' => $toolId,
            'toolkategorie_id' => $categoryId,
            'bid_kosten' => $bid,
            'timestamp_valid_from' => $timestamp,
            'timestamp_valid_until' => '9999999999',
            'is_active' => 1,
            'user_id' => $userId,
            'user_ip' => $userIp
        ], ['timestamps' => false]);

        if ($query === false) {
            $this->addError('Fehler beim Speichern des neuen Gebots');

            return false;
        }

        return $this->db->insert_id;
    }

    protected function itemsConditions(array $filters = [])
    {
        $alias = $this->getAlias();
        $conditions = parent::itemsConditions($filters);

        if (isset($filters['tool'])) {
            $conditions[] = $alias . '.`tool_id` = ' . (int) $filters['tool'];
        }

        if (isset($filters['category'])) {
            $conditions[] = $alias . '.`toolkategorie_id` = ' . (int) $filters['category'];
        }

        if (isset($filters['active'])) {
            $conditions[] = $alias . '.`is_active` = ' . ($filters['active'] ? 1 : 0);
        }

        return $conditions;
    }

    protected function getTableName()
    {
        return 'bids';
    }
}
