<?php

use App\Models\Branch;

function branches()
{
    return Branch::all();
}

function uniqueRegistrationId()
{
    /*do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;*/
}
