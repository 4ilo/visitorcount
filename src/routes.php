<?php

use Carbon\Carbon;
use Ovde\Visitorcount\Visit;
use Illuminate\Support\Facades\DB;

Route::get("visitorcount/graphdata", function () {
    
    $eersteJaar = Carbon::createFromFormat("Y-m-d",DB::table("visits")
                                                     ->orderBy("datum")
                                                     ->first()->datum)->year;
    
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