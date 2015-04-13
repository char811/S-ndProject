<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent implements UserInterface, RemindableInterface {

    public static $validation = array(

        'username'  => 'required|alpha_num|min:3|max:13',
        'email' => 'required|email',
        'password'  => 'required|alpha_num|min:6|max:20',
        'password_confirmation'  => 'required|alpha_num|min:6|max:20|confirm',

    );


    public static $messages = array(
        'username.required' => 'Имя обязательное поле',
        'username.min' => 'Имя должно содержать хотя бы 3 символа',
        'username.max' => 'Имя не может содержать больше 13 символа',
        'username.alpha_num' => 'Имя может состоять только и букв и цифр',
        'email.required' => 'Email обязательное поле',
        'email.email' => 'Введите правильный эмейл',
        'password.min' => 'Пароль должен содержать хотя бы 6 символов',
        'password.max' => 'Пароль не может быть больше 20 символов',
        'password_confirmation.min' => 'Пароль 2 должен содержать хотя бы 6 символов',
        'password_confirmation.max' => 'Пароль 2 не может быть больше 20 символов',
        'password.alpha_num' => 'Пароль может состоять только и букв и цифр',
        'password_confirmation.alpha_num' => 'Пароль 2 может состоять только и букв и цифр',
        'password.required' => 'Пароль обязательное поле',
        'password_confirmation.required' => 'Пароль 2 обязательное поле',
    );

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
//    protected $username = 'admin';

	protected $table = 'users';

    protected $hidden = array('password');
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */


    protected $fillable = array('username', 'email', 'password', 'created_date');


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }
    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

}