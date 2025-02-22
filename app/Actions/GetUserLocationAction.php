<?php

namespace App\Actions;

use App\Models\UserLocation;
use Illuminate\Support\Collection;

final class GetUserLocationAction
{
    public function __invoke(): Collection
    {
        return UserLocation::select('city', 'user_id')->get()->groupBy('city');
    }
}
