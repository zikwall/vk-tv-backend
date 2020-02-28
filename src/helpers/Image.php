<?php

namespace zikwall\vktv\helpers;

class Image
{
    public static function base64ToJPEG( $base64String, $outputFile ) {
        $ifp = fopen( $outputFile, "wb" );
        fwrite( $ifp, base64_decode( $base64String) );
        fclose( $ifp );
        return( $outputFile );
    }
}