<?php

class Bind extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['id_user', 'id_section', 'id_article', 'read', 'time', 'special_article'];


    public function getUser()
    {
        $this->belongsTo('User', 'id_user');
    }

    public function getSection()
    {
        $this->belongsTo('Section', 'id_section');
    }

    public function getArticle()
    {
        $this->belongsTo('Article', 'id_article');
    }
}