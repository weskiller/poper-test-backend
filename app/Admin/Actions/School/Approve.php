<?php

namespace App\Admin\Actions\School;

use App\Constants\SchoolStatus;
use App\Models\School;
use App\Services\SchoolService;
use Encore\Admin\Actions\RowAction;

class Approve extends RowAction
{
    public $name = 'Approve';

    public function handle(School $school)
    {
        if ($school->status === SchoolStatus::Approved->value) {
            return $this->response()->warning(sprintf('School %s Already Approved.', $school->name))->refresh();
        }
        (new SchoolService($school))->approve();
        return $this->response()->success(sprintf('School %s Approved.', $school->name))->refresh();
    }

}
