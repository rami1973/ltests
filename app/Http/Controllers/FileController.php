<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon ;
use Illuminate\Http\Response;


class FileController extends Controller
{
    //
    public function getFile($filename)
	{
        $disk = Storage::disk('oci');

$file = $disk->temporaryUrl('images/'.$filename, now()->addMinutes(1));
return (new Response('',301,['Location' => $file]));

     }
}
