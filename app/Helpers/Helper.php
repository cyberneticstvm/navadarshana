<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Config;

function branches()
{
    return Branch::all();
}

function gcsPublicUrl()
{
    return Config::get('myconfig.gcs_url_public');
}

function gcsPrivateUrl()
{
    return Config::get('myconfig.gcs_url_private');
}

function uniqueRegistrationId()
{
    /*do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;*/
}
