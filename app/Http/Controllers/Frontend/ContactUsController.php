<?php

namespace App\Http\Controllers\Frontend;

use App\Events\ContactSubmitted;
use App\Events\NotifyManagementEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Repositories\ContactRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;


class ContactUsController extends Controller
{
    public function index()
    {
        $businessSettings = SettingRepository::getAllBusinessSettings();
        $addressSetting        = $businessSettings->where('type', 'Address')->first();
        $supportMailSetting    = $businessSettings->where('type', 'Support Mail')->first();
        $supportContactSetting = $businessSettings->where('type', 'Support Contact')->first();
        $settings = app('shared_data')['settings'];
        $socialLinks = [];
        if (!empty($settings['Social Links'])) {
            $socialLinks = $settings['Social Links']->data;
            if (is_string($socialLinks)) {
                $socialLinks = json_decode($socialLinks);
            }
        }

        return \Inertia\Inertia::render('Contact', [
            'support' => [
                'address' => $this->settingValue($addressSetting),
                'email' => $this->settingValue($supportMailSetting),
                'phone' => $this->settingValue($supportContactSetting),
            ],
            'socialLinks' => $socialLinks,
        ]);
    }

    public function store(ContactRequest $request)
    {
        $contact = ContactRepository::storeContact($request);
        if ($contact) {

            $receiverIds = null;
            $senderId = null;
            $subject = "New Contact Message Received";
            $body = "You have received a new contact message from {$request->name}. Please check the admin panel for more details.";
            // Notification
            NotifyManagementEvent::dispatch(
                $receiverIds,
                $senderId,
                $subject,
                $body
            );

            // Conforamtion Mail 
            // ContactSubmitted::dispatch($contact);
            return back()->with('success', 'Poruka je uspešno poslata.');
        }
        return back()->with('error', 'Nešto je pošlo po zlu. Pokušajte ponovo.');
    }

    private function settingValue($setting): ?string
    {
        $data = $setting?->data ?? null;

        if (is_string($data)) {
            $data = json_decode($data);
        }

        if (is_array($data)) {
            return $data['value'] ?? null;
        }

        return $data?->value ?? null;
    }
}
