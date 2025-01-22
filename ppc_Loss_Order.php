<?php
    ini_set("error_reporting", 1);
    session_start();
    require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Summary Loss Order</title>
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
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Dari Tanggal Delivery</h4>
                                                    <input type="date" name="tgl1" class="form-control" value="<?= isset($_POST['submit']) ? $_POST['tgl1'] : '' ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Sampai Tanggal Delivery</h4>
                                                    <input type="date" name="tgl2" class="form-control" value="<?= isset($_POST['submit']) ? $_POST['tgl2'] : '' ?>">
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
                                                            <th>BUYER</th>
                                                            <th>NO. ORDER</th>
                                                            <th>UoM</th>
                                                            <th>NETTO (KG)</th>
                                                            <th>NETTO (YD/MTR)</th>
                                                            <th>BRUTO (KG)</th>
                                                            <th>BRUTO (YD/MTR)</th>
                                                            <th>TOTAL BRUTO (KG)</th>
                                                            <th>TOTAL BRUTO (YD/MTR)</th>
                                                            <th>QTY PACKING(KG)</th>
                                                            <th>QTY PACKING(YD/MTR)</th>
                                                            <th>QTY GANTI KAIN(KG)</th>
                                                            <th>QTY GANTI KAIN(YD/MTR)</th>
                                                            <th>QTY SUDAH KIRIM (KG)</th>
                                                            <th>QTY SUDAH KIRIM (YD/MTR)</th>
                                                            <th title="qty packing - qty kirim">QTY SELISIH KIRIM (KG)</th>
                                                            <th title="qty packing - qty kirim">QTY SELISIH KIRIM (YD/MTR)</th>
                                                            <th>QTY BS (KG)</th>
                                                            <th>QTY BS (YD/MTR)</th>
                                                            <th>QTY SISA (KG)</th>
                                                            <th>QTY SISA (YD/MTR)</th>
                                                            <th>LOSS MASTER (KG)</th>
                                                            <th title="(Total Qty Bruto - Qty Packing) / Total Qty Bruto * 100%">LOSS AKTUAL (KG)</th>
                                                            <th>LOSS KIRIM (KG)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            ini_set("error_reporting", 1);
                                                            session_start();
                                                            require_once "koneksi.php";

                                                            $wheres = [];

                                                            if($_POST['no_order']){
                                                                $wheres[] = "NO_ORDER = '$_POST[no_order]'";
                                                            }
                                                            if($_POST['no_po']){
                                                                $wheres[] = "NO_PO = '$_POST[no_po]'";
                                                            }
                                                            if($_POST['tgl1'] && $_POST['tgl2']) {
                                                                $wheres[] = "ACTUAL_DELIVERY BETWEEN '$_POST[tgl1]' AND '$_POST[tgl2]'";
                                                            }

                                                            $wheres[] = "NOT QUALITYREASONCODE = 'FOC'";

                                                            $where_and = implode(" AND ", $wheres);

                                                            $q_sum_po_selesai   = db2_exec($conn1, "SELECT 
                                                                                                        PELANGGAN,
                                                                                                        BUYER,
                                                                                                        TRIM(NO_ORDER) AS NO_ORDER,
                                                                                                        PRICEUNITOFMEASURECODE,
                                                                                                        SUM(ROUND(NETTO, 2)) AS NETTO,
                                                                                                        SUM(ROUND(NETTO_YD_MTR, 2)) AS NETTO_YD_MTR,
                                                                                                        SUM(ROUND(NETTO_M, 2)) AS NETTO_M,
                                                                                                        SUM(QTY_SUDAH_KIRIM) AS QTY_SUDAH_KIRIM,
                                                                                                        SUM(QTY_SUDAH_KIRIM_2) AS QTY_SUDAH_KIRIM_2 
                                                                                                    FROM 
                                                                                                        (SELECT 
                                                                                                            DISTINCT 
                                                                                                            ORDERLINE,
                                                                                                            PELANGGAN,
                                                                                                            BUYER,
                                                                                                            TRIM(NO_ORDER) AS NO_ORDER,
                                                                                                            PRICEUNITOFMEASURECODE,
                                                                                                            ROUND(NETTO, 2) AS NETTO,
                                                                                                            ROUND(NETTO_2, 2)  AS NETTO_YD_MTR,
                                                                                                            ROUND(NETTO_M, 2) AS NETTO_M,
                                                                                                            SUM(QTY_SUDAH_KIRIM)AS QTY_SUDAH_KIRIM,
                                                                                                            SUM(QTY_SUDAH_KIRIM_2) AS QTY_SUDAH_KIRIM_2
                                                                                                        FROM
                                                                                                            ITXVIEW_SUMMARY_QTY_DELIVERY isqd
                                                                                                        WHERE
                                                                                                            $where_and
                                                                                                        GROUP BY
                                                                                                            ORDERLINE,
                                                                                                            NETTO,
                                                                                                            PELANGGAN,
                                                                                                            BUYER,
                                                                                                            NO_ORDER,
                                                                                                            PRICEUNITOFMEASURECODE,
                                                                                                            ROUND(NETTO, 2),
                                                                                                            ROUND(NETTO_2, 2),
                                                                                                            ROUND(NETTO_M, 2)
                                                                                                        )
                                                                                                    GROUP BY
                                                                                                        PELANGGAN,
                                                                                                        BUYER,
                                                                                                        NO_ORDER,
                                                                                                        PRICEUNITOFMEASURECODE");
                                                            while ($dt_sum = db2_fetch_assoc($q_sum_po_selesai)) :
                                                                $qty_bruto  = "SELECT 
                                                                                    SUM(USERPRIMARYQUANTITY) AS BRUTO_KG,
                                                                                    SUM(USERSECONDARYQUANTITY) AS BRUTO_YD_MTR
                                                                                FROM
                                                                                    ITXVIEW_KGBRUTO
                                                                                WHERE
                                                                                    PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                    AND ITEMTYPE_DEMAND = 'KFF'
                                                                                    AND VALUESTRING IS NULL";
                                                                $q_bruto    = db2_exec($conn1, $qty_bruto);
                                                                $dt_bruto   = db2_fetch_assoc($q_bruto);

                                                                $qty_bagikain_salinan   = "SELECT 
                                                                                                SUM(ik.USERPRIMARYQUANTITY) AS SALINAN_KG,
                                                                                                SUM(ik.USERSECONDARYQUANTITY) AS SALINAN_YD_MTR
                                                                                            FROM
                                                                                                ITXVIEW_KGBRUTO ik 
                                                                                            LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = ik.CODE 
                                                                                            LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.FIELDNAME = 'DefectTypeCode' 
                                                                                            WHERE
                                                                                                ik.PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                                AND ik.ITEMTYPE_DEMAND = 'KFF'
                                                                                                AND a.VALUESTRING = '058'";
                                                                $q_bagikain_salinan     = db2_exec($conn1, $qty_bagikain_salinan);
                                                                $dt_bagikain_salinan    = db2_fetch_assoc($q_bagikain_salinan);

                                                                $qty_packing     = "SELECT 
                                                                                        SUM(QTYPACKING_KG) AS QTYPACKING_KG,
                                                                                        SUM(QTYPACKING_YD_MTR) AS QTYPACKING_YD_MTR
                                                                                    FROM (
                                                                                        SELECT
                                                                                            ITEMELEMENTCODE,
                                                                                            QUALITYREASONCODE,
                                                                                            (USERPRIMARYQUANTITY) AS QTYPACKING_KG,
                                                                                            (USERSECONDARYQUANTITY) AS QTYPACKING_YD_MTR
                                                                                        FROM
                                                                                            STOCKTRANSACTION 
                                                                                        WHERE
                                                                                            LOGICALWAREHOUSECODE = 'M033'
                                                                                            AND TEMPLATECODE = '303'
                                                                                            AND PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                        GROUP BY 
                                                                                            ITEMELEMENTCODE,
                                                                                            QUALITYREASONCODE,
                                                                                            USERPRIMARYQUANTITY,
                                                                                            USERSECONDARYQUANTITY
                                                                                        )
                                                                                    WHERE
	                                                                                    QUALITYREASONCODE IN ('SA', 'SD', 'SF', 'SG', 'SM', 'SP', 'SR', 'ST', '100') OR QUALITYREASONCODE IS NULL";
                                                                $q_packing       = db2_exec($conn1, $qty_packing);
                                                                $dt_packing      = db2_fetch_assoc($q_packing);
                                                                
                                                                $qty_sisa     = "SELECT
                                                                                    SUM(USERPRIMARYQUANTITY) AS QTYSISA_KG,
                                                                                    SUM(USERSECONDARYQUANTITY) AS QTYSISA_YD_MTR
                                                                                FROM
                                                                                    STOCKTRANSACTION 
                                                                                WHERE
                                                                                    LOGICALWAREHOUSECODE = 'M033'
                                                                                    AND TEMPLATECODE = '304'
                                                                                    AND PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                    AND ITEMTYPECODE = 'KFF'
                                                                                    AND QUALITYREASONCODE IN ('SA', 'SD','SF','SG','SM','SP','SR','ST')";
                                                                $q_sisa       = db2_exec($conn1, $qty_sisa);
                                                                $dt_sisa      = db2_fetch_assoc($q_sisa);
                                                                
                                                                $qty_bs     = "SELECT
                                                                                        SUM(USERPRIMARYQUANTITY) AS QTYBS_KG,
                                                                                        SUM(USERSECONDARYQUANTITY) AS QTYBS_YD_MTR
                                                                                    FROM
                                                                                        STOCKTRANSACTION 
                                                                                    WHERE
                                                                                        LOGICALWAREHOUSECODE = 'M631'
                                                                                        AND TEMPLATECODE = '304'
                                                                                        AND PROJECTCODE = '$dt_sum[NO_ORDER]'";
                                                                $q_bs       = db2_exec($conn1, $qty_bs);
                                                                $dt_bs      = db2_fetch_assoc($q_bs);
                                                        ?>
                                                        <tr>
                                                            <td><?= $dt_sum['PELANGGAN']; ?></td>
                                                            <td><?= $dt_sum['BUYER']; ?></td>
                                                            <td><?= $dt_sum['NO_ORDER']; ?></td>
                                                            <td><?= $dt_sum['PRICEUNITOFMEASURECODE']; ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO'], 2); ?></td>
                                                            <td align="right">
                                                                <?php
                                                                    if(TRIM($dt_sum['PRICEUNITOFMEASURECODE']) == 'm'){
                                                                        $netto_2 = number_format($dt_sum['NETTO_M'] ?? 2, 0);
                                                                        echo $netto_2;
                                                                    }else{
                                                                        $netto_2 = number_format($dt_sum['NETTO_YD_MTR'] ?? 2, 0);
                                                                        echo $netto_2;
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="right"><?= number_format($dt_bruto['BRUTO_KG'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_bruto['BRUTO_YD_MTR'], 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_bruto['BRUTO_KG'] + $dt_bagikain_salinan['SALINAN_KG'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_bruto['BRUTO_YD_MTR'] + $dt_bagikain_salinan['SALINAN_YD_MTR'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format($dt_packing['QTYPACKING_KG'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_packing['QTYPACKING_YD_MTR'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_bagikain_salinan['SALINAN_KG'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_bagikain_salinan['SALINAN_YD_MTR'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['QTY_SUDAH_KIRIM_2'], 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_packing['QTYPACKING_KG'] - $dt_sum['QTY_SUDAH_KIRIM'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_packing['QTYPACKING_YD_MTR'] - $dt_sum['QTY_SUDAH_KIRIM_2'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format($dt_bs['QTYBS_KG'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_bs['QTYBS_YD_MTR'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sisa['QTYSISA_KG'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sisa['QTYSISA_YD_MTR'], 2); ?></td>
                                                            <td align="right">
                                                                <?php 
                                                                    $bruto_kg = str_replace(',', '', number_format($dt_bruto['BRUTO_KG'], 2));
                                                                    $netto_kg = str_replace(',', '', number_format($dt_sum['NETTO'], 2));

                                                                    // Pastikan netto tidak nol untuk menghindari pembagian dengan nol
                                                                    if ($netto_kg > 0 && $bruto_kg > 0) {
                                                                        // Hitung persentase
                                                                        $percentage = (($bruto_kg - $netto_kg) / $bruto_kg) * 100;

                                                                        // Format hasil ke dua desimal
                                                                        $formatted_percentage_master = number_format($percentage, 2);

                                                                        // Tampilkan hasil
                                                                        echo "{$formatted_percentage_master}%";
                                                                    } else {
                                                                        $error = "Qty tidak boleh nol.";
                                                                        echo $error;
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="right">
                                                                <?php 
                                                                    $packing_kg = str_replace(',', '', number_format($dt_packing['QTYPACKING_KG'], 2));
                                                                    $Totalbruto_kg   = str_replace(',', '', number_format($dt_bruto['BRUTO_KG'] + $dt_bagikain_salinan['SALINAN_KG'], 2));

                                                                    // Pastikan netto tidak nol untuk menghindari pembagian dengan nol
                                                                    if ($Totalbruto_kg > 0 && $packing_kg > 0) {
                                                                        // Hitung persentase
                                                                        $percentage = (($Totalbruto_kg - $packing_kg) / $Totalbruto_kg) * 100;

                                                                        // Format hasil ke dua desimal
                                                                        $formatted_percentage_aktual = number_format($percentage, 2);

                                                                        // Tampilkan hasil
                                                                        echo "{$formatted_percentage_aktual}%";
                                                                    } else {
                                                                        $error = "Qty tidak boleh nol.";
                                                                        echo $error;
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="right">
                                                                <?php 
                                                                    $packing_kg = str_replace(',', '', number_format($dt_packing['QTYPACKING_KG'], 2));
                                                                    $kirim_kg   = str_replace(',', '', number_format($dt_sum['QTY_SUDAH_KIRIM'], 2));

                                                                    // Pastikan netto tidak nol untuk menghindari pembagian dengan nol
                                                                    if ($kirim_kg > 0 && $packing_kg > 0) {
                                                                        // Hitung persentase
                                                                        $percentage = (($packing_kg - $kirim_kg) / $packing_kg) * 100;

                                                                        // Format hasil ke dua desimal
                                                                        $formatted_percentage_kirim = number_format($percentage, 2);

                                                                        // Tampilkan hasil
                                                                        echo "{$formatted_percentage_kirim}%";
                                                                    } else {
                                                                        $error = "Qty tidak boleh nol.";
                                                                        echo $error;
                                                                    }
                                                                ?>
                                                            </td>
                                                            
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