<head>
    <title>DETAIL SUMMARY PO SELESAI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <link rel="icon" href="files\assets\images\favicon.ico" type="image/x-icon">
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
<style>
    /* Menghilangkan padding dan margin pada header tabel */
    .dataTables_wrapper th {
        padding: 0; /* Menghilangkan padding di header */
        margin: 0; /* Menghilangkan margin di header */
        text-align: center; /* Memastikan teks di tengah */
        vertical-align: middle; /* Memastikan teks sejajar di tengah secara vertikal */
        line-height: 1; /* Mengatur tinggi baris */
    }

    /* Jika ada border atau spacing bawaan */
    table {
        border-spacing: 0 !important; /* Menghilangkan jarak antar sel */
        border-collapse: collapse !important; /* Menggabungkan border */
    }

    /* Khusus untuk header tabel agar lebih rapat */
    table thead tr th {
        padding: 2px !important; /* Menyesuaikan jarak sesuai kebutuhan */
    }
    
    table tbody tr td {
        padding: 3px !important; /* Menyesuaikan jarak sesuai kebutuhan */
    }
    
    table tfoot tr td {
        padding: 5px !important; /* Menyesuaikan jarak sesuai kebutuhan */
    }

</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card card-border-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Detail Qty Kirim</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;" >
                                        <table id="ExportToExcel_kirim" class="table table-striped table-bordered nowrap" style="font-size: 11px; text-align: center;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">P. DEMAND</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">LOT</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">P. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY BAGI</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY SALINAN</th>

                                                    <th colspan="3" style="vertical-align: middle; text-align: center;">QTY KIRIM</th>

                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO SJ</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">TGL KIRIM</th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center;">ROLLS</th>
                                                    <th style="vertical-align: middle; text-align: center;">KGS</th>
                                                    <th style="vertical-align: middle; text-align: center;">YARDS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require_once "koneksi.php";

                                                    $no_order       = $_GET['no_order'];
                                                    $orderline      = $_GET['orderline'];
                                                    $query          = "SELECT DISTINCT
                                                                            SALESDOCUMENTPROVISIONALCODE,
                                                                            GOODSISSUEDATE,
                                                                            LOTCODE,
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
                                                                            SATUAN_NETTO,
                                                                            NETTO_2,
                                                                            SATUAN_NETTO_2,
                                                                            KONVERSI,
                                                                            ACTUAL_DELIVERY,
                                                                            SUM(QTY_SUDAH_KIRIM) AS QTY_SUDAH_KIRIM,
                                                                            SUM(QTY_SUDAH_KIRIM_2) AS QTY_SUDAH_KIRIM_2
                                                                        FROM 
                                                                            ITXVIEW_SUMMARY_QTY_DELIVERY isqd
                                                                        LEFT JOIN SALESORDER s ON s.CODE = isqd.NO_ORDER 
                                                                        LEFT JOIN ITXVIEW_PELANGGAN ip ON ip.ORDPRNCUSTOMERSUPPLIERCODE = s.ORDPRNCUSTOMERSUPPLIERCODE AND ip.CODE = s.CODE 
                                                                        LEFT JOIN PRODUCTIONDEMAND p ON p.ORIGDLVSALORDLINESALORDERCODE = isqd.NO_ORDER AND p.ORIGDLVSALORDERLINEORDERLINE = isqd.ORDERLINE 
                                                                        WHERE 
                                                                            NO_ORDER = '$no_order' 
                                                                            AND ORDERLINE = '$orderline' 
                                                                            AND NOT QUALITYREASONCODE = 'FOC'
                                                                        GROUP BY
                                                                            SALESDOCUMENTPROVISIONALCODE,
                                                                            GOODSISSUEDATE,
                                                                            LOTCODE,
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
                                                                            SATUAN_NETTO,
                                                                            NETTO_2,
                                                                            SATUAN_NETTO_2,
                                                                            KONVERSI,
                                                                            ACTUAL_DELIVERY
                                                                        ORDER BY 
                                                                            SALESDOCUMENTPROVISIONALCODE 
                                                                            ASC";

                                                    $q_sum_po_selesai   = db2_exec($conn1, $query);
                                                    $totalQtyBagi = 0;
                                                    $totalQtySalinan = 0;
                                                    $totalRollKirim = 0;
                                                    $totalQtyKgKirim = 0;
                                                    $totalQtyYdMtrKirim = 0;
                                                    while ($dt_sum_detail = db2_fetch_assoc($q_sum_po_selesai)) :
                                                        $q_demand   = db2_exec($conn1, "SELECT 
                                                                                            PRODUCTIONDEMANDCODE
                                                                                        FROM 
                                                                                            ITXVIEW_DEMANDBYLOTCODE 
                                                                                        WHERE 
                                                                                            PRODUCTIONORDERCODE = '$dt_sum_detail[LOTCODE]'
                                                                                            AND DLVSALESORDERLINEORDERLINE = '$orderline'");
                                                        $d_demand   = db2_fetch_assoc($q_demand);

                                                        $sql_ITXVIEWKK = db2_exec($conn1, "SELECT * FROM ITXVIEWKK WHERE PRODUCTIONDEMANDCODE = '$d_demand[PRODUCTIONDEMANDCODE]'");
                                                        $dt_ITXVIEWKK = db2_fetch_assoc($sql_ITXVIEWKK);

                                                        $q_qtysalinan = db2_exec($conn1, "SELECT * FROM PRODUCTIONDEMAND WHERE CODE = '$d_demand[PRODUCTIONDEMANDCODE]'");
                                                        $d_qtysalinan = db2_fetch_assoc($q_qtysalinan);

                                                        $q_orig_pd_code     = db2_exec($conn1, "SELECT 
                                                                                                    *, a.VALUESTRING AS ORIGINALPDCODE
                                                                                                FROM 
                                                                                                    PRODUCTIONDEMAND p 
                                                                                                LEFT JOIN ADSTORAGE a ON a.UNIQUEID = p.ABSUNIQUEID AND a.FIELDNAME = 'OriginalPDCode'
                                                                                                WHERE p.CODE = '$d_demand[PRODUCTIONDEMANDCODE]'");
                                                        $d_orig_pd_code     = db2_fetch_assoc($q_orig_pd_code);

                                                        $q_cek_salinan     = db2_exec($conn1, "SELECT 
                                                                                                    a2.VALUESTRING AS SALINAN_058
                                                                                                FROM 
                                                                                                    PRODUCTIONDEMAND p 
                                                                                                LEFT JOIN ADSTORAGE a2 ON a2.UNIQUEID = p.ABSUNIQUEID AND a2.FIELDNAME = 'DefectTypeCode'
                                                                                                LEFT JOIN USERGENERICGROUP u ON u.CODE = a2.VALUESTRING AND u.USERGENERICGROUPTYPECODE = '006'
                                                                                                WHERE p.CODE = '$d_demand[PRODUCTIONDEMANDCODE]'");
                                                        $d_cek_salinan     = db2_fetch_assoc($q_cek_salinan);

                                                        $q_qtybagikain      = db2_exec($conn1, "SELECT 
                                                                                                    ORDERCODE, 
                                                                                                    USEDUSERPRIMARYQUANTITY AS QTY_BAGIKAIN,
                                                                                                    USEDUSERSECONDARYQUANTITY AS QTY_BAGIKAIN_YD_MTR
                                                                                                FROM 
                                                                                                    ITXVIEW_RESERVATION_KK 
                                                                                                WHERE 
                                                                                                    ORDERCODE = '$d_demand[PRODUCTIONDEMANDCODE]'");
                                                        $d_qtybagikain      = db2_fetch_assoc($q_qtybagikain);

                                                        $q_roll_pengiriman      = db2_exec($conn1, "SELECT COUNT(CODE) AS ROLL,
                                                                                                            SUM(BASEPRIMARYQUANTITY) AS QTY_SJ_KG,
                                                                                                            SUM(BASESECONDARYQUANTITY) AS QTY_SJ_YARD,
                                                                                                            LOTCODE
                                                                                                    FROM 
                                                                                                        ITXVIEWALLOCATION0 
                                                                                                    WHERE 
                                                                                                        CODE = '$dt_sum_detail[CODE]' AND LOTCODE = '$dt_sum_detail[LOTCODE]'
                                                                                                    GROUP BY 
                                                                                                        LOTCODE");
                                                        $d_roll_pengiriman     = db2_fetch_assoc($q_roll_pengiriman);

                                                        $q_roll_ready   = db2_exec($conn1, "SELECT
                                                                                                COUNT(*) AS ROLL 
                                                                                            FROM
                                                                                                BALANCE b
                                                                                            WHERE
                                                                                                PROJECTCODE = '$dt_sum_detail[NO_ORDER]' 
                                                                                                AND b.LOTCODE = '$dt_sum_detail[LOTCODE]' 
                                                                                                AND TRIM(b.DECOSUBCODE02) || '-' || TRIM(b.DECOSUBCODE03) = '$dt_sum_detail[KET_PRODUCT]'");
                                                        $d_roll_ready   = db2_fetch_assoc($q_roll_ready);  
                                                ?>
                                                    <tr>
                                                        <td><?= $d_demand['PRODUCTIONDEMANDCODE']; ?></td>
                                                        <td><?= $dt_ITXVIEWKK['LOT']; ?></td>
                                                        <td><?= $dt_sum_detail['LOTCODE'] ?></td>
                                                        <td>
                                                            <?php if ($d_orig_pd_code['ORIGINALPDCODE']) : ?>
                                                                <?php if ($d_cek_salinan['SALINAN_058'] == '058') : ?>
                                                                    <?= number_format($d_qtybagikain['QTY_BAGIKAIN'], 2); ?>
                                                                    <?php $totalQtyBagi += $d_qtybagikain['QTY_BAGIKAIN']; ?>
                                                                <?php else : ?>
                                                                    0
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <?= number_format($d_qtybagikain['QTY_BAGIKAIN'], 2); ?>
                                                                <?php $totalQtyBagi += $d_qtybagikain['QTY_BAGIKAIN']; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($d_orig_pd_code['ORIGINALPDCODE']) : ?>
                                                                <?php if ($d_cek_salinan['SALINAN_058'] == '058') : ?>
                                                                    0
                                                                <?php else : ?>
                                                                    <?= number_format($d_qtysalinan['USERPRIMARYQUANTITY'], 3) ?>
                                                                    <?php $totalQtySalinan += $d_qtysalinan['USERPRIMARYQUANTITY']; ?>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                0
                                                            <?php endif; ?>
                                                        </td>

                                                        <td><?= $d_roll_pengiriman['ROLL']; ?></td>
                                                        <td><?= number_format($dt_sum_detail['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                        <td><?= number_format($dt_sum_detail['QTY_SUDAH_KIRIM_2'], 2); ?></td>

                                                        <td><?= $dt_sum_detail['SALESDOCUMENTPROVISIONALCODE'] ?></td>
                                                        <td><?= $dt_sum_detail['GOODSISSUEDATE'] ?></td>

                                                        <?php $totalRollKirim += $d_roll_pengiriman['ROLL']; ?>
                                                        <?php $totalQtyKgKirim += $dt_sum_detail['QTY_SUDAH_KIRIM']; ?>
                                                        <?php $totalQtyYdMtrKirim += $dt_sum_detail['QTY_SUDAH_KIRIM_2']; ?>

                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #c9637f; font-weight: bold">
                                                    <td colspan="3">Total</td>
                                                    <td><?= number_format($totalQtyBagi, 2); ?></td>
                                                    <td><?= number_format($totalQtySalinan, 3); ?></td>
                                                    <td><?= $totalRollKirim; ?></td>
                                                    <td><?= number_format($totalQtyKgKirim, 2); ?></td>
                                                    <td><?= number_format($totalQtyYdMtrKirim, 2); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-border-danger">
                                <div class="card-header">
                                    <h4 class="card-title">Detail QTY KIRIM FOC</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;" >
                                        <table id="" class="table table-striped table-bordered nowrap" style="font-size: 11px; text-align: center;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO. SJ</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">WARNA</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO WARNA</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY SUDAH KIRIM (KG) FOC</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY SUDAH KIRIM (YD/MTR) FOC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require_once "koneksi.php";

                                                    $no_order       = $_GET['no_order'];
                                                    $orderline      = $_GET['orderline'];
                                                    
                                                    $QueryFOCKirim = "SELECT
                                                                            isqd.SALESDOCUMENTPROVISIONALCODE,
                                                                            isqd.QUALITYREASONCODE,
                                                                            isqd.ORDERLINE,
                                                                            isqd.PELANGGAN,
                                                                            TRIM(isqd.NO_ORDER) AS NO_ORDER,
                                                                            isqd.NO_PO,
                                                                            isqd.KET_PRODUCT,
                                                                            isqd.STYLE,
                                                                            isqd.LEBAR,
                                                                            isqd.GRAMASI,
                                                                            isqd.WARNA,
                                                                            isqd.NO_WARNA,
                                                                            isqd.PRICEUNITOFMEASURECODE,
                                                                            isqd.NETTO,
                                                                            isqd.NETTO_2,
                                                                            isqd.NETTO_M,
                                                                            isqd.KONVERSI,
                                                                            isqd.ACTUAL_DELIVERY,
                                                                            SUM(isqd.QTY_SUDAH_KIRIM) AS QTY_SUDAH_KIRIM,
                                                                            SUM(isqd.QTY_SUDAH_KIRIM_2) AS QTY_SUDAH_KIRIM_2,
                                                                            CASE
                                                                                WHEN DAYS(now()) - DAYS(Timestamp_Format(isqd.ACTUAL_DELIVERY, 'YYYY-MM-DD')) < 0 THEN 0
                                                                                ELSE DAYS(now()) - DAYS(Timestamp_Format(isqd.ACTUAL_DELIVERY, 'YYYY-MM-DD'))
                                                                            END	AS DELAY,
                                                                            isqd.SUBCODE01,
                                                                            isqd.SUBCODE02,
                                                                            isqd.SUBCODE03,
                                                                            isqd.SUBCODE04,
                                                                            isqd.SUBCODE05,
                                                                            isqd.SUBCODE06,
                                                                            isqd.SUBCODE07,
                                                                            isqd.SUBCODE08,
                                                                            s.STATISTICALGROUPCODE,
                                                                            ip.BUYER 
                                                                        FROM
                                                                            ITXVIEW_SUMMARY_QTY_DELIVERY isqd
                                                                        LEFT JOIN SALESORDER s ON s.CODE = isqd.NO_ORDER 
                                                                        LEFT JOIN ITXVIEW_PELANGGAN ip ON ip.ORDPRNCUSTOMERSUPPLIERCODE = s.ORDPRNCUSTOMERSUPPLIERCODE AND ip.CODE = s.CODE 
                                                                        WHERE
                                                                            isqd.NO_ORDER = '$no_order'
                                                                            AND isqd.ORDERLINE = '$orderline'
                                                                            AND isqd.QUALITYREASONCODE = 'FOC'
                                                                        GROUP BY
                                                                            isqd.SALESDOCUMENTPROVISIONALCODE,
                                                                            isqd.QUALITYREASONCODE,
                                                                            isqd.ORDERLINE,
                                                                            isqd.PELANGGAN,
                                                                            isqd.NO_ORDER,
                                                                            isqd.NO_PO,
                                                                            isqd.KET_PRODUCT,
                                                                            isqd.STYLE,
                                                                            isqd.LEBAR,
                                                                            isqd.GRAMASI,
                                                                            isqd.WARNA,
                                                                            isqd.NO_WARNA,
                                                                            isqd.PRICEUNITOFMEASURECODE,
                                                                            isqd.NETTO,
                                                                            isqd.NETTO_2,
                                                                            isqd.NETTO_M,
                                                                            isqd.KONVERSI,
                                                                            isqd.ACTUAL_DELIVERY,
                                                                            isqd.SUBCODE01,
                                                                            isqd.SUBCODE02,
                                                                            isqd.SUBCODE03,
                                                                            isqd.SUBCODE04,
                                                                            isqd.SUBCODE05,
                                                                            isqd.SUBCODE06,
                                                                            isqd.SUBCODE07,
                                                                            isqd.SUBCODE08,
                                                                            s.STATISTICALGROUPCODE,
                                                                            ip.BUYER  
                                                                        ORDER BY
                                                                            isqd.ORDERLINE ASC";
                                                
                                                    $exec_FOCKirim = db2_exec($conn1, $QueryFOCKirim);
                                                
                                                    if (!$exec_FOCKirim) {
                                                        die('Query execution failed: ' . db2_stmt_errormsg());
                                                    }
                                                    $totalQtyKirimKg = 0;
                                                    $totalQtyKirimYdMtr = 0;
                                                
                                                    while ($dt_FOCKirim = db2_fetch_assoc($exec_FOCKirim)) :
                                                    
                                                ?>
                                                    <tr>
                                                        <td><?= $dt_FOCKirim['SALESDOCUMENTPROVISIONALCODE']; ?></td>
                                                        <td><?= $dt_FOCKirim['NO_ORDER']; ?></td>
                                                        <td><?= $dt_FOCKirim['WARNA']; ?></td>
                                                        <td><?= $dt_FOCKirim['NO_WARNA']; ?></td>
                                                        <td><?= number_format($dt_FOCKirim['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                        <td><?= number_format($dt_FOCKirim['QTY_SUDAH_KIRIM_2'], 2); ?></td>

                                                        <?php $totalQtyKirimKg += (float) str_replace(',', '', $dt_FOCKirim['QTY_SUDAH_KIRIM']); ?>
                                                        <?php $totalQtyKirimYdMtr += (float) str_replace(',', '', $dt_FOCKirim['QTY_SUDAH_KIRIM_2']); ?>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" style="background-color: #c9637f; font-weight: bold"><b>Total</b></td>
                                                    <td style="background-color: #c9637f; font-weight: bold"><b><?= number_format($totalQtyKirimKg, 2); ?></b></td>
                                                    <td style="background-color: #c9637f; font-weight: bold"><b><?= number_format($totalQtyKirimYdMtr, 2); ?></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-border-warning">
                                <div class="card-header">
                                    <h4 class="card-title">Detail Qty Ready</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;" >
                                        <table id="" class="table table-striped table-bordered nowrap" style="font-size: 11px; text-align: center;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">PROD. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">PROD. DEMAND</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">KETERANGAN PRODUCT</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO WARNA</th>
                                                    <th colspan="3" style="vertical-align: middle; text-align: center;">QTY READY</th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle; text-align: center;">ROLLS</th>
                                                    <th style="vertical-align: middle; text-align: center;">KGS</th>
                                                    <th style="vertical-align: middle; text-align: center;">YARDS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    // $no_order       = $_GET['no_order'];
                                                    $ket_product    = $_GET['ket_product'];
                                                    $no_warna       = $_GET['no_warna'];
                                                    $fetch_lotcode  = $_GET['PRODUCTIONORDERCODE'];
                                                    $fetch_demand   = $_GET['PRODUCTIONDEMANDCODE'];

                                                    $query_ready          = "SELECT
                                                                                PROJECTCODE,
                                                                                LOTCODE,
                                                                                SUBSTR(ELEMENTSCODE, 1,8) AS PRODUCTIONDEMAND,
                                                                                TRIM(DECOSUBCODE02) || '-' || TRIM(DECOSUBCODE03) KET_PRODUCT,
                                                                                COUNT(ELEMENTSCODE) AS ROLL,
                                                                                SUM(BASEPRIMARYQUANTITYUNIT) AS QTY_READY,
                                                                                SUM(BASESECONDARYQUANTITYUNIT) AS QTY_READY_2
                                                                            FROM
                                                                                BALANCE b
                                                                            WHERE
                                                                                LOTCODE IN ($fetch_lotcode)
                                                                                AND SUBSTR(ELEMENTSCODE, 1,8) IN ($fetch_demand)
                                                                                AND LOGICALWAREHOUSECODE = 'M031'
                                                                                AND PROJECTCODE = '$no_order'
                                                                            GROUP BY
                                                                                PROJECTCODE,
                                                                                LOTCODE,
                                                                                SUBSTR(ELEMENTSCODE, 1,8),
                                                                                DECOSUBCODE02,
                                                                                DECOSUBCODE03
                                                                            ORDER BY
                                                                                LOTCODE ASC";
                                                    $q_ready   = db2_exec($conn1, $query_ready);
                                                    if (!$q_ready) {
                                                        die("Query ready error: " . db2_stmt_errormsg()); // Menampilkan pesan error dari DB2
                                                    }
                                                    $hasData = false; // Flag untuk mengecek apakah ada data
                                                    $totalRollQtyReady = 0;
                                                    $totalQtyReady = 0;
                                                    $totalQtyReady_2 = 0;
                                                    while ($dt_sum_detail_ready = db2_fetch_assoc($q_ready)) {
                                                        $hasData = true; // Set true jika ada data
                                                ?>
                                                    <tr>
                                                        <td><?= $dt_sum_detail_ready['PROJECTCODE']; ?></td>
                                                        <td><?= $dt_sum_detail_ready['LOTCODE']; ?></td>
                                                        <td>
                                                            <a target="_BLANK" title="Posisi KK" style="font-size: 11px; text-align: center; text-decoration: underline;" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $dt_sum_detail['PRODUCTIONDEMAND']; ?>&prod_order=<?= $dt_sum_detail['LOTCODE']; ?>">
                                                                <?= $dt_sum_detail_ready['PRODUCTIONDEMAND']; ?>
                                                            </a>
                                                        </td> <!-- DEMAND -->
                                                        <td><?= $dt_sum_detail_ready['KET_PRODUCT'] ?></td>
                                                        <td><?= $no_warna; ?></td>

                                                        <td><?= number_format($dt_sum_detail_ready['ROLL'], 0); ?></td>
                                                        <td><?= number_format($dt_sum_detail_ready['QTY_READY'], 2); ?></td>
                                                        <td><?= number_format($dt_sum_detail_ready['QTY_READY_2'], 2); ?></td>

                                                        <?php $totalRollQtyReady    += number_format($dt_sum_detail_ready['ROLL'], 0);  ?>
                                                        <?php $totalQtyReady        += number_format($dt_sum_detail_ready['QTY_READY'], 2);  ?>
                                                        <?php $totalQtyReady_2      += number_format($dt_sum_detail_ready['QTY_READY_2'], 2);  ?>
                                                    </tr>
                                                <?php } ?>
                                                <?php if (!$hasData) { // Jika tidak ada data, tampilkan baris kosong dengan pesan ?>
                                                    <tr>
                                                        <td colspan="8" style="text-align: center; font-weight: bold; color: red;">Tidak ada data ditemukan</td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #c9637f; font-weight: bold">
                                                    <td colspan="5">Total</td>
                                                    <td><?= $totalRollQtyReady; ?></td>
                                                    <td><?= $totalQtyReady; ?></td>
                                                    <td><?= $totalQtyReady_2; ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-border-success">
                                <div class="card-header">
                                    <h4 class="card-title">Detail QTY PACKING FOC</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;" >
                                        <table id="" class="table table-striped table-bordered nowrap" style="font-size: 11px; text-align: center;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY PACKING (KG) FOC</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY PACKING (YD/MTR) FOC</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require_once "koneksi.php";

                                                    $no_order       = $_GET['no_order'];
                                                    $orderline      = $_GET['orderline'];
                                                    
                                                    $QueryFOCPacking = "SELECT 
                                                                            ORDERLINE,
                                                                            PROJECTCODE,
                                                                            SUM(QTYPACKING_KG) AS QTYPACKING_KG,
                                                                            SUM(QTYPACKING_YD_MTR) AS QTYPACKING_YD_MTR
                                                                        FROM (
                                                                            SELECT
                                                                                st.ITEMELEMENTCODE,
                                                                                st.LOTCODE,
                                                                                s.ORDERLINE,
                                                                                st.QUALITYREASONCODE,
                                                                                (st.USERPRIMARYQUANTITY) AS QTYPACKING_KG,
                                                                                (st.USERSECONDARYQUANTITY) AS QTYPACKING_YD_MTR,
                                                                                st.PROJECTCODE
                                                                            FROM
                                                                                STOCKTRANSACTION st 
                                                                            LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = SUBSTR(st.ITEMELEMENTCODE, 1, 8)
                                                                            LEFT JOIN SALESORDERLINE s ON s.SALESORDERCODE = p.ORIGDLVSALORDLINESALORDERCODE AND s.ORDERLINE = p.ORIGDLVSALORDERLINEORDERLINE 
                                                                            WHERE
                                                                                st.LOGICALWAREHOUSECODE = 'M033'
                                                                                AND st.TEMPLATECODE = '303'
                                                                                AND st.PROJECTCODE = '$no_order'
                                                                                AND s.ORDERLINE = '$orderline'
                                                                            GROUP BY 
                                                                                st.ITEMELEMENTCODE,
                                                                                st.LOTCODE,
                                                                                s.ORDERLINE,
                                                                                st.QUALITYREASONCODE,
                                                                                st.USERPRIMARYQUANTITY,
                                                                                st.USERSECONDARYQUANTITY,
                                                                                st.PROJECTCODE
                                                                            ) 
                                                                        WHERE
                                                                            QUALITYREASONCODE IN ('FOC') 
                                                                        GROUP BY
                                                                            PROJECTCODE,
                                                                            ORDERLINE";
                                                
                                                    $exec_FOCPacking = db2_exec($conn1, $QueryFOCPacking);
                                                
                                                    if (!$exec_FOCPacking) {
                                                        die('Query execution failed: ' . db2_stmt_errormsg());
                                                    }
                                                    $totalQtyPackingKg = 0;
                                                    $totalQtyPackingYdMtr = 0;
                                                
                                                    while ($dt_FOCPacking = db2_fetch_assoc($exec_FOCPacking)) :
                                                    
                                                ?>
                                                    <tr>
                                                        <td><?= $dt_FOCPacking['PROJECTCODE']; ?></td>
                                                        <td><?= number_format($dt_FOCPacking['QTYPACKING_KG'], 2); ?></td>
                                                        <td><?= number_format($dt_FOCPacking['QTYPACKING_YD_MTR'], 2); ?></td>
                                                        
                                                        <?php $totalQtyPackingKg += (float) str_replace(',', '', $dt_FOCPacking['QTYPACKING_KG']); ?>
                                                        <?php $totalQtyPackingYdMtr += (float) str_replace(',', '', $dt_FOCPacking['QTYPACKING_YD_MTR']); ?>

                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #c9637f; font-weight: bold">
                                                    <td><b>Total</b></td>
                                                    <td><b><?= number_format($totalQtyPackingKg, 2); ?></b></td>
                                                    <td><b><?= number_format($totalQtyPackingYdMtr, 2); ?></b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card card-border-info">
                                <div class="card-header">
                                    <h4 class="card-title">AKJ/ Potong Qty</h4>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;" >
                                        <table id="" class="table table-striped table-bordered nowrap" style="font-size: 11px; text-align: center;" width="100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">NO. ORDER</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">LOTCODE</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY KG</th>
                                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY YD/MTR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    require_once "koneksi.php";

                                                    $no_order       = $_GET['no_order'];
                                                    $orderline      = $_GET['orderline'];

                                                    $q_subcode      = "SELECT * FROM SALESORDERLINE WHERE SALESORDERCODE = '$no_order' AND ORDERLINE = '$orderline'";
                                                    $exec_subcode   = db2_exec($conn1, $q_subcode);
                                                    $dt_subcode     = db2_fetch_assoc($exec_subcode);

                                                    $QueryDataMain          = "SELECT  
                                                                                    LISTAGG(DISTINCT '''' || TRIM(s.TRANSACTIONNUMBER) || '''', ', ') AS TRANSACTIONNUMBER
                                                                                FROM
                                                                                    STOCKTRANSACTION s
                                                                                WHERE
                                                                                    s.LOGICALWAREHOUSECODE = 'M031'
                                                                                    AND s.PROJECTCODE = '$no_order'
                                                                                    AND (s.TEMPLATECODE = '313' OR s.TEMPLATECODE = '098')
                                                                                    AND s.DECOSUBCODE01 = '$dt_subcode[SUBCODE01]'
                                                                                    AND s.DECOSUBCODE02 = '$dt_subcode[SUBCODE02]' 
                                                                                    AND s.DECOSUBCODE03 = '$dt_subcode[SUBCODE03]'
                                                                                    AND s.DECOSUBCODE04 = '$dt_subcode[SUBCODE04]'
                                                                                    AND s.DECOSUBCODE05 = '$dt_subcode[SUBCODE05]'
                                                                                    AND s.DECOSUBCODE06 = '$dt_subcode[SUBCODE06]'
                                                                                    AND s.DECOSUBCODE07 = '$dt_subcode[SUBCODE07]'
                                                                                    AND s.DECOSUBCODE08 = '$dt_subcode[SUBCODE08]'";
                                                    $DataMain   = db2_exec($conn1, $QueryDataMain);
                                                    $RowDataMain   = db2_fetch_assoc($DataMain);

                                                    if (!empty($RowDataMain['TRANSACTIONNUMBER'])) {
                                                        // Pastikan TRANSACTIONNUMBER sudah dibersihkan jika merupakan string.
                                                        $transactionNumbers = is_array($RowDataMain['TRANSACTIONNUMBER']) ? implode(',', $RowDataMain['TRANSACTIONNUMBER']) : $RowDataMain['TRANSACTIONNUMBER'];
                                                    
                                                        $QueryDataDetail = "SELECT DISTINCT 
                                                                                s.PROJECTCODE,
                                                                                s.LOTCODE,
                                                                                SUM(s.USERPRIMARYQUANTITY) AS QTY_KG,
                                                                                SUM(s.USERSECONDARYQUANTITY) AS QTY_YD_MTR
                                                                            FROM
                                                                                STOCKTRANSACTION s
                                                                            WHERE
                                                                                s.TRANSACTIONNUMBER IN ($transactionNumbers)  
                                                                                AND  (s.TEMPLATECODE = '314' OR s.TEMPLATECODE = '098')
                                                                            GROUP BY
                                                                                s.PROJECTCODE,
                                                                                s.LOTCODE";
                                                    
                                                        $q_sum_po_selesai = db2_exec($conn1, $QueryDataDetail);
                                                    
                                                        if (!$q_sum_po_selesai) {
                                                            die('Query execution failed: ' . db2_stmt_errormsg());
                                                        }
                                                    
                                                        $totalQtyKg = 0;
                                                        $totalQtyYdMtr = 0;
                                                    
                                                        while ($dt_sum_detail = db2_fetch_assoc($q_sum_po_selesai)) {
                                                    
                                                ?>
                                                    <tr>
                                                        <td><?= $dt_sum_detail['PROJECTCODE']; ?></td>
                                                        <td><?= $dt_sum_detail['LOTCODE']; ?></td>
                                                        <td><?= number_format($dt_sum_detail['QTY_KG'], 2); ?></td>
                                                        <td><?= number_format($dt_sum_detail['QTY_YD_MTR'], 2); ?></td>
                                                    </tr>
                                                    <?php $totalQtyKg += (float) str_replace(',', '', $dt_sum_detail['QTY_KG']); ?>
                                                    <?php $totalQtyYdMtr += (float) str_replace(',', '', $dt_sum_detail['QTY_YD_MTR']); ?>
                                                <?php } }else { ?>
                                                    <tr>
                                                        <td colspan="4" style="text-align: center; font-weight: bold; color: red;">Tidak ada data ditemukan</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #c9637f; font-weight: bold">
                                                    <td colspan="2" style="text-align: center;">Total</td>
                                                    <td><?= number_format($totalQtyKg, 2); ?></td>
                                                    <td><?= number_format($totalQtyYdMtr, 2); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<?php require_once 'footer.php'; ?>

<script>
    $('#ExportToExcel_kirim').DataTable({
        dom: 'Bfrtip', // Mengatur tata letak tombol
        buttons: [{
            extend: 'excelHtml5',
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                // Menyesuaikan kolom berdasarkan kondisi tertentu
                $('row c[r^="F"]', sheet).each(function() {
                    if ($('is t', this).text().replace(/[^\d]/g, '') * 1 >= 500000) {
                        $(this).attr('s', '20'); // Memberikan style khusus untuk nilai >= 500000
                    }
                });
            }
        }],
        scrollCollapse: true, // Mengizinkan tabel mengecil sesuai isi
        paging: false, // Menonaktifkan pagination
        fixedHeader: true, // Header tetap terlihat saat scroll
        searching: false, // Menonaktifkan fitur pencarian
        ordering: false, // Menonaktifkan fitur pengurutan
        autoWidth: false, // Mencegah tabel secara otomatis menambahkan lebar kolom
    });
</script>