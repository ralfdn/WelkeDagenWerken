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

            foreach($week as $day)
            {
                while($day['workHours'] < 8 && $remainingHoursToWork > 0)
                {
                    $day['workHours']++;
                    $remainingHoursToWork--;
                }
                $message = "Werk $day[workHours] uur op $day[name].";
                var_dump($message);
            }

        foreach($week as $day)
        {
            $message = "Er zijn $day[freeDays] vrije dagen op $day[name].";
            var_dump($message);
        }

        $hoursToWork = "Je werkt in totaal " . $hoursToWork . " uur per week.";

        var_dump($hoursToWork);
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

        // mogelijk ophalen vanuit database

        // Nieuwjaarsdag: 1 januari 2022
        $date = new Carbon("$year-01-01");
        $week[$date->dayOfWeek]['freeDays']++;
        // Goede vrijdag: eerste vrijdag voor pasen . 15 april 2022
        $date = new Carbon("$year-04-15");
        $week[$date->dayOfWeek]['freeDays']++;
        // eerste paasdag: eerste zondag na eerste volle maan in de lente
        // formule bron: https://nl.wikipedia.org/wiki/Paas-_en_pinksterdatum
        $A = $year;
        $G = ($A%19)+1;
        $C = floor($year/100)+1;
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
        $test = new Carbon("$A-$M-$P");
        var_dump($test->dayName);
        var_dump($test->day);
        var_dump($test->monthName);
        var_dump($test->year);

        // $date = new Carbon("$year-04-17");
        $week[$date->dayOfWeek]['freeDays']++;
        // Tweede Paasdag: na eerste paasdag
        $date->addDay();
        $week[$date->dayOfWeek]['freeDays']++;
        // Hemelvaartsdag: 40 dagen na eerste paasdag
        $date->addDays(38);
        $week[$date->dayOfWeek]['freeDays']++;
        // Eerste Pinksterdag: 10 dagen na Hemelvaartsdag
        $date->addDays(10);
        $week[$date->dayOfWeek]['freeDays']++;
        // Tweede Pinksterdag: na Eerste Pinksterdag
        $date->addDay();
        $week[$date->dayOfWeek]['freeDays']++;
        // Koningsdag: 27 april tenzij dat zondag is.
        $date = new Carbon("$year-04-27");
        if($date->dayOfWeek == 0)
        {
            $date->addDays(-1); // als de 27e een zondag is.
        }
        $week[$date->dayOfWeek]['freeDays']++;
        // Bevrijdingsdag: 5 mei 2022
        $date = new Carbon("$year-05-05");
        $week[$date->dayOfWeek]['freeDays']++;
        // Eerste Kerstdag: 25 december 2022
        $date = new Carbon("$year-12-25");
        $week[$date->dayOfWeek]['freeDays']++;
        // tweede Kerstdag: na eerste Kerstdag
        $date->addDay();
        $week[$date->dayOfWeek]['freeDays']++;

        usort($week, function($a, $b) {
            return $a['freeDays'] <=> $b['freeDays'];
        });

        $week = array_reverse($week);

        return $week;
    }
}
