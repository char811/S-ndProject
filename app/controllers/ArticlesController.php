<?php

class ArticlesController extends \BaseController {

	/**
	 * Display a listing of articles
	 *
	 * @return Response
	 */
	public function index()
	{
        DB::transaction(function()
        {
            $binds = Chapter::where('user', '=', Auth::user()->id)->get();
        foreach($binds as $bind)
        {
            $ready=Section::where('id', '=', $bind->section)->first();
            $sections[$ready->name]=$ready->check_time;
        }

        $minutes=date('i')-5;
        $time_5_minutes = Article::getNewDate(0,0,0,0,$minutes);

        $time_new = Article::getNewDate();

       if(isset($sections))
       {
       foreach($sections as $key => $val)
       {
         if($val<$time_5_minutes)
         {
             $id=Section::where('name', '=', $key)->first();

             $url='http://habrahabr.ru/hub/'.$key.'/';
             $file=file_get_contents($url);


             preg_match_all("#<div class=\"published\">(.*?)</div>\s+\<h1 class\=\"title\">\s+\<a href\=\"http\://habrahabr\.ru/(.*?)/\"(.*?)\>(.*?)\</a>|
        <div class=\"published\">(.*?)</div>\s+\<h1 class\=\"title\">\s+\<a (.*?) href\=\"http\://habrahabr\.ru/(.*?)/\"\>(.*?)\</a>#i",
                 $file, $article);

           for($i=(count($article[1])-1); $i>=0; $i--)
           {
               preg_match_all('#сегодня в (.*)\:(.*)#',$article[1][$i], $match);
               preg_match_all('#вчера в (.*)\:(.*)#',$article[1][$i], $match2);
               preg_match_all('# в (.*)\:(.*)#',$article[1][$i], $match3);
               if($match[0])
               {
                   if($match[1][0] == 00)
                   {
                       $hour = 24;
                       $time = Article::getNewDate(1, 0, 0, $hour, $match[2][0]);
                   }
                   else
                   {
                       $time = Article::getNewDate(0, 0, 0, $match[1][0], $match[2][0]);
                   }
               }
               elseif($match2[0])
               {
                   $time = Article::getNewDate(1, 0, 0, $match2[1][0], $match2[2][0]);
               }
               elseif($match3[0])
               {
                   $time = Article::getNewDate(2, 0, 0, $match3[1][0], $match3[2][0]);
               }

               $check_time=Article::orderBy('id', 'desc')->where('id_section', '=', $id->id)->first();

               if($check_time)
               {
                   if ($time > $check_time->time && $time > $id->check_time)
                   {
                       $new_article = new Article();
                       $new_article->name = $article[2][$i];
                       $new_article->rus_name = $article[4][$i];
                       $new_article->time = $time;
                       $new_article->id_section = $id->id;
                       $new_article->save();

                       $my_section = Chapter::where('section', '=', $id->id)->get();
                       foreach ($my_section as $my)
                       {
                           $bind = new Bind();
                           $bind->id_user = $my->user;
                           $bind->id_section = $id->id;
                           $bind->id_article = $new_article->id;
                           $bind->save();
                       }
                   }
               }
               elseif(!$check_time && $article[2][0] == $article[2][$i])
               {
                   $new_article = new Article();
                   $new_article->name = $article[2][0];
                   $new_article->rus_name = $article[4][0];
                   $new_article->time = $time_new;
                   $new_article->id_section = $id->id;
                   $new_article->save();
               }
            }
            $id->check_time=$time_new;
            $id->update();
         }
        }
       }
       });
       DB::transaction(function()
       {
        $time_day = Article::getNewDate(1);

        $old_articles=Bind::where('id_user', '=', Auth::user()->id)->where('read', '=', 1)->where('time', '!=', 0)
            ->where('special_article', '=', 0)->get();



        if(!empty($old_articles))
        {
        foreach($old_articles as $old)
        {
            if($time_day>$old->time)
            {
                $old->delete();
            }
        }
        }
        $all_articles = Article::all();
        foreach($all_articles as $old)
        {
            $search_bind = Bind::where('id_article', '=', $old->id)->first();
            $check_bind=Bind::where('id_section', '=', $old->id_section)->first();
            $check_last=Article::where('id_section', '=', $old->id_section)->count();
            if(!$search_bind && $check_last>1 && $check_bind)
            {
                $old->delete();
            }
        }
        $search_bind = Bind::where('id_article', '=', $old->id)->first();


        $section_day=Section::where('rus_name', '=', '')->first();
        if($time_day>$section_day->check_time)
        {
            $file='';
            $str='http://habrahabr.ru/hubs/';
            $that=file_get_contents($str);
            preg_match_all("#<li><a href=\"/hubs/(.*?)/\">(.*?)</a></li>#i", $that, $count);

            for($r=1; $r<(count($count[2])+2); $r++)
            {
                if($r==1)
                {
                    $url='http://habrahabr.ru/hubs/';
                    $file.=file_get_contents($url);
                }
                else
                {
                    $url='http://habrahabr.ru/hubs/page'.$r.'/';
                    $file.=file_get_contents($url);
                }
            }
            preg_match_all("#\<div class=\"habraindex\">(.*?)\</div>\s+\<div class=\"info\">\s+\<div class\=\"title\">\s+\<a href\=\"http\://habrahabr\.ru/hub/(.*?)/\"\>(.*?)\</a>#i", $file, $out);

            $time = Article::getNewDate();

            $section_day->check_time=$time;
            $section_day->update();

            for($i=0;$i<count($out[0]);$i++)
            {
                $search_section = Section::where('name', '=', $out[2][$i])->first();

                //если такого раздела еще нет создаем
                if(!$search_section)
                {
                    $section_new=new Section();
                    $section_new->statistic=str_replace(' ', '', $out[1][$i]);
                    $section_new->name=$out[2][$i];
                    $section_new->rus_name=$out[3][$i];
                    $section_new->check_time=$time;
                    $section_new->save();
                }
                else
                {
                    //если есть обновляем рейтинг
                    $search_section->statistic=str_replace(' ', '', $out[1][$i]);
                    $search_section->update();
                }
            }
        }
       });



        $all_new_articles=Bind::where('id_user', '=', Auth::user()->id)->where('read', '=', 0)
            ->where('special_article', '=', 0)->get();
        if(!isset($all_new_articles))
        {
            return json_encode('bad');
        }
        else
        {
            foreach($all_new_articles as $key)
            {
                $value[]=$key->id_section;
            }
            $count=array_count_values($value);

            $ceil = array();
            foreach($count as $count_key => $count_val)
            {
                $mess ='';
                $all_new_articles=Bind::where('id_user', '=', Auth::user()->id)->where('read', '=', 0)
                    ->where('special_article', '=', 0)->where('id_section', '=', $count_key)->get();
                foreach($all_new_articles as $new)
                {
                    $art_links = Article::where('id', '=', $new->id_article)->first();
                    $mess.='<li id="'.$count_key.'"><a id="art_link" class="ui-btn" href="http://habrahabr.ru/'.$art_links->name.'/" data-info="'
                        .$art_links->id.'" target="_blank" onclick="read('.$art_links->id.')">'.$art_links->rus_name.'</a>
                <a  id="favorite" href="" class="ui-btn" title="Добавить в избранное"  onclick="tab('.$art_links->id.')">
                    <span id="'.$art_links->id.'sec" class="glyphicon glyphicon-star-empty"/></a></li>';
                }
                $ceil[$count_key] = array('count' => $count_val, 'articles' => $mess);
            }


		    return Response::json($ceil);
        }
	}

