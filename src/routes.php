<?php

use Carbon\Carbon;
use Ovde\Visitorcount\Visit;
use Illuminate\Support\Facades\DB;

Route::get("visitorcount/graphdata", function () {
    
    $firstVisit = DB::table("visits")->orderBy("datum")->first();
    if (!$firstVisit) 
        return "";

    $eersteJaar = Carbon::createFromFormat("Y-m-d",$firstVisit->datum)
                        ->year;
    
    // We gaan voor elk jaar waarvoor er records zijn tellen hoeveel er per maand zijn
    $bezoekersdata = [];
    for($i = $eersteJaar; $i < Carbon::now()->year+1; $i++)
    {
        $maandData = [];
        for($j = 0; $j < 12; $j++)
        {
            if(!($i == Carbon::now()->year && $j > Carbon::now()->month-1))
            {
                $maandData[] = Visit::aantalInMaand($j+1,$i);
            }
        }
        $bezoekersdata[] = [
            "jaar" => $i,
            "data" => $maandData,
        ];
    }
    
    return $bezoekersdata;
})->middleware(config("visitorcount.middleware"));