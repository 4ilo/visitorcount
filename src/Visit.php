<?php

namespace Ovde\Visitorcount;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;
    public $fillable = ["datum", "ipAdres", "browser", "platform"];
    
    /**
     * Bij het opvragen van een datum is het automatich een carbon object
     * @param $date
     * @return Carbon
     */
    public function getDatumAttribute($date)
    {
        return Carbon::createFromFormat("Y-m-d",$date);
    }
    
    /**
     * Returnt aantal visits deze maand
     * @return int
     */
    static public function aantalDezeMaand()
    {
        $visits = Visit::where('datum', ">=", Carbon::now()->startOfMonth())->get();
        
        return $visits->count();
    }
    
    
    /**
     * Returnt het aantal bezoekers in een bepaalde maand
     * @param $maand
     * @param $jaar
     * @return int
     */
    static public function aantalInMaand($maand, $jaar)
    {
        $visits = Visit::whereYear("datum", "=", $jaar)
                       ->whereMonth("datum", "=", $maand)
                       ->get();
        
        return $visits->count();
        
    }
    
    /**
     * Kijkt welke browser het meest gebruikt is in een collectie
     * @param $visits
     * @return mixed
     */
    static public function bestBrowser($visits)
    {
        return $visits->groupBy("browser")->sort()->last()->first()->browser;
    }
    
    /**
     * Kijkt welke browser het meest gebruikt is in een collectie
     * @param $visits
     * @return mixed
     */
    static public function bestPlatform($visits)
    {
        return $visits->groupBy("platform")->sort()->last()->first()->platform;
    }
}
