<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    protected function json(string $message = null, $data = null, $statusCode = 200, array $headers = [])
    {
        $content = [];

        if ($message) {
            $content['message'] = $message;
        }

        $content['data'] = $data;


        return response()->json($content, $statusCode, $headers, JSON_PRESERVE_ZERO_FRACTION);
    }

    protected function setEnv(string $key, $value): bool
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $value = $value ?? '';

            if (preg_match('/\s/', $value) || preg_match('/[^\w@.-]/', $value)) {
                $value = '"' . $value . '"';
            }
            if (strpos($str, "{$key}=") === false) {
                $str .= "{$key}={$value}\n";
            } else {
                $str = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $str);
            }
            $str = rtrim($str) . "\n";
            file_put_contents($envFile, $str);

            return true;
        } catch (Exception $e) {
            Log::error("Error updating environment variable {$key}: " . $e->getMessage());
            return false;
        }
    }


    // function to update .env file safely
    protected function setSmsEnv($key, $value): bool
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);

            $value = $value ?? '';
            if (preg_match('/\s/', $value)) {
                $value = '"' . $value . '"';
            }
            if (strpos($str, "{$key}=") === false) {

                $str .= "{$key}={$value}\n";
            } else {
                $str = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $str);
            }
            file_put_contents($envFile, $str);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
