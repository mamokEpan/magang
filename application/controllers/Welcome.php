<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
         $this->load->model('file_model');
         $this->load->library('cetak_pdf');
		
	}
     private static $title = "Asrama UIR";
    function grafikwilayah(){
        $data = array(
            'data' => $this->file_model->get_data_prov(),
            'kab' => $this->file_model->get_data_kab()
        );
        $data['title'] = "KP ".self::$title;
        $data['content'] = "page/vgrafik_wilayah";
       $this->load->view('page/index',$data);

    }
    
}