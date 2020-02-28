<?php

namespace zikwall\vktv\helpers;

class Image
{
    public static function base64ToJPEG( $base64String, $outputFile )
    {
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64String );

        $filenamePath = md5(time().uniqid()).".jpg";
        //$decoded = base64_decode($base64String);
        file_put_contents($outputFile, $data);

        return $filenamePath;
    }
}