<?php

namespace App\DTO;

use Illuminate\Support\Collection;

class WeatherBitDTO
{
    private array $params = [];

    private array $userIds = [];

    public function setParam(string $key, mixed $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function setUsers(Collection $users): self
    {
        $users->map(fn($user) => $this->userIds[] = $user->user_id);

        return $this;
    }

    public function toQueryParam(): string
    {
        return '?' . http_build_query($this->params);
    }
}
