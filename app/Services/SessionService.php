<?php

namespace App\Services;


use App\Parametro;

class SessionServices
{
    /**
     * @param $target
     */
    public function delete_files($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
            foreach ($files as $file) {
                self::delete_files($file);
            }
        } elseif (is_file($target)) {
            if (is_file($target))
                unlink($target); // delete file
        }
    }


    public function updateSession($type)
    {
        $obj = Parametro::where('codigo', 'MANTENIMIENTO_WEB')->first();
        $obj->descripcion = $type;
        $obj->save();
        $this->delete_files('storage/framework/sessions');
    }

}