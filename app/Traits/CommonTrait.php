<?php

namespace App\Traits;
use Mail;


trait CommonTrait
{   


 



    public function PushNotificationAndroid($device_token,array $msg, array $data)
    {
        
        
     $content = array(
        "en" => $msg['body']
        );

        $fields = array(
          'app_id' => "4175ccac-b26f-4be2-9749-bb0cc5836b9a",
          'include_player_ids' => array($device_token),
          'data' => array("foo" => "bar"),
          'contents' => $content
      );

      $fields = json_encode($fields);
     

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

      $response = curl_exec($ch);
      if ($response === FALSE) 

            {

              \Log::info(curl_error($ch));
                   // die('FCM Send Error: ' . curl_error($ch));

            }
    

            curl_close($ch);

    }


    public function getTimeLapse($ptime)
    {
      $etime = time() - strtotime($ptime);

    if ($etime < 50)
    {
        return 'Just Now';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
    }

}