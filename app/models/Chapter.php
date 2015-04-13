<?php

class Chapter extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['user', 'section'];


    public function getUser()
    {
        $this->belongsTo('User', 'user');
    }

    public function getSection()
    {
        $this->belongsTo('Section', 'section');
    }
}