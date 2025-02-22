<?php

namespace App\DTO;

class WeatherBitDTO
{
    private array $params = [];

    public function setParam(string $key, mixed $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function toQueryParam(): string
    {
        return '&' . http_build_query($this->params);
    }
}
