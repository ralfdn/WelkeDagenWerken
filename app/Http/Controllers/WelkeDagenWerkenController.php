<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\Plugin\GetWithMetadata;

class WelkeDagenWerkenController extends Controller
{
    public function CalcBestWorkDays(int $hoursToWork, int $year)
    {
        $remainingHoursToWork = $hoursToWork;

        $week = $this->GetFreeDays($year);

        $index = 0;
        foreach($week as $day)
        {
            while($day['workHours'] < 8 && $remainingHoursToWork > 0 && $day['name'] != 'zondag' && $day['name'] != 'zaterdag')
            {
                $week[$index]['workHours']++;
                $day['workHours']++;
                $remainingHoursToWork--;
            }
            $index++;
        }

        return response()->json($week);
    }

    public function GetFreeDays(int $year)
    {
        $week = array(
            array(
                'name' => 'zondag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'maandag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'dinsdag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'woensdag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'donderdag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'vrijdag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
            array(
                'name' => 'zaterdag',
                'freeDays' => 0,
                'workHours' => 0,
            ),
        );

        $holidays = $this->GetHolidays($year);

        foreach($holidays as $day)
        {
            $week[$day->dayOfWeek]['freeDays']++;
        }

        usort($week, function($a, $b) {
            return $a['freeDays'] <=> $b['freeDays'];
        });

        $week = array_reverse($week);

        return $week;
    }

    public function GetHolidays($year)
    {
        $newYearsDay = new Carbon("$year-01-01");
        $firstEasterday = $this->GetEasterDate($year);
        $goodFriday = $this->GetGoodFriday(clone $firstEasterday);
        $secondEasterday = clone $firstEasterday;
        $secondEasterday->addDay();
        $kingsDay = $this->GetKingsDay(new Carbon("$year-04-27"));
        $liberationDay = new Carbon("$year-05-05");
        $accensionDay = clone $firstEasterday;
        $accensionDay->addDays(39);
        $firstPentecost = clone $firstEasterday;
        $firstPentecost->addDays(49);
        $secondPentecost = clone $firstPentecost;
        $secondPentecost->addDay();
        $firstChristmasDay = new Carbon("$year-12-25");
        $secondChristmasDay = clone $firstChristmasDay;
        $secondChristmasDay->addDay();

        $holidays = array(
            $newYearsDay,
            $goodFriday,
            $firstEasterday,
            $secondEasterday,
            $kingsDay,
            $liberationDay,
            $accensionDay,
            $firstPentecost,
            $secondPentecost,
            $firstChristmasDay,
            $secondChristmasDay,
        );

        return $holidays;
    }

    public function GetEasterDate(int $year)
    {
        // formule bron: https://nl.wikipedia.org/wiki/Paas-_en_pinksterdatum
        $A = $year;
        $G = ($A%19)+1;
        $C = floor($A/100)+1;
        $X = floor(3*$C/4)-12;
        $Y = floor((8*$C+5)/25)-5;
        $Z = floor(5*$A/4)-10-$X;
        $E = (11*$G+20+$Y-$X)%30;
        if(($E==24||$E==25)&&$G>11) { $E++; }
        $N = 44-$E;
        if($N<21) { $N = $N+30; }
        $P = $N+7-(($Z+$N)%7);
        $M = 3;
        if($P>31){ $P = $P-31; $M++;}
        $easterDate = new Carbon("$A-$M-$P");

        return $easterDate;
    }

    public function GetGoodFriday(Carbon $date)
    {
        while($date->dayOfWeek != 5)
        {
            $date->addDays(-1);
        }

        return $date;
    }

    public function GetKingsDay(Carbon $date)
    {
        if($date->dayOfWeek == 0)
        {
            $date->addDays(-1); // als de 27e een zondag is.
        }
        return $date;
    }
}
