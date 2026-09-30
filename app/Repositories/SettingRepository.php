<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Enums\Seting;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingRepository extends Repository
{
    public static function model()
    {
        return Setting::class;
    }


    public static function updateImageSetting($type, $request, $fileInputName, $storageFolder, $jsonKey)
    {
        $setting = self::query()->where('type', $type)->first();
        if (!$setting || !$request->hasFile($fileInputName)) {
            return $setting ?? null;
        }
        $oldData = json_decode($setting->data ?? '{}', true);
        $oldImagePath = $oldData[$jsonKey] ?? null;

        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        $newImagePath = $request->file($fileInputName)->store($storageFolder, 'public');
        $newImageURL = Storage::url($newImagePath);
        /** @var \App\Models\Setting $setting */
        $setting->update([
            'data' => json_encode([
                $jsonKey => $newImageURL
            ])
        ]);

        return $setting;
    }

    public static function updateAdditionalSetting($type, $value)
    {
        $setting = self::query()->where('type', $type)->first();
        $data = ['data' => json_encode(['value' => $value])];
        if ($setting) {
            self::update($setting, $data);
        } else {
            $setting = self::create([
                'type' => $type,
                'data' => json_encode(['value' => $value])
            ]);
        }
        return $setting;
    }

    public static function updateDownloadLinks($type, $request)
    {
        $setting = self::query()->where('type', $type)->first();

        // Merge existing data with new data
        if ($setting) {
            $existingData = json_decode($setting->data, true) ?? [];

            if (isset($existingData['thumbnail1']) && !isset($request['thumbnail1'])) {
                $request['thumbnail1'] = $existingData['thumbnail1'];
            }
            if (isset($existingData['thumbnail2']) && !isset($request['thumbnail2'])) {
                $request['thumbnail2'] = $existingData['thumbnail2'];
            }

            $setting = self::update($setting, ['data' => json_encode($request)]);
        } else {
            $setting = self::create(['type' => $type, 'data' => json_encode($request)]);
        }
        return $setting;
    }



    public static function updateMailSetting($type, $data)
    {
        $setting = self::query()->where('type', $type)->first();
        if ($setting) {
            self::update($setting, ['data' => json_encode($data)]);
        } else {
            $setting = self::create(['type' => $type, 'data' => json_encode($data)]);
        }
        return $setting;
    }

    public static function updateSmsSetting($type, $data)
    {
        $smsConfig = self::query()->where('type', $type)->first();
        self::update($smsConfig, ['data' => json_encode($data)]);
        return $smsConfig;
    }


    // ------public static function getAllBusinessSettings-------------//

    public static function getAllBusinessSettings()
    {
        $businessSettings = self::getAll();
        foreach ($businessSettings as $setting) {
            $setting->data = json_decode($setting->data);
        }
        return $businessSettings;
    }


    public static function updateBusinessSettings($request)
    {
        $currencySetting = self::query()->where('type', Seting::Currency->value)->first();
        // Prepare JSON data
        $dataArray = [
            'currency' => $request->currency,
            'symbol' => $request->currency_symbol,
            'position' => $request->currency_position,
        ];

        $jsonData = json_encode($dataArray);

        if ($currencySetting) {
            // Update existing
            /** @var \App\Models\Setting $currencySetting */
            $currencySetting->data = $jsonData;
            $currencySetting->save();
            Cache::forget('currency_setting');
        } else {
            // Create new
            self::create([
                'type' => Seting::Currency->value,
                'data' => $jsonData,
            ]);
        }



        // Update GST
        $gstSetting = self::query()->where('type', 'GST')->first();
        $gstData = ['data' => json_encode([
            'type' => $request->gst_type,
            'value' => $request->gst_value,
        ])];
        if ($gstSetting) {
            /** @var \App\Models\Setting $gstSetting */
            $gstSetting->update($gstData);
        } else {
            self::create(['type' => 'GST', 'data' => $gstData['data']]);
        }

        // Update Tax
        $taxSetting = self::query()->where('type', 'Tax')->first();
        $taxData = ['data' => json_encode([
            'type' => $request->tax_type,
            'value' => $request->tax_value,
        ])];
        if ($taxSetting) {
            /** @var \App\Models\Setting $taxSetting */
            $taxSetting->update($taxData);
        } else {
            self::create(['type' => 'Tax', 'data' => $taxData['data']]);
        }
    }

    //This c-Symbol
    public static function getCurrencySetting()
    {
        return Cache::rememberForever('currency_setting', function () {
            $currencySetting = self::query()
                ->where('type', Seting::Currency->value)
                ->first();

            return $currencySetting
                ? json_decode($currencySetting->data)
                : null;
        });
    }


    public static function getByType($type)
    {
        return self::query()->where('type', $type)->first();
    }

    //This Method is for COLORS
    public static function updateByRequest(Setting $setting, $request)
    {
        $data = [
            'primary_color'   => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'text_color'      => $request->text_color,
            'font_family'     => $request->font_family,
        ];

        return self::update($setting, [
            'data' => json_encode($data),
        ]);
    }



    // New Code For Footer Section----------------------------------------------------
    public static function updateSubtitleByRepo($request)
    {
        $updates = [
            Seting::FooterSubtitle->value   => $request->footer_subtitle,
            Seting::FooterCopyright->value  => $request->footer_copyright,
        ];

        foreach ($updates as $type => $value) {
            self::query()
                ->where('type', $type)
                ->update(['data' => json_encode(['value' => $value])]);
        }
        return true;
    }



    public static function updateSocialLinks($type, $request)
    {
        $data = $request->social_links ?? [];
        $socialLinks = self::query()->where('type', $type)->first();

        if ($socialLinks) {
            /** @var \App\Models\Setting $socialLinks */
            $socialLinks->update([
                'data' => json_encode($data)
            ]);
            return $socialLinks;
        }

        return null;
    }



    public static function updateFooterInfomation($request)
    {
        $updates = [
            Seting::Address->value         => $request->address,
            Seting::SupportMail->value     => $request->support_mail,
            Seting::SupportCantact->value  => $request->support_contact,
        ];

        foreach ($updates as $type => $value) {
            $setting = self::query()->where('type', $type)->first();
            $data = ['data' => json_encode(['value' => $value])];

            if ($setting) {
                self::update($setting, $data);
            } else {
                self::create(['type' => $type, 'data' => $data['data']]);
            }
        }

        return true;
    }


    public static function updateFooterMenuOrder($cards)
    {
        $setting = self::query()->where('type', Seting::FooterMenuOrder->value)->first();
        $data = ['data' => json_encode(['cards' => $cards])];

        if ($setting) {
            self::update($setting, $data);
        } else {
            self::create(['type' => Seting::FooterMenuOrder->value, 'data' => $data['data']]);
        }

        return $setting;
    }
}
