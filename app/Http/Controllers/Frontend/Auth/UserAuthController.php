<?php
namespace App\Http\Controllers\Frontend\Auth;

use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotSetPasswordRequest;
use App\Http\Requests\OTPVerifyRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\UserForgotPassRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{

    //show Registration form
    public function showRegistration()
    {
        return \Inertia\Inertia::render('Auth', [
            'mode' => 'register',
        ]);
    }

    // Register Here
    public function registration(UserRegistrationRequest $request)
    {
        $user = UserRepository::register($request);
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Registration Successfull');
    }

    //Showing Login Form
    public function showLogin()
    {
        if (url()->previous() !== url()->current()) {
            session(['url.intended' => url()->previous()]);
        }

        return \Inertia\Inertia::render('Auth', [
            'mode' => 'login',
        ]);
    }

    public function login(UserLoginRequest $request): RedirectResponse
    {
        $contact  = $request->input('contact');
        $password = $request->input('password');
        $user     = UserRepository::getUserByContact($contact);

        if (! $user || ! Hash::check($password, $user->password)) {

            return back()->withErrors([
                'contact' => 'The provided credentials are invalid.',
            ])->onlyInput('contact');
        }
        // Login the user
        Auth::login($user);
        return redirect()->route('home')->with('login_success', 'You are successfully logged in!');
    }

    // Show Fixed Email Page foge for OTP - with passing Email
    public function showVerify()
    {
        $email = Auth::user()->email;
        return view('web.auth.otp-submit-email', ['email' => $email]);
    }

    public function submitEmail(Request $request)
    {
        $contact = $request->contact;

        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $user = UserRepository::generateOtp($contact);
            $type = 'email';
        } else {
            $user = UserRepository::sendPhoneOtp($contact);
            $type = 'phone';
        }

        if ($user) {
            return response()->json([
                'success' => "OTP {$type} sended",
            ]);
        }

        return response()->json([
            'errors' => [
                'contact' => "{$type} Not found।",
            ],
        ], 422);
    }

    //Showing OTP Submit Page
    public function showVerifyOtp()
    {
        $email = session('email', Auth::user()->email);
        return view('web.auth.otp-submit', ['email' => $email]);
    }

    // Verify OTP code, that we submitted in
    public function verify(OTPVerifyRequest $request)
    {
        $result = UserRepository::verifyOTP($request);

        if ($result === true) {
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP. Please try again or resend OTP.',
        ], 422);
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $user = UserRepository::resendOTP($request);
        if ($user) {
            return response()->json(['success' => 'A new OTP has been sent to your contact.']);
        }
        return response()->json(['errors' => ['contact' => 'Contact not found.']], 422);
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flash('logout_success', 'You are successfully logged out!');
        return redirect()->route('home')->with('success', 'Logout successful!');
    }

    //delete Account
    public function showDeleteAccount()
    {
        return view('web.profile.sections.delete-account');
    }

    // Deleting
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'agree' => 'required|accepted',
        ]);

        if (auth()->user()?->getRoleNames()->contains('Admin')) {

            return back()->with('error', 'Admin account can\'t be deleted!');
        }
        UserRepository::softDelete(Auth::id());

        $receiverIds = null;
        $senderId    = auth()->id();
        $subject     = "An Account is Deleted";
        $body        = "An Accoutn is deleted, User Name is " . auth()->user()->name;

        // Start Notification
        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );

        Auth::logout();
        return redirect()->route('home')->with('success', 'Account is deleted');
    }

    // Change Password
    public function changePasswordindex()
    {
        return view('web.profile.sections.change-password');
    }

    //Change Password
    public function changePassword(PasswordChangeRequest $request)
    {
        UserRepository::updatePassword(Auth::id(), $request->password);
        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    // Forget Password
    public function forgotIndex()
    {
        return view('web.auth.user-forgot-password');
    }

    public function forgotUpdate(UserForgotPassRequest $request)
    {
        $otp = UserRepository::sendForgetOTP($request->contact);

        if ($otp) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Contact not found',
        ], 404);
    }

    public function verifyForgotOtp(Request $request)
    {
        $request->validate([
            'contact' => 'required',
            'otp'     => 'required',
        ]);

        $result = UserRepository::verifyOTP($request);
        if ($result) {
            session(['password_reset_contact' => $request->contact]);
            return redirect()->route('user.forgot.password.reset')
                ->with('success', 'OTP verified! Reset your password.');
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    public function setResetPassword()
    {
        return view('web.auth.user-forgot-reset-from');
    }

    public function storeResetPassword(ForgotSetPasswordRequest $request)
    {
        $contact = session('password_reset_contact');
        if (! $contact) {
            return redirect()->route('user.forgot.password')
                ->with('error', 'Please Try Again');
        }
        $user = UserRepository::getUserByContact($contact);
        UserRepository::resetPassword($user->id, $request->password);
        session()->forget('password_reset_contact');
        return redirect()->route('home')->with('success', 'Password reset successful!');
    }
}
