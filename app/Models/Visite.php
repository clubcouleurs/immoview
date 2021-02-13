<?php

namespace App\Models;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Visite extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'detail',
        'remarqueClient',
        'interet',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function visitesDay()
    {
        $now = Carbon::now();
        $day = $now->day;
		return count(Visite::whereDay('date', '=', $day)->get()) ;
    }  
    public static function VisitesWeek()
    {
    	//$now = Carbon::now();
        Carbon::setWeekStartsAt(Carbon::MONDAY);
		Carbon::setWeekEndsAt(Carbon::SUNDAY);    	
        $lundi = Carbon::now()->startOfWeek();
        $dimanche = Carbon::now()->endOfWeek();
        //dd($lundi)
		return count(Visite::whereBetween('date', [$lundi, $dimanche])->get()) ;
    }    
    public static function VisitesMonth()
    {
    	$now = Carbon::now();
        $month = $now->month;
		return count(Visite::whereMonth('date', '=', $month)->get()) ;
    }    
    public static function VisitesYear()
    {
    	$now = Carbon::now();
        $year = $now->year;
		return count(Visite::whereYear('date', '=', $year)->get()) ;
    }
         
}
