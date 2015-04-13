<?php
use Artdarek\OAuth\Facade\OAuth;

class UsersController extends \BaseController {

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('users.index');
	}

    public function migrate()
    {
        if(Input::get('migrate') == "appSetup_key"){
            try {
                Artisan::call('migrate', array('--force' => true));
            } catch (Exception $e) {
                Response::make($e->getMessage(), 500);
            }
        }else{
            App::abort(404);
        }
    }
	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
     *
     * scrolling page
	 */
	public function create()
	{
        return View::make('users.show');
	}

    public function registration()
    {
        return View::make('users.registration');
    }
	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make($data = Input::all(), User::$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::where('username', '=', Input::get('username'))->first();
        if (!$user) {
            $user = new User();
        }
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->save();

        echo "Вы успешно зарегистрировались...Выберите разделы по которым вы хотите получать уведомления о новых статьях";

        return Redirect::to('/');
    }

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
     *
	 */
	public function show()
	{
	}

    public function login()
    {
        $name = array('username' => Input::get('username'), 'password' => Input::get('password'));

        if (Auth::attempt($name, Input::has('remember')))
        {
            return Redirect::to('/');
        }
        $alert = "Ты явно не тот за кого себя выдаеш а ну кыш пока не подхватил вирусняка!";

        return Redirect::back()->withAlert($alert);
    }


    /*
     * this oAuth2 working but not in Crimea
     */
    public function loginWithGoogle() {

        // get data from input
        $code = Input::get( 'code' );

        $googleService = OAuth::consumer( 'Google', 'http://chirikdesigns.hol.es/oauth2callback' );

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            $search=User::where('username', '=', $result['name'])->where('email', '=', $result['email'])->first();
            if(!$search)
            {
                $user=new User();
                $user->username=$result['name'];
                $user->email=$result['email'];
                $user->password=Hash::make($result['id']);
                $user->social_name='Google';
                $user->save();
            }

            $name = array('username' => $result['name'], 'password' => $result['id']);
            if(Auth::attempt($name))
            {
                    return Redirect::to('/');
            }
            $alert = "Ты явно не тот за кого себя выдаеш а ну кыш пока не подхватил вирусняка!";

            return Redirect::back()->withAlert($alert);

        }
        // if not ask for permission first
        else {

            $url = $googleService->getAuthorizationUri();
            return Redirect::to( (string)$url );

        }
    }




    public function getLogout()
    {
         Auth::logout();

         return Redirect::to('/');
    }

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return View::make('users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('users.index');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		return Redirect::route('users.index');
	}

}
