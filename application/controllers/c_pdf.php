<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_pdf extends CI_Controller {

	function __construct(){
		parent::__construct();
       
         $this->load->model('m_pdf');
         $this->load->model('file_model');
         $this->load->library('cetak_pdf');
		
	}
      private static $title = "Asrama UIR";

    function grafik_wilayah(){
        $data = array(
            'data' => $this->file_model->get_data_prov(),
            'kab' => $this->file_model->get_data_kab()
        );
        $data['title'] = "KP ".self::$title;
        $data['content'] = "page/vgrafik_wilayah";
       $this->load->view('page/index',$data);

    }
    function grafik_fakultas()
    {
        $data = array(
            'data' => $this->file_model->get_data_fak(),
            'jur' => $this->file_model->get_data_jur()
        );
        $data['title'] = "KP ".self::$title;
        $data['content'] = "page/vgrafik_fakultas";
        $this->load->view('page/index',$data);
    }
    function grafik_tunggakan_pembayaran()
    {
        $data['data'] = $this->file_model->get_data_tp();
        $data['title'] = "KP ".self::$title;
        $data['content'] = "page/vgrafik_tp";
        $this->load->view('page/index',$data);
    }
    function datatabel()
    {
        
       $mhs = $this->m_pdf->get_all();

        $data = array(
            'mhs_data'     => $mhs,
            'DB'           => $this->db
        );

        $data['title'] = "KP ".self::$title;
        $data['content'] = "page/data_mhs";
        $this->load->view('page/index',$data);

    }
   
    function pdf($id)
    {

        $get_id=$this->db->get_where('daftar_mhs',array('id'=>$id))->result();
        
        foreach ($get_id as $npm) {
            
        
         error_reporting(0);
       $pdf = new FPDF('P', 'mm','A4');
        $pdf->AddPage();
        $pdf->SetMargins(40,40,30);
        $pdf->SetLeftMargin(40);
        $pdf->Image(base_url('assets/uir.jpg'),165,10,25,22); //kiri x , bawah y , lebar, tinggi
        $pdf->Image(base_url('assets/uir.jpg'),30,10,25,22);
        //kop
        $pdf->Cell(0,0,'',0,1,'C');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(0,5,'YAYASAN LEMBAGA PENDIDIKAN ISLAM (YLPI)',0,1,'C'); // left, space, text, border, vertikal (0) horizontal (1), Center
        //$pdf->Cell(25);
        $pdf->Cell(0,5,'UNIVERSITAS ISLAM RIAU',0,1,'C');
        //$pdf->Cell(25);
        $pdf->Cell(0,5,'ASRAMA AL-MUNAWWARAH',0,1,'C');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,5,'"Asrama Tahfizh dan Ilmu-Ilmu Al-Quran"',0,1,'C');
        //$pdf->Cell(25);
        $pdf->SetFont('Times','',8);
        $pdf->Cell(0,5,'Jl. Kaharuddin Nasution No.113. Hp 081281167972, 082277186704 Kode Pos 28284 Marpoyan, Pekanbaru, Riau',0,1,'C');
        //line
        //$pdf->Cell(0,5,'',0,1,'C');
        $pdf->SetLineWidth(0);
        $pdf->Line(36,36,184,36,'C'); //x left , up/-down, y right, up/-down
        $pdf->SetLineWidth(1);
        $pdf->Line(36,37,184,37,'C');
        //end line
        //end kop

        $pdf->Cell(0,5,'',0,1,'C');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'DATA MAHASISWA',0,1,'C');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PENGHUNI ASRAMA AL-MUNAWWARAH UIR',0,0,'C');
    
        $pdf->SetFont('Times','B',8);
        $pdf->SetLineWidth(0);
        $pdf->Cell(-15,0,'',0,0,'L');
        $pdf->Cell(20,5,'NO KAMAR',0,0,'L');
        $pdf->cell(3,5, ':',0,0,'');
        $pdf->Cell(5,5,$npm->kamar,0,0,'');
       
        $pdf->Cell(0,5,'',0,1);
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'TAHUN 2020',0,1,'C');
        //$pdf->Cell(5,3,'',1,0,'C');
        $pdf->SetFont('Times','',1);
        // $pdf->SetLineWidth(0);
        // $pdf->Cell(0,5,'',0,0,'C');
        // $pdf->Cell(30,8,'',1,1,'C');
       
       $pdf->SetFont('Times','B',12);
        $pdf->SetLineWidth(0);
        $pdf->Cell(120,5,'',0,0,'C');
        $pdf->Image(base_url('assets/admin.png'),155,57,38,35);
        $pdf->Cell(30,38,'',1,0,'C');




        //end

        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IDENTITAS',0,1,'L');
        $pdf->SetFont('Times','',12);

        //$pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,strtoupper($npm->nama),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Tempat/Tgl Lahir',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,$npm->tgl_lahir,0,-1,'');
        
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Jenis Kelamin',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        if ($npm->j_k =="L" )$j_k="Laki-laki";
        else $j_k="Perempuan";
        $pdf->Cell(5,5,($j_k),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->ttl),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Nomor HP/WA',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->noHP),0,1,'');
