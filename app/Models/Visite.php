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
        'typeContact',
        'source',
        'domaine',
        'surfaceDesired',
        'autre',
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
        $date = $now->toDateString();
        $appels = count(Visite::where('date', '=', $date)->where('typeContact','appel')->get());
        $all = count(Visite::where('date', '=', $date)->get()) ;
        $v = $all - $appels ;
        return [$appels,$v];
    }  
    public static function VisitesWeek()
    {
        Carbon::setWeekStartsAt(Carbon::MONDAY);
		Carbon::setWeekEndsAt(Carbon::SUNDAY);    	
        $lundi = Carbon::now()->startOfWeek();
        $dimanche = Carbon::now()->endOfWeek();
        $appels = count(Visite::whereBetween('date', [$lundi, $dimanche])->where('typeContact','appel')->get());
        $all = count(Visite::whereBetween('date', [$lundi, $dimanche])->get()) ;
        $v = $all - $appels ;
		return [$appels,$v];
    }    
    public static function VisitesMonth()
    {
    	$now = Carbon::now();
        $month = $now->month;

        $appels = count(Visite::whereMonth('date', '=', $month)->where('typeContact','appel')->get());
        $all = count(Visite::whereMonth('date', '=', $month)->get()) ;
        $v = $all - $appels ;
        return [$appels,$v];
    }    
    public static function VisitesYear()
    {
    	$now = Carbon::now();
        $year = $now->year;

        $appels = count(Visite::whereYear('date', '=', $year)->where('typeContact','appel')->get());
        $all = count(Visite::whereYear('date', '=', $year)->get()) ;
        $v = $all - $appels ;
        return [$appels,$v];

    }
    public static function Interets()
    {
        return Visite::groupBy('interet')
                        ->selectRaw('count(*) as nombre, interet')
                        ->get();
    }    

    public static function sources()
    {
        return Visite::groupBy('source')
                        ->selectRaw('count(*) as nombre, SUBSTRING_INDEX(source, " ", 1) as source')
                        ->where('source', '!=',' ')
                        ->get();
    }      
         
}
