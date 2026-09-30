<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\Profile\NotificationResource;
use App\Http\Resources\Profile\TransactionSummaryResource;
use App\Http\Resources\Profile\TranscationHistoryResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\NotificationHistoryRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Dedoc\Scramble\Attributes\BodyParameter;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\PathParameter;

#[Group('Profile')]
class ProfileController extends Controller
{
    /**
     * Shwo Profile
     *
     */
    public function index()
    {
        $myProfileData = UserRepository::query()->with('profilePhoto')->find(auth()->id());

        return $this->json("Profile Fetch Sucessfully", UserResource::make($myProfileData) , 200);
    }



    /**
     * Update Profile
     *
     */

    #[BodyParameter('name', required: true, type: 'string', example: 'Shakil Ahsan')]
    #[BodyParameter('email', required: true, type: 'string', example: 'shakil@example.com')]
    #[BodyParameter('whatsapp_number', required: false, type: 'string', example: '017XXXXXXXX')]
    #[BodyParameter('address', required: false, type: 'string', example: 'Dhaka, Bangladesh')]
    #[BodyParameter('latitude', required: false, type: 'string', example: '23.8103')]
    #[BodyParameter('longitude', required: false, type: 'string', example: '90.4125')]
    #[BodyParameter('profile_photo', required: false, type: 'file', example: "flower.jpg")]

    public function update(ProfileUpdateRequest $request)
    {
        try {
            $updatedUser = UserRepository::updateProfile($request, auth()->id());
            return $this->json("Profile Update Successfully", [], 200);
        } catch (\Exception $e) {

            return $this->json("Profile Update Failed", [
                "error" => $e->getMessage()
            ], 422);
        }
    }
}
