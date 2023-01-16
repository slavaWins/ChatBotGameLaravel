<?php

    namespace App\Models;

    class ResponseApi
    {
        function Test($msg = "Bad request data") {
            return $msg;
        }


        public static function Error($msg = "Bad request data", $status = 201) {
            return response()->json(['message' => $msg, 'error'=>$msg], $status);
        }

        //for ajax
        public static function Data($data = true) {
            return response()->json(["response" => $data, "error" => false,], 200);
        }

        public static function Successful($data = ['successful' => true]) {
            //$data['successful'] = true;
            return response()->json($data, 200);
        }

    }