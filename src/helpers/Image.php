<?php

namespace zikwall\vktv\helpers;

class Image
{
    public static function base64ToJPEG( $base64String, $directory )
    {
        $filePath = sprintf('%s/%s.jpg', $directory, UUID::v4());

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

        return $filePath;
    }
}