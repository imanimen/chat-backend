<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Cache;

class UserRepository implements UserInterface
{
    public function getAuthUser($token)
    {
        return 2; // TODO: changed for testing the mark as read job
    //    return Cache::remember('auth_user_'.$token, 120, function() use ($token){
            $url = env('CLUB_SERVICE_URL').'/Check';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: '.$token,
                // 'Content-Type: Application/json',
            ));
            dd($ch);
            $response = curl_exec($ch);
            // dd($response);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            // if ($code == 200) {
            //     $user =  Cache::remember('user_info_'.$token, 200, function() use ($response) {
            //         $res = json_decode($response);
            //         return $response;
            //     });
            //     return $user ?? null;
            // } else {
            //     return $response;
            // }
    //    });
        
    }

    public function getUser($id)
    {
        return 2;
        return Cache::remember('auth_user_'.$id, 120, function() use ($id){
             $url = env('CLUB_SERVICE_URL').'/Single?id='.$id;
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, $url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                //  'Authorization: '.$token,
                 'Content-Type: Application/json',
             ));
             $response = curl_exec($ch);
             $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             curl_close($ch);
             
             if ($code == 200) {
                 $user =  Cache::remember('user_info_'.$id, 200, function() use ($response) {
                     // $res = json_decode($response);
                     return $response;
                 });
                 return $user ?? null;
             } else {
                 return $response;
             }
        });
         
    }
}