////////////////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'DATA AKADEMIS',0,1,'L');
        $pdf->SetFont('Times','',12);

        //$pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'NPM',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->npm),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Fakultas',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
         if ($npm->fakultas =="1" )$fakultas="Teknik";
         elseif ($npm->fakultas =="2" )$fakultas="Hukum";
         elseif ($npm->fakultas =="3" )$fakultas="Agama Islam";
         elseif ($npm->fakultas =="4" )$fakultas="Pertanian";
         elseif ($npm->fakultas =="5" )$fakultas="Ekonomi";
         elseif ($npm->fakultas =="6" )$fakultas="FIKIP";
         elseif ($npm->fakultas =="7" )$fakultas="FISP";
         elseif ($npm->fakultas =="8" )$fakultas="Ilmu Komunikasi";
         elseif ($npm->fakultas =="9" )$fakultas="Psikologi";
         else $fakultas="Pasca Sarjana";
        $pdf->Cell(5,5,$fakultas,0,-1,'');
        
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Program Studi',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
       if ($npm->jurusan =="1" )$jurusan="Teknik Sipil";
        elseif ($npm->jurusan =="2" )$jurusan="Teknik Perminyakan";
        elseif ($npm->jurusan =="3" )$jurusan="Teknik Mesin";
        elseif ($npm->jurusan =="4" )$jurusan="Teknik Perencanaan Wilayah dan Kota";
        elseif ($npm->jurusan =="5" )$jurusan="Teknik Informatika";
        elseif ($npm->jurusan =="6" )$jurusan="Teknik Geologi";
        elseif ($npm->jurusan =="7" )$jurusan="Hukum Tata Negara";
        elseif ($npm->jurusan =="8" )$jurusan="Hukum Perdata";
        elseif ($npm->jurusan =="9" )$jurusan="Hukum Pidana";
        elseif ($npm->jurusan =="10" )$jurusan="Hukum Administrasi Negara";
        elseif ($npm->jurusan =="11" )$jurusan="Hukum Internasional";
        elseif ($npm->jurusan =="13" )$jurusan="Hukum Bisnis";
        elseif ($npm->jurusan =="14" )$jurusan="Ekonomi Syari'ah";
        elseif ($npm->jurusan =="15" )$jurusan="Pendidikan Agama Islam";
        elseif ($npm->jurusan =="16" )$jurusan="Pendidikan Islam Anak Usia Dini ( PIAUD )";
        elseif ($npm->jurusan =="17" )$jurusan="Perbankan Syari'ah";
        elseif ($npm->jurusan =="18" )$jurusan="Pendidikan Bahasa Arab";
        elseif ($npm->jurusan =="19" )$jurusan="Agroteknologi";
        elseif ($npm->jurusan =="20" )$jurusan="Agribisnis";
        elseif ($npm->jurusan =="21" )$jurusan="Perikanan / Budidaya Perairan";
        elseif ($npm->jurusan =="22" )$jurusan="Ekonomi Pembangunan";
        elseif ($npm->jurusan =="23" )$jurusan="Manajemen";
        elseif ($npm->jurusan =="24" )$jurusan="Akuntansi";
        elseif ($npm->jurusan =="25" )$jurusan="D3 Akuntansi";
        else $jurusan="Pendidikan Bahasa Indonesia";

        $pdf->Cell(5,5,($jurusan),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Semester',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->semester),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'IP/IPK Terakhir',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'3,8',0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Email',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->email),0,1,'');
        /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PENGALAMAN ORGANISASI',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(3,5,'1',0,0,''); //1 =jarak ke titik
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'PRAMUKA',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(3,5,'3',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Komandan',0,-1,'');

        $pdf->Cell(65,5,'',0,0,'L');
        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

        $pdf->Cell(3,5,'2',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'OSIS',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(3,5,'4',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

         $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Ketua',0,-1,'');

        $pdf->Cell(65,5,'',0,0,'L');
        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');
        /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PRESTASI',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(3,5,'1',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Lomba MTQ',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(20,5,'Tahun(2000)',0,0,'');
        $pdf->cell(5,5, '',0,0,'');
        $pdf->Cell(-15,5,'Juara(1)',0,1,'');

        
        $pdf->Cell(3,5,'2',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Lomba Sepeda',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(20,5,'Tahun(2002)',0,0,'');
        $pdf->cell(5,5, '',0,0,'');
        $pdf->Cell(-15,5,'Juara(2)',0,1,'');

        /////////////////////////////////////

         /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'KEMAMPUAN BAHASA',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(30,5,'Bahasa Arab',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        $pdf->Cell(30,5,'Bahasa Inggris',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        $pdf->Cell(30,5,'Bahasa Indonesia',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        
        

        
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IDENTITAS ORANG TUA',0,0,'L');
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'AYAH / WALI',0,0,'L');
        $pdf->SetFont('Times','',12);

         $pdf->Cell(-50,5,'',0,0,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IBU',0,1,'L');
        $pdf->SetFont('Times','',12);

        $pdf->Cell(30,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,strtoupper($this->m_pdf->get_data($npm->id,'nama_Ayah')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,strtoupper($this->m_pdf->get_data($npm->id,'nama_Ibu')),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'TTL',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Pekanbaru, 01/01/1991',0,-1,'');

         $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'TTL',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'Jakarta, 01/02/1991',0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Pekerjaan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'PNS',0,-1,'');

         $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Pekerjaan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'IRT',0,-1,'');


        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($this->m_pdf->get_data($npm->id,'provinsi')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,strtoupper($this->m_pdf->get_data($npm->id,'provinsi')),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Nomor HP',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($this->m_pdf->get_data($npm->id,'noHP_Ayah')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Nomor HP',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(1,5,strtoupper($this->m_pdf->get_data($npm->id,'noHP_Ibu')),0,0,'');
////////////////////////////////////////////////
        $pdf->Ln();
        $pdf->SetFont('Times','','12');
        $pdf->Cell(60,5,'',0,0,'C');
        $pdf->cell(80,5,'Pekanbaru,',0,1,'C');

$pdf->Ln();$pdf->Ln();$pdf->Ln();

        $pdf->Cell(60,5,'',0,0,'L');
        $pdf->SetFont('Times','B','12');
        $pdf->cell(120,10,'(....................................)',0,0,'C');
        $pdf->Ln();
        ////////////////////////////////////////
        
    
    $pdf->Output();
        }
    
        
    }

    function pdf_all()
    {
        error_reporting(0);
        $get_id=$this->db->get('daftar_mhs')->result();
        $pdf = new FPDF('P', 'mm','A4');        
        $i=0;
        foreach ($get_id as $npm) {
            $i++;
        
        $pdf->AddPage();
        $pdf->SetMargins(40,40,30);
        $pdf->SetLeftMargin(40);
        if ($i > 1) $pdf->SetY(10);
        $pdf->Image(base_url('assets/uir.jpg'),165,10,25,22); //kiri x , bawah y , lebar, tinggi
        $pdf->Image(base_url('assets/uir.jpg'),30,10,25,22);
        //kop
        $pdf->Cell(0,0,'',0,1,'');
        $pdf->SetFont('Times','B',14);
        $pdf->Cell(0,5,'YAYASAN LEMBAGA PENDIDIKAN ISLAM (YLPI)',0,1,'C'); // left, space, text, border, vertikal (0) horizontal (1), Center
        //$pdf->Cell(25);
        $pdf->Cell(0,5,'UNIVERSITAS ISLAM RIAU',0,1,'C');
        //$pdf->Cell(25);
        $pdf->Cell(0,5,'ASRAMA AL-MUNAWWARAH',0,1,'C');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,5,'"Asrama Tahfizh dan Ilmu-Ilmu Al-Quran"',0,1,'C');
        //$pdf->Cell(25);
        $pdf->SetFont('Times','',8);
        $pdf->Cell(0,5,'Jl. Kaharuddin Nasution No.113. Hp 081281167972, 082277186704 Kode Pos 28284 Marpoyan, Pekanbaru, Riau',0,1,'C');
        //line
        //$pdf->Cell(0,5,'',0,1,'C');
        $pdf->SetLineWidth(0);
        $pdf->Line(36,36,184,36,'C'); //x left , up/-down, y right, up/-down
        $pdf->SetLineWidth(1);
        $pdf->Line(36,37,184,37,'C');
        //end line
        //end kop

        $pdf->Cell(0,5,'',0,1,'C');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'DATA MAHASISWA',0,1,'C');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PENGHUNI ASRAMA AL-MUNAWWARAH UIR',0,0,'C');
    
        $pdf->SetFont('Times','B',8);
        $pdf->SetLineWidth(0);
        $pdf->Cell(-15,0,'',0,0,'L');
        $pdf->Cell(20,5,'NO KAMAR',0,0,'L');
        $pdf->cell(3,5, ':',0,0,'');
        $pdf->Cell(5,5,$npm->kamar,0,0,'');
       
        $pdf->Cell(0,5,'',0,1);
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'TAHUN 2020',0,1,'C');
        //$pdf->Cell(5,3,'',1,0,'C');
        $pdf->SetFont('Times','',1);
        // $pdf->SetLineWidth(0);
        // $pdf->Cell(0,5,'',0,0,'C');
        // $pdf->Cell(30,8,'',1,1,'C');
        $pdf->SetFont('Times','B',12);
        $pdf->SetLineWidth(0);
        $pdf->Cell(120,5,'',0,0,'C');
        $pdf->Image(base_url('assets/admin.png'),155,57,38,35);
        $pdf->Cell(30,38,'',1,0,'C');




        //end
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IDENTITAS',0,1,'L');
        $pdf->SetFont('Times','',12);

        //$pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,strtoupper($npm->nama),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Tempat/Tgl Lahir',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,$npm->tgl_lahir,0,-1,'');
        
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Jenis Kelamin',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        if ($npm->j_k =="L" )$j_k="Laki-laki";
        else $j_k="Perempuan";
        $pdf->Cell(5,5,($j_k),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->ttl),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Nomor HP/WA',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->noHP),0,1,'');
////////////////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'DATA AKADEMIS',0,1,'L');
        $pdf->SetFont('Times','',12);

        //$pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'NPM',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->npm),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Fakultas',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
         if ($npm->fakultas =="1" )$fakultas="Teknik";
         elseif ($npm->fakultas =="2" )$fakultas="Hukum";
         elseif ($npm->fakultas =="3" )$fakultas="Agama Islam";
         elseif ($npm->fakultas =="4" )$fakultas="Pertanian";
         elseif ($npm->fakultas =="5" )$fakultas="Ekonomi";
         elseif ($npm->fakultas =="6" )$fakultas="FIKIP";
         elseif ($npm->fakultas =="7" )$fakultas="FISP";
         elseif ($npm->fakultas =="8" )$fakultas="Ilmu Komunikasi";
         elseif ($npm->fakultas =="9" )$fakultas="Psikologi";
         else $fakultas="Pasca Sarjana";
        $pdf->Cell(5,5,$fakultas,0,-1,'');
        
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Program Studi',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
       if ($npm->jurusan =="1" )$jurusan="Teknik Sipil";
        elseif ($npm->jurusan =="2" )$jurusan="Teknik Perminyakan";
        elseif ($npm->jurusan =="3" )$jurusan="Teknik Mesin";
        elseif ($npm->jurusan =="4" )$jurusan="Teknik Perencanaan Wilayah dan Kota";
        elseif ($npm->jurusan =="5" )$jurusan="Teknik Informatika";
        elseif ($npm->jurusan =="6" )$jurusan="Teknik Geologi";
        elseif ($npm->jurusan =="7" )$jurusan="Hukum Tata Negara";
        elseif ($npm->jurusan =="8" )$jurusan="Hukum Perdata";
        elseif ($npm->jurusan =="9" )$jurusan="Hukum Pidana";
        elseif ($npm->jurusan =="10" )$jurusan="Hukum Administrasi Negara";
        elseif ($npm->jurusan =="11" )$jurusan="Hukum Internasional";
        elseif ($npm->jurusan =="13" )$jurusan="Hukum Bisnis";
        elseif ($npm->jurusan =="14" )$jurusan="Ekonomi Syari'ah";
        elseif ($npm->jurusan =="15" )$jurusan="Pendidikan Agama Islam";
        elseif ($npm->jurusan =="16" )$jurusan="Pendidikan Islam Anak Usia Dini ( PIAUD )";
        elseif ($npm->jurusan =="17" )$jurusan="Perbankan Syari'ah";
        elseif ($npm->jurusan =="18" )$jurusan="Pendidikan Bahasa Arab";
        elseif ($npm->jurusan =="19" )$jurusan="Agroteknologi";
        elseif ($npm->jurusan =="20" )$jurusan="Agribisnis";
        elseif ($npm->jurusan =="21" )$jurusan="Perikanan / Budidaya Perairan";
        elseif ($npm->jurusan =="22" )$jurusan="Ekonomi Pembangunan";
        elseif ($npm->jurusan =="23" )$jurusan="Manajemen";
        elseif ($npm->jurusan =="24" )$jurusan="Akuntansi";
        elseif ($npm->jurusan =="25" )$jurusan="D3 Akuntansi";
        else $jurusan="Pendidikan Bahasa Indonesia";

        $pdf->Cell(5,5,($jurusan),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Semester',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->semester),0,-1,'');

         $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'IP/IPK Terakhir',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'3,8',0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(40,5,'Email',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($npm->email),0,1,'');
        /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PENGALAMAN ORGANISASI',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(3,5,'1',0,0,''); //1 =jarak ke titik
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'PRAMUKA',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(3,5,'3',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Komandan',0,-1,'');

        $pdf->Cell(65,5,'',0,0,'L');
        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

        $pdf->Cell(3,5,'2',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'OSIS',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(3,5,'4',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');

         $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Ketua',0,-1,'');

        $pdf->Cell(65,5,'',0,0,'L');
        $pdf->Cell(15,5,'Jabatan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'',0,1,'');
        /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'PRESTASI',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(3,5,'1',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Lomba MTQ',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(20,5,'Tahun(2000)',0,0,'');
        $pdf->cell(5,5, '',0,0,'');
        $pdf->Cell(-15,5,'Juara(1)',0,1,'');

        
        $pdf->Cell(3,5,'2',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Lomba Sepeda',0,-1,'');

        $pdf->Cell(75,5,'',0,0,'L');
        $pdf->Cell(20,5,'Tahun(2002)',0,0,'');
        $pdf->cell(5,5, '',0,0,'');
        $pdf->Cell(-15,5,'Juara(2)',0,1,'');

        /////////////////////////////////////

         /////////////////////////////////////
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'KEMAMPUAN BAHASA',0,1,'L');
        $pdf->SetFont('Times','',12);

       
        $pdf->Cell(30,5,'Bahasa Arab',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        $pdf->Cell(30,5,'Bahasa Inggris',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        $pdf->Cell(30,5,'Bahasa Indonesia',0,0,'');
        $pdf->cell(5,5, ':',0,-1,'');
        $pdf->Cell(5,5,'',0,-1,'');

        $pdf->Cell(5,5,'',0,0,'L');
        $pdf->cell(3,5, 'A',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Baik',0,-1,'');

        $pdf->Cell(10,5,'',0,0,'L');
        $pdf->Cell(3,5,'B',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(5,5,'Sedang',0,-1,'');

        $pdf->Cell(15,5,'',0,0,'L');
        $pdf->Cell(3,5,'C',0,0,'');
        $pdf->cell(5,5, '.',0,0,'');
        $pdf->Cell(-15,5,'Kurang',0,1,'');

        
        

        
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IDENTITAS ORANG TUA',0,0,'L');
        $pdf->Cell(0,5,'',0,1,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'AYAH / WALI',0,0,'L');
        $pdf->SetFont('Times','',12);

         $pdf->Cell(-50,5,'',0,0,'L');
        $pdf->SetFont('Times','B',12);
        $pdf->Cell(0,5,'IBU',0,1,'L');
        $pdf->SetFont('Times','',12);

        $pdf->Cell(30,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,strtoupper($this->m_pdf->get_data($npm->id,'nama_Ayah')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Nama',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,strtoupper($this->m_pdf->get_data($npm->id,'nama_Ibu')),0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'TTL',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'Pekanbaru, 01/01/1991',0,-1,'');

         $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'TTL',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'Jakarta, 01/02/1991',0,-1,'');

        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Pekerjaan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,'PNS',0,-1,'');

         $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Pekerjaan',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,'IRT',0,-1,'');


        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($this->m_pdf->get_data($npm->id,'provinsi')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Alamat',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(-15,5,strtoupper($this->m_pdf->get_data($npm->id,'provinsi')),0,-1,'');
         
        $pdf->Cell(0,5,'',0,1,'');
        $pdf->Cell(30,5,'Nomor HP',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(5,5,($this->m_pdf->get_data($npm->id,'noHP_Ayah')),0,-1,'');

        $pdf->Cell(40,5,'',0,0,'L');
        $pdf->Cell(30,5,'Nomor HP',0,0,'');
        $pdf->cell(5,5, ':',0,0,'');
        $pdf->Cell(1,5,strtoupper($this->m_pdf->get_data($npm->id,'noHP_Ibu')),0,0,'');
////////////////////////////////////////////////
        $pdf->Ln();
        $pdf->SetFont('Times','','12');
        $pdf->Cell(60,5,'',0,0,'C');
        $pdf->cell(80,5,'Pekanbaru,',0,1,'C');

$pdf->Ln();$pdf->Ln();$pdf->Ln();

        $pdf->Cell(60,5,'',0,0,'L');
        $pdf->SetFont('Times','B','12');
        $pdf->cell(120,10,'(....................................)',0,0,'C');
        $pdf->Ln();
    
   
    }
       $pdf->Output();  // echo "<pre>";
        // print_r($this->file_model->get_all('nama'));
    
    }
}