	/**
	 * Show the form for creating a new article
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('articles.create');
	}

	/**
	 * Store a newly created article in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	/*
        $input=Input::get('link');

        $day=date('d');
        $month=date('m');
        $year=date('Y');
        $hour=date('H');
        $minutes=date('i');
        $date = new \DateTime();
        $date->setTime($hour, $minutes);
        $date->setDate($year, $month, $day);
        $date->setTimezone(new \DateTimeZone('Europe/Moscow'));
        $time_new=$date->getTimestamp();

        //проверяем и удаляем все рзделы что уже были но не выбраны этого пользователя
        foreach($input as $key=>$val)
        {
            $section=Section::where('name', '=', $key)->first();
            $check=Chapter::where('section', '=', $section->id)->where('user', '=', Auth::user()->id)->first();

            //тут проверяем есть пользователь с таким разделом и если нет то записывем
            if(!$check)
            {
                $check_new=Chapter::where('section', '=', $section->id)->first();
                //если такого раздела в этой таблице ваще нет ни у одного пользователя то добавляем новое время в таблицу
                //Section для того что бы статьи начинали проверяться с этого момента а не с момента создания всех разделов
                if(!$check_new)
                {
                   $section->check_time=$time_new;
                   $section->update();
                }
                $my_section=new Chapter();
                $my_section->user=Auth::user()->id;
                $my_section->section=$section->id;
                $my_section->old=1;  //доп поле чтобы можн было проще удалять старые ненужные разделы
                //но может быть так накладнее вначале прописывать все новые под 1 и после ставить снова на 0 чтоб удалить хз даж
                $my_section->save();
            }
            else
            {
                $check->user=Auth::user()->id;
                $check->section=$section->id;
                $check->old=1;
                $check->update();
            }
        }
        //над удалить связи из bind с главой которая не выбрана
        $delete_old=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 0)->get();
        foreach($delete_old as $del)
        {
            $del_bind = Bind::where('id_section', '=', $del->section)->delete();
        }
        $delete_chapters=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 0)->delete();

        $new_old=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 1)->get();
        foreach($new_old as $key)
        {
            $key->old=0;
            $key->update();
        }


		return Redirect::to('/');*/
	}

	/**
	 * Display the specified article.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$binds = Bind::where('id_user', '=', Auth::user()->id)->where('read', '=', 1)
            ->where('special_article', '=', 0)->get();
        $articles=array();
        $sections=array();
        $messages = [];
        foreach($binds as $bind)
        {
            $ready=Article::where('id', '=', $bind->id_article)->first();
            $articles[$ready->name]=array('id' => $ready->id, 'name' => $ready->rus_name, 'section' => $bind->id_section);

            $select[$bind->id_section]=$bind->id_section;  //ищу в бд после чтоб увеличить скорость
        }
        if(isset($select))
        {
        foreach($select as $key)
        {
            $val = Section::where('id', '=', $key)->first();
            $sections[$val->id] = $val->rus_name;
        }
        }

        if (empty($articles))
        {
            $messages[0] = 'К сожалению новых статей в данном разделе еще нет';
        }

        return View::make('articles.show', compact('sections', 'articles', 'messages'));
	}


    public function read()
    {
        //вопрос тут один если прервется раньше времени аякс то хм оно не прочтется?
        $time = Article::getNewDate();


        $bind = Bind::where('id_user', '=', Auth::user()->id)->where('id_article', '=', Input::get('art'))->first();
        //удаляем статью через сутки с этим id
        $bind->read=1;
        $bind->time=$time;
        $bind->update();

        //ищем эти же статьи в других разделах и удаляем (зачем нам по 10 раз смотреть одно и то же)
        $article = Article::where('id', '=', Input::get('art'))->first();
        //ищу по имени такие же статьи с другим разделом
        $article_all = Article::where('name', '=', $article->name)->get();
        foreach($article_all as $key)
        {
            //удаляем все связи с этим id статьи кроме той по которой щелкнули
            $del_all = Bind::where('id_article', '=', $key->id)->where('id_article', '!=', Input::get('art'))->delete();
        }

        return Response::json('good');
    }


    public function favorite_ajax()
    {
        $bind=Bind::where('id_article', '=', Input::get('art'))->first();
        $bind->special_article=1;
        $bind->update();
        return Response::json('good');
    }

    public function favorite()
    {
        if(Auth::check())
        {
        $binds = Bind::where('id_user', '=', Auth::user()->id)->where('id_article', '!=', 0)
                        ->where('special_article', '=', 1)->get();
        $articles=array();
        $messages = [];
        foreach($binds as $bind)
        {
            $ready=Article::where('id', '=', $bind->id_article)->first();
            $articles[$ready->name]=array('id' => $ready->id, 'name' => $ready->rus_name);
        }
        if (empty($articles)) $messages[0] = 'К сожалению в данный момент у вас нет выбранных статей в данном разделе';
        }
        else
        {
            return Redirect::to('sections/show');
        }
        return View::make('articles.favorite', compact('articles', 'messages'));
    }

   public function deleteFavorite()
   {
       $delete_bind = Bind::where('id_user', '=', Auth::user()->id)->where('id_article', '=', Input::get('art'))
            ->where('special_article', '=', 1)->delete();
       return Response::json('good');
   }


    public function delFavForm()
    {
        $input = Input::get('fav');
        $one_input = Input::get('art');
        if(isset($input))
        {
        foreach($input as $key => $val)
        {
            $delete_binds = Bind::where('id_user', '=', Auth::user()->id)->where('id_article', '=', $key)
                    ->where('special_article', '=', 1)->delete();
        }
        }
        elseif(isset($one_input))
        {
            echo $one_input;
            $delete_bind = Bind::where('id_user', '=', Auth::user()->id)->where('id_article', '=', Input::get('art'))
                ->where('special_article', '=', 1)->delete();
        }
        //return Redirect::back();
    }
	/**
	 * Show the form for editing the specified article.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = Article::find($id);

		return View::make('articles.edit', compact('article'));
	}

	/**
	 * Update the specified article in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$article = Article::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Article::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$article->update($data);

		return Redirect::route('articles.index');
	}

	/**
	 * Remove the specified article from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Article::destroy($id);

		return Redirect::route('articles.index');
	}

}
