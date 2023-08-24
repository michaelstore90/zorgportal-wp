<?php

/* > Validation
    - Has to be validated for date existence, a code cannot be double assigned on a date
    - OR, the date period is Smaller, The smaller the higer prio
    */


namespace Zorgportal\Admin\Screen;

use Zorgportal\DbcCodes as Codes;

class AddDbcCode extends EditDbcCode
{
    protected $clone;

    public function init()
    {
        if ( $clone_id = intval($_GET['clone_id'] ?? '') ) {
            if ( 'POST' !== ($_SERVER['REQUEST_METHOD'] ?? '') )
                $this->clone = Codes::queryOne(['id' => $clone_id]);
        }

        $this->code = [];
    }
}