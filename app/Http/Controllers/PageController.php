<?php

namespace App\Http\Controllers;

// use App\User;
use App\Http\Controllers\Controller;
use PDF;
// use PDF;

class PageController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

     /*
     1. php artisan vendor:publish
     2. enable php in config (file /config/dompdf)
     */ 
    public function pdf()
    {
        $param = NULL;
        $param['title'] = 'page';
        // return view('page.pdf', $param);

        // $pdf = PDF::loadView('page.pdf');
        // // $pdf->set_option('','');
        // // return $pdf->download('invoice.pdf');
        // return $pdf->stream('invoice.pdf');
        // die;

        // $pdf->render();
        // return $pdf->stream('invoice.pdf');

        // -------------------------
        // $options = new Options(); 
        // $options->set('isPhpEnabled', TRUE);

        // $dompdf = new Dompdf($options);
        // $dompdf->load('page.pdf');
        // $dompdf->render();
        // $dompdf->stream();

        //-------------------------
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('page.pdf', $param);
        // $pdf->render();
    //    return  $pdf->stream();
        return $pdf->stream('invoice.pdf');

    }

    public function login ()
    {
        // echo "hello login";
        // die;
        if ($_POST) {
            $post = NULL;
            $post = $_POST;
            var_dump($post);
            die;
        }

        $param = NULL;
        $param['CONTENT'] = view('page.login');
        return view('index',$param);
    }
}