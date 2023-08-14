<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use PDF;


class PdfController extends Controller

{

    public function graphs()

    {

        return view('graph');

    }


    // function to generate PDF

    public function graphPdf()

    {

        $pdf = \PDF::loadView('graph');

        $pdf->setOption('enable-javascript', true);

        $pdf->setOption('javascript-delay', 5000);

        $pdf->setOption('enable-smart-shrinking', true);

        $pdf->setOption('no-stop-slow-scripts', true);

        return $pdf->download('graph.pdf');

    }

}



