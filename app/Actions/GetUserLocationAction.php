<?php

namespace App\Actions;

use App\Models\UserLocation;

final class GetUserLocationAction
{
    public function __invoke()
    {
        return UserLocation::select('city', 'user_id')->get()->groupBy('city');
    }
}
