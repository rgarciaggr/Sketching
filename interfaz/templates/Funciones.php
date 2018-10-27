<?php

/**
 * Description of funciones
 *
 * @author Roberto
 */
class Funciones {
    //funciones estaticas


    public static function showImageProfile($image, $root)
    {
    
        if($image === '../profile_images/profile_' || $image === 'interfaz/profile_images/profile_' || $image === '/interfaz/profile_images/profile_' || $image === '../../interfaz/profile_images/profile_'){
            $image = $root . "interfaz/app_images/profile-alt.png";
        }
        return $image;
    }

    public static function removeDirectory($path)
    {
        $path = rtrim( strval( $path ), '/' ) ;
        $d = dir( $path );
        if( ! $d )
            return false;
        while ( false !== ($current = $d->read()) )
        {
            if( $current === '.' || $current === '..')
                continue;
            $file = $d->path . '/' . $current;
            if( is_dir($file) )
                self::removeDirectory($file);
            if( is_file($file) )
                unlink($file);
        }
        rmdir( $d->path );
        $d->close();
        return true;
    }
    
}
