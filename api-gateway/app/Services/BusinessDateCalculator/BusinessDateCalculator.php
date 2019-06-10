<?php
namespace App\Services\BusinessDateCalculator;

use PHPUnit\Runner\Exception;
use App\services\BusinessDateCalculator\Interfaces\BusinessDateCalculatorInterface;

/**
 * Class Calculator
 *
 * @package BusinessDays
 */
class BusinessDateCalculator implements BusinessDateCalculatorInterface
{
    const MONDAY    = 1;
    const TUESDAY   = 2;
    const WEDNESDAY = 3;
    const THURSDAY  = 4;
    const FRIDAY    = 5;
    const SATURDAY  = 6;
    const SUNDAY    = 7;
    const WEEK_DAY_FORMAT = 'N';
    const HOLIDAY_FORMAT  = 'm-d';
    const FREE_DAY_FORMAT = 'Y-m-d';
    /** @var \DateTime */
    private $date;
    /** @var \DateTime[] */
    private $holidays = array();
    /** @var \DateTime[] */
    private $freeDays = array();
    /** @var int[] */
    private $freeWeekDays = [
        BusinessDateCalculator::SATURDAY,
        BusinessDateCalculator::SUNDAY
    ];

    private $totalDays = 0;
    private $totalHolidays = 0;
    private $totalFreeWeekDays = 0;
    private $delay;
    private $processedYears = [];


    private $locales = [
        "us" => "us.php"
    ];

    private $selectedLocale;




    /**
     * @param \DateTime $startDate Date to start calculations from
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        if (!\array_key_exists($locale, $this->locales)) {
            throw new Exception("Locale not currently supported");
        }

        $this->selectedLocale = $locale;
        return $this;
    }

    public function setDelay($delay)
    {
        $this->delay = $delay;
        return $this;
    }
    /**
     * @param \DateTime $startDate Date to start calculations from
     *
     * @return $this
     */
    public function setStartDate(\DateTime $startDate)
    {
        // Use clone so parameter is not passed as a reference.
        // If not, it can brake caller method by changing $startDate parameter while changing it here.
        $this->date = clone $startDate;
        return $this;
    }
    /**
     * @param \DateTime[] $holidays Array of holidays that repeats each year. (Only month and date is used to match).
     *
     * @return $this
     */
    public function setHolidays($holidays = [])
    {

        $startDate = clone $this->date;
        $startYear = $startDate->format('Y');
        $endYear = $startDate->modify("+{$this->delay} day")->format('Y');

        $numberOfYears = ((int) (strtotime("$endYear-01-01") - strtotime("$startYear-01-01"))) / 31536000;

        if (count($holidays) === 0) {
            $holidaysTemplate = require(__DIR__."/Locales/{$this->selectedLocale}.php");;
            for ($i = 0; $i < $numberOfYears + 1; ++$i) {
                $year = $startYear + $i;
                $holidays  = array_merge($holidays, array_map(function($holidayTemplate) use ($year) {
                    return "$year$holidayTemplate";
                }, $holidaysTemplate));

            }
        }

        $this->holidays = array_map(function($day) {
            return date('Y-m-d', strtotime($day));
        }, $holidays);

        return $this;
    }
    /**
     * @return \DateTime[]
     */
    private function getHolidays()
    {
        return $this->holidays;
    }
    /**
     * @return \int
     */
    public function getTotalDays()
    {
        return $this->totalDays;
    }
    /**
     * @return \int
     */
    public function getTotalHolidays()
    {
        return $this->totalHolidays;
    }
    /**
     * @return \int
     */
    public function getTotalFreeWeekDays()
    {
        return $this->totalFreeWeekDays;
    }
    /**
     * @param \DateTime[] $freeDays Array of free days that dose not repeat.
     *
     * @return $this
     */
    public function setFreeDays(array $freeDays)
    {
        $this->freeDays = $freeDays;
        return $this;
    }
    /**
     * @return \DateTime[]
     */
    private function getFreeDays()
    {
        return $this->freeDays;
    }
    /**
     * @param int[] $freeWeekDays Array of days of the week which are not business days.
     *
     * @return $this
     */
    public function setFreeWeekDays(array $freeWeekDays)
    {
        $this->freeWeekDays = $freeWeekDays;
        return $this;
    }
    /**
     * @return int[]
     */
    private function getFreeWeekDays()
    {
        if (count($this->freeWeekDays) >= 7) {
            throw new \InvalidArgumentException('Too many non business days provided');
        }
        return $this->freeWeekDays;
    }

    public function process ()
    {
        $this->setHolidays()->addBusinessDays();
        return $this;
    }
    /**
     * @param int $howManyDays
     *
     * @return $this
     */
    public function addBusinessDays()
    {
        $iterator = 0;
        $this->getDate()->modify('-1 day');
        // if ($howManyDays > 0) $this->totalDays = 1;
        while ($iterator < $this->delay) {
            $this->getDate()->modify('+1 day');
            if ($this->isBusinessDay($this->getDate())) {
                $iterator++;
            }

            $this->totalDays++;
        }
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getDate()
    {
        if ($this->date === null) {
            $this->date = new \DateTime();
        }
        return $this->date;
    }
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isBusinessDay(\DateTime $date)
    {
        if ($this->isFreeWeekDayDay($date)) {
            return false;
        }
        if ($this->isHoliday($date)) {
            $this->totalHolidays++;
            return false;
        }
        if ($this->isFreeDay($date)) {
            return false;
        }
        return true;
    }
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isFreeWeekDayDay(\DateTime $date)
    {
        $currentWeekDay = (int)$date->format(self::WEEK_DAY_FORMAT);
        if (in_array($currentWeekDay, $this->getFreeWeekDays())) {
            $this->totalFreeWeekDays++;
            return true;
        }
        return false;
    }

    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isHoliday(\DateTime $date)
    {

        // logger($date->format('Y-m-d'));

        // // logger($this->holidays);
        // logger(in_array($date->format('Y-m-d'), $this->holidays));



        // $year = $date->format('Y');

        // if (isset($this->hols[$year]))
        // {
            return in_array($date->format('Y-m-d'), $this->holidays);
        // } else {

        // }

        // $holidayFormatValue = $date->format(self::HOLIDAY_FORMAT);
        // foreach ($this->getHolidays() as $holiday) {
        //     if ($holidayFormatValue == $holiday->format(self::HOLIDAY_FORMAT)) {
        //         $this->totalHolidays++;
        //         return true;
        //     }
        // }
        // return false;
    }
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isFreeDay(\DateTime $date)
    {
        $freeDayFormatValue = $date->format(self::FREE_DAY_FORMAT);
        foreach ($this->getFreeDays() as $freeDay) {
            if ($freeDayFormatValue == $freeDay->format(self::FREE_DAY_FORMAT)) {
                return true;
            }
        }
        return false;
    }
}
