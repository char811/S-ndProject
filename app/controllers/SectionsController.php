<?php

class SectionsController extends \BaseController {

	/**
	 * Display a listing of sections
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Auth::check())
        {
		$sections_all = Section::where('id', '>', 1)->first();
        $temp = '';
        $temp_last = array();

        if($sections_all==null)
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
            preg_match_all("#\<div class=\"habraindex\">(.*?)\</div>\s+\<div class=\"info\">\s+\<div class\=\"title\">
            \s+\<a href\=\"http\://habrahabr\.ru/hub/(.*?)/\"\>(.*?)\</a>#i", $file, $out);

            $time = Article::getNewDate();

            $first_time = Section::where('name', '=', 'check_time_for_every_day')->first();
            if(!$first_time)
            {
            $section_time=new Section();
            $section_time->name='check_time_for_every_day';
            $section_time->check_time=$time;
            $section_time->save();
            }
            for($i=0;$i<count($out[0]);$i++)
            {
                $section_new=new Section();
                $section_new->statistic=str_replace(' ', '', $out[1][$i]);
                $section_new->name=$out[2][$i];
                $section_new->rus_name=$out[3][$i];
                $section_new->check_time=$time;
                $section_new->save();
            }
            $sections=Section::all();
            foreach($sections as $section)
            {
                 $temp_last[] = array('checked' => 0 , 'link' => $section->rus_name, 'name' => $section->name);
            }
        }
        else
        {
            $sections=Section::orderBy('statistic', 'desc')->where('rus_name', '!=', '')->get();
            $any_sections=Chapter::where('user', '=', Auth::user()->id)->first();

            if(!$any_sections)
            {
                foreach($sections as $section)
                {
                      $temp_last[] = array('checked' => 0 , 'link' => $section->rus_name, 'name' => $section->name);
                }
            }
            else
            {
                $self = '';
                $my_sections = Chapter::where('user', '=', Auth::user()->id)->get();

                 foreach ($my_sections as $key)
                {
                    $search=Section::where('id', '=', $key->section)->first();
                    $need_sections[]=$search->name;
                    $self .= '|||'.$search->name.'|||';
                }
                foreach ($sections as $section)
                {
                    foreach ($need_sections as $my)
                    {
                        $link = $section->rus_name;
                        $name = $section->name;

                        if ($my == $name)
                        {
                            $preg = '#(.*?)('.$name.')(.*?)#';
                            preg_match($preg, $temp, $match);
                            if (!$match)
                            {
                                $temp .= $link.$name.'checked';
                                $temp_last[] = array('checked' => 1 , 'link' => $link, 'name' => $name);
                            }
                        }
                        else
                        {
                            $preg = '#(.*?)('.$name.')(.*?)#';

                            preg_match($preg, $temp, $match);
                            preg_match($preg, $self, $match2);

                            if (!$match && !$match2)
                            {
                                $temp .= $link.$name;
                                $temp_last[] = array('checked' => 0 , 'link' => $link, 'name' => $name);
                            }
                        }
                    }
                }
            }
        }

		return View::make('sections.index', compact('temp', 'temp_last'));
        }
        else
        {
            return Redirect::to('sections/show');
        }
	}



    /*
     * Main page
     */

    public function my_section()
    {
        $sections=array();
        $messages = [];
        if (Auth::check())
        {
            $binds = Chapter::orderBy('section', 'asc')->where('user', '=', Auth::user()->id)->get();
            foreach ($binds as $bind)
            {
                $ready = Section::where('id', '=', $bind->section)->first();
                $sections[$ready->id] = $ready->rus_name;
            }
            if (empty($sections)) $messages[0] = 'К сожалению новых разделов у вас еще нет';
        }
        else
        {
            if (empty($sections)) $messages[0] = 'Войдите если хотите жить!';
        }

        return View::make('sections.show', compact('sections', 'messages'));
    }


	public function create()
	{
		return View::make('sections.create');
	}

	/**
	 * Store a newly created section in storage. and delete old
	 *
	 * @return Response
	 */
	public function store()
	{
        $input=Input::get('link');

        $time_new = Article::getNewDate();

        foreach($input as $key=>$val)
        {
            $section=Section::where('name', '=', $key)->first();
            $check=Chapter::where('section', '=', $section->id)->where('user', '=', Auth::user()->id)->first();

            if(!$check)
            {
                $check_new=Chapter::where('section', '=', $section->id)->first();

                if(!$check_new)
                {
                    $section->check_time=$time_new;
                    $section->update();
                }
                $my_section=new Chapter();
                $my_section->user=Auth::user()->id;
                $my_section->section=$section->id;
                $my_section->old=1;
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

        $delete_old=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 0)->get();
        foreach($delete_old as $del)
        {
            $del_bind = Bind::where('id_section', '=', $del->section)->where('id_user', '=', Auth::user()->id)->delete();
        }
        $delete_chapters=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 0)->delete();

        $new_old=Chapter::where('user', '=', Auth::user()->id)->where('old', '=', 1)->get();
        foreach($new_old as $key)
        {
            $key->old=0;
            $key->update();
        }


        return Redirect::to('/');
	}

	public function show($id)
	{
		$section = Section::findOrFail($id);

		return View::make('sections.show', compact('section'));
	}

	public function edit($id)
	{
		$section = Section::find($id);

		return View::make('sections.edit', compact('section'));
	}

	public function update($id)
	{
		$section = Section::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Section::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$section->update($data);

		return Redirect::route('sections.index');
	}

	public function destroy($id)
	{
		Section::destroy($id);

		return Redirect::route('sections.index');
	}

}
