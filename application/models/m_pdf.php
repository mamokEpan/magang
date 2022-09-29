<?php


class m_pdf extends CI_Model 
{
	// public $table = 'daftar_mhs';
 //    public $id = 'id';
 //    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

	
    function get_data($id_mhs,$nama_Ayah){
        
        $get_nama=$this->db->get_where('data_orang_tua',array('id_mhs' => $id_mhs))->result();
        foreach ($get_nama as $nama) {
            return $nama->$nama_Ayah;
        }

    
    }
    function get_prov(){
        $get_nama=$this->db->get('provinces')->result();
        
            return $get_nama;
            
        
    }

    function get_all(){
        $get_nama=$this->db->get('daftar_mhs')->result();
        
            return $get_nama;
        
    }
}