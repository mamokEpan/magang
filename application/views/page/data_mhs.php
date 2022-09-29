<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<html>

<script type="text/javascript">
    $(document).ready( function () {
    $('#datatable-responsive').DataTable();
} );
</script>
<div class="table-responsive">
    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">NPM</th>
                <th width="20%">Nama</th>
                <th width="10%">Tanggal Lahir</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="5%">Fakultas</th>
                <th width="10%">Jurusan</th>
                <th width="10%">Kamar</th>
                <th width="10%">No.Hp</th>
                <th width="10%">Tindakan</th>
            </tr>
        </thead>
        <tbody>
                    <?php
                        $start = 0;
                        foreach ($mhs_data as $mhs)
                        {
                            // Mngambil data fakultas dari id fakultas mahasiswa
                            $fakultas = $DB->get_where('fakultas',array('id' => $mhs->fakultas))->result();
                            foreach($fakultas as $fk){
                                $fakultas = $fk->nama_fakultas;
                            }

                            // Mngambil data jurusan dari id jurusan mahasiswa
                            $jurusan = $DB->get_where('jurusan',array('id' => $mhs->jurusan))->result();
                            foreach($jurusan as $fk){
                                $jurusan = $fk->nama_jurusan;
                            }
                    ?>
                    <tr >
                        <td><?php echo ++$start ?></td>
                        <td><?php echo $mhs->npm ?></td>
                        <td><?php echo $mhs->nama ?></td>
                        <td><?php echo $mhs->tgl_lahir ?></td>
                        <td><?php echo $mhs->j_k ?></td>
                        <td><?php echo $fakultas ?></td>
                        <td><?php echo $jurusan ?></td>
                        <td><?php echo $mhs->kamar ?></td>
                        <td><?php echo $mhs->noHP ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm mb" href="pdf/<?php echo $mhs->id ?>" target="_blank" title="Cetak">
                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                           
                        </td>

                     

                      
                   
                    </tr>
                    
                    <?php
                        }
                    ?>

                </tbody>
                
    </table>
    <p><a style="background-color:#7FFFD4; color:black" class="btn btn-sm" href="pdf_all">Cetak Seluruh Data</a></p>

</div>
</html>