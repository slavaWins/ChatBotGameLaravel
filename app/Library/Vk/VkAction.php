<?php

namespace App\Library\Vk;

use App\Http\Controllers\Vk\VkController;
use App\Library\Structure\StatStructure;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VkAction
{
    public static function DocsSave($file, $fileName)
    {
        $request_params = [
            'access_token' => VkController::token,
            'file' => $file,
            'title' => $fileName,
            'tags' => "voice",
            'v' => '5.131',
        ];


        $response = Http::asForm()->post('https://api.vk.com/method/docs.save', $request_params);
        //if($response->status()<>)
        $data = $response->body();
        $data = json_decode($data, true);


        return $data['response']['audio_message']['id'];
    }

    public static function GetMessagesUploadServer($vk_uid)
    {
        $request_params = [
            'type' => 'audio_message',
            'peer_id' => $vk_uid,
            'access_token' => VkController::token,
            'v' => '5.131',
        ];
        // Log::info($request_params);


        $response = Http::asForm()->post('https://api.vk.com/method/docs.getMessagesUploadServer', $request_params);
        $data = $response->body();

        $data = json_decode($data, true);

        $serverUrl = $data['response']['upload_url'];
        return $serverUrl;
    }

    public static function UploadVoicemessage($vk_uid, $souLocal)
    {
        $serverUrl = self::GetMessagesUploadServer($vk_uid);

        $path = public_path("sound/" . $souLocal);

        if (!file_exists($path)) return null;

        $file = file_get_contents($path);

        $response = Http::attach('file', $file, $souLocal)->post($serverUrl, []);
        $data = $response->body();

        $data = json_decode($data, true);

        $fileId = $data['file'];

        $res = self::DocsSave($fileId, $souLocal);


        return $res;
    }

    public static function SendMessage($vkid, $text, $buttons, $soundUpload = null)
    {
        //  self::GetMessagesUploadServer($vkid);

        if (!empty($soundUpload)) {
            $text .="\n\n 🔄 Загрузка аудиосообщения...";
        }

        $request_params = [
            'message' => $text ,
            'peer_id' => $vkid,
            'access_token' => VkController::token,
            'v' => '5.103',
            'random_id' => '0',
            'keyboard' => [
                'one_time' => false,
                'inline' => false,
                'buttons' => [],
            ],
        ];




        if (!empty($buttons)) {

            $row = 0;
            $count = 0;
            $request_params['keyboard']['buttons'] = [];
            $request_params['keyboard']['buttons'][0] = [];


            foreach ($buttons as $K => $V) {
                if ($count == 3) {
                    $row++;
                    $count = 0;
                }
                $count += 1;
                $request_params['keyboard']['buttons'][$row][] = [
                    'color' => 'secondary',
                    'action' => [
                        'type' => 'text',
                        'payload' => '{"button": "1"}',
                        'label' => $K,
                    ],
                ];
            }

            // $request_params['buttons']=[$request_params['buttons']];

        }

        $request_params['keyboard'] = json_encode($request_params['keyboard'], JSON_UNESCAPED_UNICODE);
        $response = Http::asForm()->post('https://api.vk.com/method/messages.send', $request_params);


        if (!empty($soundUpload)) {
            $request_params['message'] = '';
            unset($request_params['keyboard']);
            $uploadRes = self::UploadVoicemessage($vkid, $soundUpload);
            $request_params['attachment'] = 'audio_message' . $vkid . '_' . $uploadRes;
            $response = Http::asForm()->post('https://api.vk.com/method/messages.send', $request_params);
        }

    }
}


