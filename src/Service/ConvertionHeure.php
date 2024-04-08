<?php

namespace App\Service ;

class ConvertionHeure
{
    public function __construct()
    {
    }

    public function convertirEnHeure($minute)
    {
        $result = "";

        if ($minute > 59)
        {
            $heures = floor($minute / 60);
            $result .= $heures . " heures et ";
        }

        if ($minute)
        {
            $minutesRestantes = $minute % 60;
            $result .= $minutesRestantes . " minutes";
        }

        return $result;
    }

}