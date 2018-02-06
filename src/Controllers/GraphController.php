<?php

namespace Ovde\Visitorcount\Controllers;

use Carbon\Carbon;
use Ovde\Visitorcount\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class GraphController extends BaseController
{
    /**
     * Get the data for the graph
     * @return array|string
     */
    public function data()
    {
        if(!$firstVisit = DB::table("visits")->orderBy("datum")->first())
            return "";

        $eersteJaar = Carbon::createFromFormat("Y-m-d",$firstVisit->datum)
            ->year;

        // Count for each avalable year the visitors per month
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
    }
}
