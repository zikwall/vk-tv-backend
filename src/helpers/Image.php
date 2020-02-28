<?php

namespace zikwall\vktv\helpers;

class Image
{
    public static function base64ToJPEG( $base64String, $directory, $compress = true, $compressQuality = 75 )
    {
        $filename = UUID::v4();
        $filePath = sprintf('%s/%s.jpg', $directory, $filename);

        // open the output file for writing
        $ifp = fopen( $filePath, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64String );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        if ($compress) {
            static::compress($filePath, $filePath, $compressQuality);
        }

        return $filename;
    }

    public static function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        else
            $image = imagecreatefromjpeg($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }
}