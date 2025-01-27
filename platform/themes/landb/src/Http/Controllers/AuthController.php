<?php

namespace Theme\Landb\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\ACL\Traits\AuthenticatesUsers;
use Botble\ACL\Traits\LogoutGuardTrait;
use Botble\Ecommerce\Models\Customer;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use SeoHelper;
use Symfony\Component\HttpFoundation\Response;
use Theme;
use URL;

/*use Botble\Theme\Http\Controllers\PublicController;*/

class AuthController extends Controller
{
    use AuthenticatesUsers, LogoutGuardTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    /*public $redirectTo;*/

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('customer.guest', ['except' => 'logout']);
        session(['url.intended' => URL::previous()]);
        $this->redirectTo = session()->get('url.intended');
    }

    public function showLoginForm()
    {
        SeoHelper::setTitle(__('Login'));

        Theme::breadcrumb()->add(__('Home'), url('/'))->add(__('Login'), route('customer.login'));

        return Theme::scope('auth.login', [], 'plugins/ecommerce::themes.customers.login')->render();
    }

    public function showRegisterForm()
    {
        SeoHelper::setTitle(__('Register'));

        Theme::breadcrumb()->add(__('Home'), url('/'))->add(__('Login'), route('customer.login'));

        return Theme::scope('auth.register', [], 'plugins/ecommerce::themes.customers.register')->render();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return auth('customer');
    }

    public function checkOldLoginCredentials($email, $password)
    {
        $post_data = array(
            'email'    => $email,
            'password' => $password,
        );
        $post_data = json_encode($post_data);
        $token = base64_encode('amir@landbapparel.com:6sHei1lh9D3ixRMR43L265fat481bJwD');
        $header = array(
            'Authorization:Basic ' . $token . '',
            'Content-Type: application/json'
        );

        // Prepare new cURL resource
        $crl = curl_init('http://dev.landbw.co/api/usertoken');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
        // Set HTTP Header for POST request
        curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Submit the POST request
        $result = curl_exec($crl);

        // Close cURL session handle
        curl_close($crl);

        return $result != false ? json_decode($result) : false;
    }

    /**
     * @param Request $request
     * @return Response|void
     * @throws ValidationException
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $checkOld = Customer::where('email', $email)->value('old_customer');

        if ($checkOld) {
            $res = $this->checkOldLoginCredentials($email, $password);
            if ($res && isset($res->token)) {
                $pwd = bcrypt($password);
                Customer::where('email', $email)->update(['old_customer' => 0, 'password' => $pwd]);
                $request->password = $pwd;
            }
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $activeGuards = 0;
        $this->guard()->logout();

        foreach (config('auth.guards', []) as $guard => $guardConfig) {
            if ($guardConfig['driver'] !== 'session') {
                continue;
            }
            if ($this->isActiveGuard($request, $guard)) {
                $activeGuards++;
            }
        }

        if (!$activeGuards) {
            $request->session()->flush();
            $request->session()->regenerate();
        }

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function process_signup(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'name'     => trim($request->input('name')),
            'email'    => strtolower($request->input('email')),
            'password' => bcrypt($request->input('password')),
        ]);

        session()->flash('message', 'Your account is created');

        return redirect()->route('login');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->update(['last_visit' => Carbon::now()]);
    }

    public function forgetPassword(){
      return Theme::scope('auth.forget-password', [])->render();
    }

    public function postForgetPassword(Request $request)
    {

        $request->validate(['email' => 'required|email|exists:ec_customers']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

      /*return back()->with('message', 'We have e-mailed your password reset link!');*/
    }

    public function resetPassword($token){
        return Theme::scope('auth.reset-password', ['token' => $token])->render();
    }

    public function postResetPassword(Request  $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user['old_customer'] = 0;
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('customer.login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
