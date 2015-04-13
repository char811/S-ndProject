<?php

class Article extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name', 'rus_name', 'id_section', 'time'];


    public function getUser()
    {
        $this->belongsTo('User', 'user');
    }

    public static function getNewDate($day=0, $month=0, $year=0, $hour=0, $minutes=0)
    {
        $day=date('d')-$day;
        $month=date('m')-$month;
        $year=date('Y')-$year;
        if($hour==0)
        {
           $hour=date('H');
        }
        else
        {
            $hour = $hour;
        }
        if($minutes==0)
        {
            $minutes=date('i')-$minutes;
        }
        else
        {
            $minutes = $minutes;
        }
        $date = new \DateTime();
        $date->setTime($hour, $minutes);
        $date->setDate($year, $month, $day);
        $date->setTimezone(new \DateTimeZone('Europe/Moscow'));
        $time=$date->getTimestamp();
        return $time;
    }
}