<?php

class BindsController extends \BaseController {

	/**
	 * Display a listing of binds
	 *
	 * @return Response
	 */
	public function index()
	{
		$binds = Bind::all();

		return View::make('binds.index', compact('binds'));
	}

	/**
	 * Show the form for creating a new bind
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('binds.create');
	}

	/**
	 * Store a newly created bind in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Bind::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Bind::create($data);

		return Redirect::route('binds.index');
	}

	/**
	 * Display the specified bind.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bind = Bind::findOrFail($id);

		return View::make('binds.show', compact('bind'));
	}

	/**
	 * Show the form for editing the specified bind.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bind = Bind::find($id);

		return View::make('binds.edit', compact('bind'));
	}

	/**
	 * Update the specified bind in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$bind = Bind::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Bind::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bind->update($data);

		return Redirect::route('binds.index');
	}

	/**
	 * Remove the specified bind from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Bind::destroy($id);

		return Redirect::route('binds.index');
	}

}
