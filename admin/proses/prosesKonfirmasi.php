<?php
    include("koneksi.php");
    $id = $_GET['id'];
    $id_user = $_GET['u'];
    $distributor = $_GET['d'];
    //1 approve, else tolak
    if($_GET['code']=='1'){
        $query = "UPDATE konfirmasi_pembayaran SET konfirmasi_status = '1', konfirmasi_tgl = now() WHERE id_konfirmasi = '$id' ";
    }else {
        $query = "UPDATE konfirmasi_pembayaran SET konfirmasi_status = '0', konfirmasi_tgl = now() WHERE id_konfirmasi = '$id'";
    }
    
    //ketika transaksi yang login adalah admin maka admin ke distributor (penambahan stock) selain itu pengurangan stock di tabel stock
    if($_GET['level'] == '1' || $_GET['level'] == '2'){
        if(changeStockEveryProductAdminToDistributor($koneksi, $id, $distributor) == '1'){
            $cek = mysqli_query($koneksi, $query);
            if($cek){
             header("location:../konfirmasiPembayaran.php?alert=2");
            }else {
                header("location:../konfirmasiPembayaran.php?alert=3");
            }
        }else {
            header("location:../konfirmasiPembayaran.php?alert=3");
        }
    }else {
        if(changeStockEveryProductDistributorToReseller($koneksi, $id, $id_user) == '1'){
           $cek = mysqli_query($koneksi, $query);
            if($cek){
                header("location:../konfirmasiPembayaran.php?alert=2");
               }else {
                   header("location:../konfirmasiPembayaran.php?alert=3");
               }
        }else {
            header("location:../konfirmasiPembayaran.php?alert=3");
        }
    
    }
       
    
?>