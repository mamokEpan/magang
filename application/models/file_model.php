<?php


class file_model extends CI_Model 
{
	// public $table = 'daftar_mhs';
 //    public $id = 'id';
 //    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_data_prov()
    {
      $prov = $this->db->query("SELECT COUNT('id_mhs') AS jumlah,name_prov
                    FROM provinces,data_orang_tua,daftar_mhs,regencies 
                    WHERE provinces.id= data_orang_tua.provinsi
                    AND data_orang_tua.id_mhs = daftar_mhs.id 
                    AND regencies.id = data_orang_tua.kab 
                    AND status_aktif=1 GROUP BY name_prov;");
        //untuk menampilkan nama provinsi dan jumlah mahasiswa yang aktif
          if($prov->num_rows() > 0){ 
            foreach($prov->result() as $data){
                $hasil[] = $data;  
        }
            return $hasil;
        }
        
    }
    
    function get_data_kab()
    {

        $kab = $this->db->query("SELECT COUNT('id_mhs') AS jumlahkab, name_kab, name_prov
                    FROM provinces,data_orang_tua,daftar_mhs,regencies 
                    WHERE provinces.id= data_orang_tua.provinsi 
                    AND data_orang_tua.id_mhs = daftar_mhs.id 
                    AND regencies.id = data_orang_tua.kab 
                    AND provinces.id= regencies.province_id
                    AND status_aktif='1' group by name_kab order by name_prov 
            ");
                    
          //untuk menampilkan nama kabupaten dan jumlah mahasiswa yang aktif
          if($kab->num_rows() > 0){
            foreach($kab->result() as $datakab){
                $hasilkab[] = $datakab;
            }
            return $hasilkab;
        }
    }
    function get_data_fak()
    {
      $fak = $this->db->query("SELECT COUNT('id_mhs') AS jumlahfak,nama_fakultas
                    FROM fakultas,daftar_mhs,jurusan 
                    WHERE fakultas.id= daftar_mhs.fakultas
                    AND jurusan.id = daftar_mhs.jurusan 
                    AND status_aktif=1 GROUP BY nama_fakultas;");
   
          if($fak->num_rows() > 0){ 
            foreach($fak->result() as $data){
                $hasil[] = $data;  
        }
            return $hasil;
        }
        
    }
    
    function get_data_jur()
    {
        $jur = $this->db->query("SELECT COUNT('id_mhs') AS jumlahjur, nama_jurusan, nama_fakultas
                    FROM fakultas,daftar_mhs,jurusan 
                    WHERE fakultas.id= daftar_mhs.fakultas
                    AND jurusan.id = daftar_mhs.jurusan
                    AND status_aktif='1' GROUP BY nama_jurusan ORDER BY nama_fakultas
            ");
                    
         
          if($jur->num_rows() > 0){
            foreach($jur->result() as $datajur){
                $hasiljur[] = $datajur;
            }
            return $hasiljur;
        }
    }
    function get_data_tp()
    {
        $query = $this->db->query("SELECT tgl_pembayaran,SUM(jumlah_pembayaran) AS jumlah_pembayaran FROM pembayaran GROUP BY tgl_pembayaran");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
    }


}
}
