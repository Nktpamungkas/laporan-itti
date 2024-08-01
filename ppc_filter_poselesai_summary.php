<?php
    ini_set("error_reporting", 1);
    session_start();
    require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SUMMARY PO SELESAI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <link rel="icon" href="files\assets\images\favicon.ico" type="image/x-icon">
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="files\bower_components\bootstrap\css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="files\assets\icon\themify-icons\themify-icons.css">
    <link rel="stylesheet" type="text/css" href="files\assets\icon\icofont\css\icofont.css">
    <link rel="stylesheet" type="text/css" href="files\assets\icon\feather\css\feather.css">
    <link rel="stylesheet" type="text/css" href="files\assets\pages\prism\prism.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\style.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\pcoded-horizontal.min.css">
    <link rel="stylesheet" type="text/css" href="files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="files\assets\pages\data-table\css\buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css">
</head>
<?php require_once 'header.php'; ?>

<body>
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Filter Data</h5>
                                    </div>
                                    <div class="card-block">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Bon Order</h4>
                                                    <input type="text" name="no_order" class="form-control" onkeyup="this.value = this.value.toUpperCase()" value="<?php if (isset($_POST['submit'])) {
                                                                                                                                                                        echo $_POST['no_order'];
                                                                                                                                                                    } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Nomor PO</h4>
                                                    <input type="text" name="no_po" class="form-control" value="<?php if (isset($_POST['submit'])) {
                                                                                                                            echo $_POST['no_po'];
                                                                                                                        } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-12 m-b-30">
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-1"></i> Cari data</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php if (isset($_POST['submit']) or ($_GET['demand'] and $_GET['prod_order'])) : ?>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive">
                                                <table id="excel-LA" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>PELANGGAN</th>
                                                            <th>NO. ORDER</th>
                                                            <th>NO. PO</th>
                                                            <th>KETERANGAN PRODUCT</th>
                                                            <th>STYLE</th>
                                                            <th>LEBAR</th>
                                                            <th>GRAMASI</th>
                                                            <th>WARNA</th>
                                                            <th>NO WARNA</th>
                                                            <th>DELIVERY ACTUAL</th>
                                                            <th>NETTO (KG)</th>
                                                            <th>NETTO (YD)</th>
                                                            <th>KONVERSI</th>
                                                            <th title="PENGAMBILAN LAPORAN PENGIRIMAN">QTY SUDAH KIRIM (KG)</th>
                                                            <th title="PENGAMBILAN LAPORAN PENGIRIMAN">QTY SUDAH KIRIM (YD/MTR)</th>
                                                            <th title="QTY NETTO - QTY KIRIM">QTY KURANG KIRIM (KG)</th>
                                                            <th title="QTY NETTO - QTY KIRIM">QTY KURANG KIRIM (YD/MTR)</th>
                                                            <th title="QTY NETTO - QTY KIRIM - QTY READY">QTY KURANG (KG)</th>
                                                            <th title="QTY NETTO - QTY KIRIM - QTY READY">QTY KURANG (YD/MTR)</th>
                                                            <th title="AMBIL DARI BALANCE">QTY READY (KG)</th>
                                                            <th title="AMBIL DARI BALANCE">QTY READY (YD/MTR)</th>
                                                            <th title="DELIVERY ACTUAL - TANGGAL HARI INI">DELAY</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            ini_set("error_reporting", 1);
                                                            session_start();
                                                            require_once "koneksi.php";

                                                            if($_POST['no_order'] AND $_POST['no_po']){
                                                                $where_no_order_po     = "NO_ORDER = '$_POST[no_order]' AND NO_PO = '$_POST[no_po]'";
                                                            }elseif($_POST['no_order'] AND empty($_POST['no_po'])){
                                                                $where_no_order_po     = "NO_ORDER = '$_POST[no_order]'";
                                                            }elseif(empty($_POST['no_order']) AND ($_POST['no_po'])){
                                                                $where_no_order_po     = "NO_PO = '$_POST[no_po]'";
                                                            }else{
                                                                $where_no_order_po     = "";
                                                            }

                                                            $q_sum_po_selesai   = db2_exec($conn1, "SELECT
                                                                                                        ORDERLINE,
                                                                                                        PELANGGAN,
                                                                                                        NO_ORDER,
                                                                                                        NO_PO,
                                                                                                        KET_PRODUCT,
                                                                                                        STYLE,
                                                                                                        LEBAR,
                                                                                                        GRAMASI,
                                                                                                        WARNA,
                                                                                                        NO_WARNA,
                                                                                                        NETTO,
                                                                                                        NETTO_2,
                                                                                                        KONVERSI,
                                                                                                        ACTUAL_DELIVERY,
                                                                                                        SUM(QTY_SUDAH_KIRIM) AS QTY_SUDAH_KIRIM,
                                                                                                        SUM(QTY_SUDAH_KIRIM_2) AS QTY_SUDAH_KIRIM_2,
                                                                                                        CASE
                                                                                                            WHEN DAYS(now()) - DAYS(Timestamp_Format(ACTUAL_DELIVERY, 'YYYY-MM-DD')) < 0 THEN 0
                                                                                                            ELSE DAYS(now()) - DAYS(Timestamp_Format(ACTUAL_DELIVERY, 'YYYY-MM-DD'))
                                                                                                        END	AS DELAY
                                                                                                    FROM
                                                                                                        ITXVIEW_SUMMARY_QTY_DELIVERY isqd
                                                                                                    WHERE
                                                                                                        $where_no_order_po
                                                                                                    GROUP BY
                                                                                                        ORDERLINE,
                                                                                                        PELANGGAN,
                                                                                                        NO_ORDER,
                                                                                                        NO_PO,
                                                                                                        KET_PRODUCT,
                                                                                                        STYLE,
                                                                                                        LEBAR,
                                                                                                        GRAMASI,
                                                                                                        WARNA,
                                                                                                        NO_WARNA,
                                                                                                        NETTO,
                                                                                                        NETTO_2,
                                                                                                        KONVERSI,
                                                                                                        ACTUAL_DELIVERY
                                                                                                    ORDER BY
	                                                                                                    ORDERLINE ASC");
                                                            while ($dt_sum = db2_fetch_assoc($q_sum_po_selesai)) :
                                                                $q_lotcode      = db2_exec($conn1, "SELECT
                                                                                                        LISTAGG(DISTINCT ''''|| TRIM(LOTCODE) ||'''', ', ')  AS LOTCODE
                                                                                                    FROM 
                                                                                                        ITXVIEW_SUMMARY_QTY_DELIVERY 
                                                                                                    WHERE 
                                                                                                        NO_ORDER = '$dt_sum[NO_ORDER]' 
                                                                                                        AND ORDERLINE = '$dt_sum[ORDERLINE]'");
                                                                $d_lotcode      = db2_fetch_assoc($q_lotcode);

                                                                if($d_lotcode['LOTCODE']){
                                                                    $q_ready        = db2_exec($conn1, "SELECT
                                                                                                            SUM(BASEPRIMARYQUANTITYUNIT) AS QTY_READY,
                                                                                                            SUM(BASESECONDARYQUANTITYUNIT) AS QTY_READY_2
                                                                                                        FROM
                                                                                                            BALANCE b
                                                                                                        WHERE
                                                                                                            PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                                            AND LOTCODE IN ($d_lotcode[LOTCODE])
                                                                                                            AND TRIM(DECOSUBCODE02) || '-' || TRIM(DECOSUBCODE03) = '$dt_sum[KET_PRODUCT]'");
                                                                    $d_qty_ready    = db2_fetch_assoc($q_ready);
                                                                }else{
                                                                    $q_lotcode      = db2_exec($conn1, "SELECT
                                                                                                            LISTAGG(DISTINCT ''''|| TRIM(PRODUCTIONORDERCODE) ||'''', ', ')  AS LOTCODE
                                                                                                        FROM 
                                                                                                            ITXVIEWKK i 
                                                                                                        WHERE 
                                                                                                            PROJECTCODE = '$dt_sum[NO_ORDER]' 
                                                                                                            AND ORIGDLVSALORDERLINEORDERLINE = '$dt_sum[ORDERLINE]'
                                                                                                            AND PROGRESSSTATUS_DEMAND = 6
                                                                                                            AND NOT DELIVERYDATE IS NULL");
                                                                    $d_lotcode      = db2_fetch_assoc($q_lotcode);

                                                                    if($d_lotcode['LOTCODE']){
                                                                        $q_ready        = db2_exec($conn1, "SELECT
                                                                                                                SUM(BASEPRIMARYQUANTITYUNIT) AS QTY_READY,
                                                                                                                SUM(BASESECONDARYQUANTITYUNIT) AS QTY_READY_2
                                                                                                            FROM
                                                                                                                BALANCE b
                                                                                                            WHERE
                                                                                                                PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                                                AND LOTCODE IN ($d_lotcode[LOTCODE])
                                                                                                                AND TRIM(DECOSUBCODE02) || '-' || TRIM(DECOSUBCODE03) = '$dt_sum[KET_PRODUCT]'");
                                                                        $d_qty_ready    = db2_fetch_assoc($q_ready);
                                                                    }
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td><?= $dt_sum['PELANGGAN']; ?></td>
                                                            <td><?= $dt_sum['NO_ORDER']; ?></td>
                                                            <td><?= $dt_sum['NO_PO']; ?></td>
                                                            <td><?= $dt_sum['KET_PRODUCT']; ?></td>
                                                            <td><?= $dt_sum['STYLE']; ?></td>
                                                            <td align="center"><?= number_format($dt_sum['LEBAR'], 0); ?></td>
                                                            <td align="center"><?= number_format($dt_sum['GRAMASI'], 0); ?></td>
                                                            <td><a target="_blank" href="ppc_filter_poselesai_summary_detail.php?no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>&orderline=<?= $dt_sum['ORDERLINE']; ?>"><?= $dt_sum['WARNA']; ?></a></td>
                                                            <td><?= $dt_sum['NO_WARNA']; ?></td>
                                                            <td><?= $dt_sum['ACTUAL_DELIVERY']; ?></td>
                                                            <td align="right"><?= $dt_sum['NETTO']; ?></td>
                                                            <td align="right"><?= $dt_sum['NETTO_2']; ?></td>
                                                            <td align="center"><?= $dt_sum['KONVERSI']; ?></td>
                                                            <td align="right"><?= $dt_sum['QTY_SUDAH_KIRIM']; ?></td>
                                                            <td align="right"><?= $dt_sum['QTY_SUDAH_KIRIM_2']; ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO']-$dt_sum['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO_2']-$dt_sum['QTY_SUDAH_KIRIM_2'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO']-$dt_sum['QTY_SUDAH_KIRIM']-$d_qty_ready['QTY_READY'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO_2']-$dt_sum['QTY_SUDAH_KIRIM_2']-$d_qty_ready['QTY_READY_2'], 2); ?></td>
                                                            <td align="right"><?= $d_qty_ready['QTY_READY']; ?></td>
                                                            <td align="right"><?= $d_qty_ready['QTY_READY_2']; ?></td>
                                                            <td><?= $dt_sum['DELAY']; ?></td>
                                                        </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="files\bower_components\jquery\js\jquery.min.js"></script>
<script type="text/javascript" src="files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
<script type="text/javascript" src="files\bower_components\popper.js\js\popper.min.js"></script>
<script type="text/javascript" src="files\bower_components\bootstrap\js\bootstrap.min.js"></script>
<script type="text/javascript" src="files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
<script type="text/javascript" src="files\bower_components\modernizr\js\modernizr.js"></script>
<script type="text/javascript" src="files\bower_components\modernizr\js\css-scrollbars.js"></script>
<script src="files\bower_components\datatables.net\js\jquery.dataTables.min.js"></script>
<script src="files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js"></script>
<script src="files\assets\pages\data-table\js\jszip.min.js"></script>
<script src="files\assets\pages\data-table\js\pdfmake.min.js"></script>
<script src="files\assets\pages\data-table\js\vfs_fonts.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\dataTables.buttons.min.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\buttons.flash.min.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\jszip.min.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\vfs_fonts.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\buttons.colVis.min.js"></script>
<script src="files\bower_components\datatables.net-buttons\js\buttons.print.min.js"></script>
<script src="files\bower_components\datatables.net-buttons\js\buttons.html5.min.js"></script>
<script src="files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
<script src="files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
<script src="files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="files\bower_components\i18next\js\i18next.min.js"></script>
<script type="text/javascript" src="files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="files\bower_components\jquery-i18next\js\jquery-i18next.min.js"></script>
<script src="files\assets\pages\data-table\extensions\buttons\js\extension-btns-custom.js"></script>
<script src="files\assets\js\pcoded.min.js"></script>
<script src="files\assets\js\menu\menu-hori-fixed.js"></script>
<script src="files\assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="files\assets\js\script.js"></script>

<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>
<script>
    $('#excel-LA').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                $('row c[r^="F"]', sheet).each(function() {
                    if ($('is t', this).text().replace(/[^\d]/g, '') * 1 >= 500000) {
                        $(this).attr('s', '20');
                    }
                });
            }
        }]
    });
</script>
<?php require_once 'footer.php'; ?>