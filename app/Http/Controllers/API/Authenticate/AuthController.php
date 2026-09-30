<?php

namespace App\Http\Controllers\API\Authenticate;

use App\Enums\UserStatus;
use App\Events\NotifyManagementEvent;
use App\Helper\WishlistHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\emailVeryfyRequest;
use App\Http\Requests\OTPVerifyRequest;
use App\Http\Requests\OTPVerifyApiRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

#[Group('Authentication API')]
class AuthController extends Controller
{
    /**
     * Registration
     *
     */

    #[BodyParameter('name', required: true, type: 'string', example: 'Fahim Hossain Munna')]
    #[BodyParameter('email', required: true, type: 'string', example: 'user@example.com')]
    #[BodyParameter('phone_no', required: true, type: 'string', example: '017**********')]
    #[BodyParameter('password', required: true, type: 'string', example: 'Pas$w0rd')]
    public function register(UserRegistrationRequest $request)
    {
        $user = UserRepository::register($request);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return $this->json('Registration successful', [
            'user'    => UserResource::make($user),
            'token'   => $token,
            'token_type' => 'Bearer ',
        ]);
    }

    /**
     * Login
     *
     */
    #[BodyParameter('contact', required: true, type: 'string', example: 'phone number(017*****)/email address(user@example.com)')]
    #[BodyParameter('password', required: true, type: 'string', example: 'Pas$w0rd')]



    public function login(UserLoginRequest $request): JsonResponse
    {
        $contact = $request->input('contact');
        $password = $request->input('password');


        $field = filter_var($contact, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_no';

        $user = UserRepository::query()->where($field, $contact)->first();

        if (!$user) {
            return $this->json('User not found', [
                'errors' => ['contact' => ['No user found with this credentials.']]
            ], 404);
        }

        // Check password
        if (!Hash::check($password, $user->password)) {
            return $this->json('The provided credentials are invalid.', [
                'errors' => ['contact' => ['The provided credentials are invalid.']]
            ], 401);
        }


        // Create API token
        $token = $user->createToken('mobile-app')->plainTextToken;

        return $this->json('Login successful', [
            'user'        => UserResource::make($user),
            'token'       => $token,
            'token_type'  => 'Bearer',
        ], 200);
    }




    /**
     * EmailVeryfy
     *
     */
    #[BodyParameter('contact', required: true, type: 'string', example: 'email address(user@example.com)')]

    public function submitEmail(emailVeryfyRequest $request)
    {
        $contact = $request->contact;

        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $otp = UserRepository::generateOtp($contact);
            $type = 'email';
        } else {
            $otp = UserRepository::sendPhoneOtp($contact);
            $type = 'phone';
        }

        if ($otp) {
            if (config('app.env') === 'local') {
                return $this->json('OTP Sent Successfull', [
                    'otp' => $otp,
                    'type' => $type,
                ]);
            }

            return $this->json('OTP Sent Successfull', null, 200);
        }

        return $this->json('otp not sent', null, 200);
    }

    /**
     * OTPVerify
     *
     */
    #[BodyParameter('otp', required: true, type: 'string', example: '5566')]
    #[BodyParameter('contact', required: true, type: 'string', example: 'email address(user@example.com)')]

    public function verifyOtp(OTPVerifyApiRequest $request)
    {
        $result = UserRepository::verifyOTP($request);

        if ($result) {
            return $this->json('OTP verified successfully', null, 200);
        }

        return $this->json('Invalid OTP. Please try again or resend OTP', null, 200);
    }

    /**
     * Resend OTP
     */
    #[BodyParameter('contact', required: true, type: 'string', example: 'email address(user@example.com)')]
    public function resendOtp(Request $request)
    {
        $contact = $request->contact;

        // Determine if contact is email or phone
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $otp = UserRepository::generateOtp($contact);
            $type = 'email';
        } else {
            $otp = UserRepository::sendPhoneOtp($contact);
            $type = 'phone';
        }

        if (!$otp) {
            return $this->json("{$type} not found", null, 404);
        }

        // For local environment, show OTP for debugging
        if (config('app.env') === 'local') {
            return $this->json('OTP Sent Successfully', [
                'otp' => $otp,
                'type' => $type,
            ]);
        }

        // Production response
        return $this->json('A new OTP has been sent to your contact.', [], 200);
    }


    /**
     * Password Change
     *
     */
    #[BodyParameter('current_password', required: true, type: 'string', example: 'Pas$w0rd')]
    #[BodyParameter('password', required: true, type: 'string', example: 'Pas$w0rd')]

    public function changePassword(PasswordChangeRequest $request)
    {
        UserRepository::updatePassword(Auth::id(), $request->password);
        return $this->json('Password changed successfully', null, 200);
    }

    /**
     * Delete Account
     *
     */
    #[BodyParameter('agree', required: true, type: 'string', example: 'yes')]

    public function deleteAccount(DeleteAccountRequest $request)
    {
        $user = Auth::user();

        $user->tokens()->delete();
        $userId = $user->id;

        // Soft delete the user
        UserRepository::softDelete($userId);

        // Notify management
        $receiverIds = null; // Or admin IDs
        $senderId = $userId;
        $subject = "An Account is Deleted";
        $body = "An Account is deleted, User Name: " . $user->name;

        NotifyManagementEvent::dispatch($receiverIds, $senderId, $subject, $body);

        return $this->json('Account deleted successfully', null, 200);
    }

    /**
     * Logout
     *
     */

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Delete the current token
            $user->currentAccessToken()->delete();

            return $this->json('Logout successful', null, 200);
        }

        return $this->json('User not authenticated', null, 401);
    }


    /**
     * Forget Password (Send OTP)
     */
    #[BodyParameter('contact', required: true, type: 'string')]
    public function forgetPassword(emailVeryfyRequest $request)
    {
        $contact = $request->contact;

        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $otp = UserRepository::generateOtp($contact);
            $type = 'email';
        } else {
            $otp = UserRepository::sendPhoneOtp($contact);
            $type = 'phone';
        }

        if (!$otp) {
            return $this->json("{$type} not found", null, 404);
        }

        // Show OTP in local environment
        if (config('app.env') === 'local') {
            return $this->json('OTP Sent Successfully', [
                'otp' => $otp,
                'type' => $type,
            ]);
        }

        return $this->json("OTP sent to your {$type}", null, 200);
    }



    /**
     * Verify OTP for Reset Password
     */
    #[BodyParameter('contact', required: true, type: 'string')]
    #[BodyParameter('otp', required: true, type: 'string')]
    public function verifyResetOtp(OTPVerifyApiRequest $request)
    {


        $result = UserRepository::verifyOTP($request);

        if (!$result) {
            return $this->json('Invalid OTP. Please try again.', null, 400);
        }

        return $this->json('OTP verified successfully. You may now reset your password.');
    }


    /**
     * Reset Password (After OTP Verified)
     */
    #[BodyParameter('contact', required: true, type: 'string')]
    #[BodyParameter('password', required: true, type: 'string')]
    public function resetPassword(Request $request)
    {
        $request->validate([
            'contact' => 'required',
            'password' => 'required|min:6'
        ]);

        $contact = $request->contact;
        $user = UserRepository::getUserByContact($contact);

        if (!$user) {
            return $this->json('User not found', null, 404);
        }

        UserRepository::rewritePassword($user->id, $request->password);

        return $this->json('Password reset successful. You may now login.', null, 200);
    }
}
