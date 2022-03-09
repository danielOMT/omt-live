<?php

namespace OMT\Model\Datahost;

use OMT\Filters\JobProfile as JobProfileFilters;

class JobProfile extends Model
{
    const UPLOAD_DIR = 'job-profiles';

    public function store(array $data = [], array $options = [])
    {
        if (isset($data['experience_industries']) && is_array($data['experience_industries'])) {
            $data['experience_industries'] = json_encode(array_map('intval', $data['experience_industries']));
        }

        if (isset($data['job_change_reason']) && is_array($data['job_change_reason'])) {
            $data['job_change_reason'] = json_encode(array_map('intval', $data['job_change_reason']));
        }

        if (isset($data['marketing_area_interest']) && is_array($data['marketing_area_interest'])) {
            $data['marketing_area_interest'] = json_encode($data['marketing_area_interest']);
        }

        return parent::store($data, $options);
    }

    protected function extendItems(array $items = [], array $options = [])
    {
        foreach ($items as $item) {
            $item->experience_industries = (array) json_decode($item->experience_industries);
            $item->job_change_reason = (array) json_decode($item->job_change_reason);
            $item->marketing_area_interest = (array) json_decode($item->marketing_area_interest);
        }

        return $items;
    }

    public function getUploadDir()
    {
        return wp_upload_dir()['basedir'] . '/' . self::UPLOAD_DIR . '/';
    }

    protected function itemsSelect(array $filters = [], array $options = [])
    {
        $select = parent::itemsSelect($filters, $options);

        if (in_array('user', $options['with'])) {
            $select[] = 'user.`display_name` AS user_name';
        }

        return $select;
    }

    protected function itemsConditions(array $filters = [])
    {
        return [
            ...parent::itemsConditions($filters),
            ...(new JobProfileFilters($this->getAlias()))->apply($filters)
        ];
    }

    protected function itemsJoins(array $filters = [], array $options = [])
    {
        $joins = [];
        $alias = $this->getAlias();

        if (in_array('user', $options['with'])) {
            $joins[] = 'LEFT JOIN ' . $this->db->mainDBTable('users') . ' AS user ON ' . $alias . '.`user_id` = user.`ID`';
        }

        return $joins;
    }

    protected function getTableName()
    {
        return 'job_profiles';
    }
}
