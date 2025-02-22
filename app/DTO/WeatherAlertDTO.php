<?php

namespace App\DTO;

class WeatherAlertDTO
{
    private int $userId;

    private string $alertType;

    private string $alertData;

    public function __construct()
    {
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setAlertType(string $alertType): void
    {
        $this->alertType = $alertType;
    }

    public function setAlertData(string $alertData): void
    {
        $this->alertData = $alertData;
    }
}
