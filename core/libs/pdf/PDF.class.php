<?php

/**
 * Description of PDF
 *
 * @author Marcio Bigolin <marcio.bigolinn@gmail.com>
 * @version 1.0
 * @package 
 */
class PDF extends mPDF
{

    public function __construct()
    {
        parent::__construct();
        //define('_MPDF_TTFONTPATH', CACHE . '/ttfonts/');
        //define('_MPDF_TTFONTDATAPATH', CACHE . '/templates_c/');
    }

}
