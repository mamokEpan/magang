<!DOCTYPE html>
<html>
<head>
    <title>KP</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css"/>
    <script src="<?=base_url('assets/js/jquery.min.js?ver=3.2.0')?>"></script>
    <script src="<?=base_url('assets/js/bootstrap.min.js?ver=3.3.7')?>"></script>
    <script src="<?=base_url('assets/js/jquery.dataTables.min.js?ver=1.10.13')?>"></script>
    <script src="<?=base_url('assets/js/dataTables.bootstrap.min.js?ver=1.10.13')?>"></script>
</head>
<body>



<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           <!--  <a class="navbar-brand" href="<?=site_url('')?>"><img class="brand-logo" src="<?=site_url('')?>" alt="">
            </a> -->
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="grafik_wilayah">Grafik Wilayah</a></li>
                <li><a href="grafik_fakultas">Grafik Fakultas</a></li>
                <li><a href="grafik_tunggakan_pembayaran">Grafik Tunggakan Pembayaran</a></li>         
                <li><a href="datatabel">Data Mahasiswa Asrama</a></li>
            </ul>
            
        </div>
    </div>
</nav>
</body>
</html>