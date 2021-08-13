<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Crypt;

class ImageService
{
    public function path($value)
    {
        switch ($value) {
            case 0:
                $path = 'images/perfiles';
                break;
            case 1:
                $path = 'images/capture-pagos';
                break;
            default:
                $path = 'images';
                break;
        }
        return $path;
    }
    public static function handleUploadedImage($image,$data,$value)
    {
        $instancia = new ImageService;
        $path = $instancia->path($value);

        if(!is_null($image)){
            $extension = $image->extension();

            if($value == 1){
                $image->storeAs($path, $data->id.'.'.$extension);
            }else if($value == 0){
                $image->move(public_path($path),$data->id.'.'.$extension);
            }
            
            $response = $data->id.'.'.$extension;

        }else{
            $response = $data->photo;
        }
        return $response;
    }

    public static function downloadImage($data,$value)
    {
        $instancia = new ImageService;
        $path = $instancia->path($value);
        $url = false;
        if(!is_null($data->capture_pago)){
            $url = storage_path('app/').$path.'/'.$data->capture_pago;
        }
        return $url;

    }

    public static function downloadImageButton($load)
    {
        $id = Crypt::decrypt($load);
        $button = '<a type="button" href="'.route('downloadpay',Crypt::encrypt($id)).'"
        class="btn btn-success btn-sm"><i class="fa fa-cloud-download"></i> Descargar</a>';
        return $button;

    }
}
