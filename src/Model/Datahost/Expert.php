<?php

namespace OMT\Model\Datahost;

class Expert extends Model
{
    public function destroy(int $id)
    {
        WebinarExpert::init()->delete(['expert_id' => $id]);

        return parent::destroy($id);
    }

    protected function getTableName()
    {
        return 'experts';
    }
}
