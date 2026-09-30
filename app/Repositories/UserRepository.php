<?php

namespace App\Repositories;

use App\Models\User;
use Abedin\Maker\Repositories\Repository;
use App\Enums\UserStatus;
use App\Events\NotifyManagementEvent;
use App\Events\UserRegistered;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\password;

class UserRepository extends Repository
{
    public static function model()
    {
        return User::class;
    }
    // Get sidebar counts
    public static function getByStatus($status = null, $search = null, $perPage = 10)
    {
        return self::query()
            ->withTrashed()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString(); // keeps filters and pagination working
    }


    public static function countByStatus($status = null)
    {
        return self::query()->when($status, function ($query) use ($status) {
            return  $query->where('status', $status);
        })->count();
    }

    public static function getTrashed()
    {
        return User::onlyTrashed()->get();
    }



    //--------------------------[ frontend-registration ]--------------]
    protected $userVerifyRepository;

    public function __construct(UserVerifyRepository $userVerifyRepository)
    {
        $this->userVerifyRepository = $userVerifyRepository;
    }

    public static function register($request)
    {
        if ($request->provider) {
            return self::socialRegister($request);
        }

        $user = self::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone_no" => $request->phone_no,
            "password" => Hash::make($request->password),
            'status' => UserStatus::Approve->value,
        ]);

        // Initial variables
        $receiverIds = null;
        $senderId = $user->id;
        $subject = "New User Registered";
        $body = "A new user {$user->name} just registered!";

        // Start Notification
        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );

        $user->assignRole('User');
        return $user;
    }

    private static function socialRegister($request)
    {
        $user = self::query()->updateOrCreate([
            'provider' => $request->provider,
            'provider_id' => $request->socialId,
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'provider_img_url' => $request->image_url,
            'password' => bcrypt(Str::random(16))
        ]);

        if (!$user->hasRole('User')) {
            $user->assignRole('User');
        }
        return $user;
    }

    public static function generateOtp($email)
    {
        $user = self::query()->where('email', $email)->first();
        if ($user) {
            UserVerifyRepository::query()->where('user_id', $user->id)->delete();
            $otp = UserVerifyRepository::createOtp($user->id, $user->email);
            UserRegistered::dispatch($user, $otp);

            if (config('app.env') === 'local') {
                session(['otp' => $otp]);
            }
            return $otp;
        }
        return null;
    }

    // Resend OTP
    public static function resendOTP(Request $request)
    {
        $contact = $request->contact;
        if (!$contact) return null;

        $user = filter_var($contact, FILTER_VALIDATE_EMAIL)
            ? self::query()->where('email', $contact)->first()
            : self::query()->where('phone_no', $contact)->first();

        if (!$user) return null;

        UserVerifyRepository::query()->where('user_id', $user->id)->delete();
        $otp = UserVerifyRepository::createOtp($user->id, $contact);
        UserRegistered::dispatch($user, $otp);

        if (config('app.env') === 'local') {
            session(['otp' => $otp]);
        }

        return $user;
    }

    public static function sendPhoneOtp($contact)
    {
        //
    }

    public static function verifyOTP(Request $request)
    {
        $contact = $request->contact;
        $otp = $request->otp;

        $verify = UserVerifyRepository::query()->where('contact', $contact)
            ->where('otp', $otp)
            ->first();

        if ($verify) {
            $user = self::find($verify->user_id);
            if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                $user->email_verified_at = now();
            } else {
                $user->phone_verified_at = now();
            }

            $user->save();
            $verify->delete();
            session()->forget('otp');
            session()->forget('email');
            return true;
        }else{
            return false;
        }

    }


    //Profile Update
    public static function updateProfile($request, $id)
    {
        $user = self::findOrFail($id);

        $user->name            = $request->name;
        $user->phone_no        = $request->phone_no;
        $user->email           = $request->email;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->address         = $request->address;
        $user->latitude        = $request->latitude;
        $user->longitude       = $request->longitude;

        if ($request->hasFile('profile_photo')) {
            $media = MediaRepository::updateByRequest($user, $request->file('profile_photo'), 'profile');
            $user->profile_photo_id = $media->id;
        }

        $user->save();

        // Initial variables
        $receiverIds = $id;
        $senderId = $id;
        $subject = "Profile Update";
        $body = "Your profile has been updated";

        // Start Notification
        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );

        return $user;
    }

    //Change Pawword
    public static function updatePassword($id, $newPassword)
    {
        $user = self::find($id);
        $user->password = Hash::make($newPassword);
        $user->save();

        $user = auth()->user();
        $receiverIds = $user->id;
        $senderId = $user->id;
        $subject = "Password Update";
        $body = "Your password has been updated";

        // Start Notification
        NotifyManagementEvent::dispatch(
            $receiverIds,
            $senderId,
            $subject,
            $body
        );
    }

    // User Soft Delte
    public static function softDelete($id)
    {
        $user = self::find($id);
        $user->delete();
    }

    public static function getUserByContact($contact)
    {
        return self::query()
            ->where('email', $contact)
            ->orWhere('phone_no', $contact)
            ->first();
    }

    public static function rewritePassword($userId, $password)
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($password);
        $user->save();

        return true;
    }


    public static function getUsersByDateRange($range, $request)
    {
        return self::query()
            ->when($range == 'today', fn($q) => $q->whereDate('created_at', Carbon::today()))
            ->when($range == 'yesterday', fn($q) => $q->whereDate('created_at', Carbon::yesterday()))
            ->when($range == 'last_7_days', fn($q) => $q->whereBetween('created_at',[Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()]))                                                                                 // Last 7 days
            ->when($range == 'last_30_days', fn($q) => $q->whereBetween('created_at',[Carbon::now()->subDays(29)->startOfDay(), Carbon::now()->endOfDay()]))                                                                                 // Last 30 days
            ->when($range == 'custom' && $request->filled(['start_date','end_date']), fn($q) => $q->whereBetween(
                'created_at',
                [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]
            ))->orderByDesc('created_at')->get();
    }


    public static function getDateRangeTitle($range, $request)
    {
       return match($range) {
            'today' => 'Today - ' . Carbon::today()->format('d M Y'),
            'yesterday' => 'Yesterday - ' . Carbon::yesterday()->format('d M Y'),
            'last_7_days' => 'Last 7 Days (' . Carbon::now()->subDays(6)->format('d M Y') . ' - ' . Carbon::now()->format('d M Y') . ')',
            'last_30_days' => 'Last 30 Days (' . Carbon::now()->subDays(29)->format('d M Y') . ' - ' . Carbon::now()->format('d M Y') . ')',
            'custom' => $request->filled(['start_date', 'end_date'])
                ? Carbon::parse($request->start_date)->format('d M Y') . ' - ' . Carbon::parse($request->end_date)->format('d M Y')
                : 'Custom Range',
            default => 'All Time',
        };
    }


    public static function getReportStats($users)
    {
        return [
            'total' => $users->count(),
            'approved' => $users->where('status', UserStatus::Approve->value)->count(),
            'pending' => $users->where('status', UserStatus::Pending->value)->count(),
            'blocked' => $users->where('status', UserStatus::Block->value)->count(),
            'verified' => $users->filter(function ($user) {
                return $user->email_verified_at || $user->phone_verified_at;
            })->count(),
        ];
    }


    // Forget Password - OTP Send
    public static function sendForgetOTP($contact)
    {
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
        if($isEmail){
            return self::generateOtp($contact);
        } else {
            return self::sendPhoneOtp($contact);
        }
    }

    //Change Pawword
    public static function resetPassword($id, $newPassword)
    {
        $user = self::find($id);
        $user->password = Hash::make($newPassword);
        $user->save();
    }
}
