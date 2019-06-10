<?php
namespace App\Services\BusinessDateCalculator\Interfaces;

interface BusinessDateCalculatorInterface {
    public function getDate();
    public function setDelay($delay);
    public function setStartDate(\DateTime $dateTime);
    public function setLocale($locale);
    public function setHolidays();
    public function addBusinessDays();
}
