<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controller\Frontend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Frontend
{

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->auth = Auth::customer();

		$this->middleware('guest', ['except' => 'getLogout']);

        $this->loadLayout();
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		return view('customer.login');
	}

    public function getConfirm($code)
    {
        if($this->auth->confirmByCode($code)){

            \Message::addSuccess(trans('account.alerts.confirmation'));
        } else{

            \Message::addError(trans('account.alerts.wrong_confirmation'));
        }

        return redirect('/customer/login');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect('/');
    }

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister()
	{
		return view('customer.register');
	}

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
        workflow('new_customer')->handle($request->all());

        return redirect('/customer/login');
	}

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        workflow('existing_customer')->handle($request->all());

        return redirect('/customer/login');
    }
}
