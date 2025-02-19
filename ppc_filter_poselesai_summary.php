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
                                                    <input type="text" name="no_order" class="form-control" onkeyup="this.value = this.value.toUpperCase()" value="<?php if (isset($_POST['submit'])) { echo $_POST['no_order']; } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Nomor PO</h4>
                                                    <input type="text" name="no_po" class="form-control" value="<?php if (isset($_POST['submit'])) { echo $_POST['no_po']; } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Dari Tgl Aktual Delivery</h4>
                                                    <input type="date" name="tgl1" class="form-control" value="<?= isset($_POST['submit']) ? $_POST['tgl1'] : '' ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Sampai Tgl Aktual Delivery</h4>
                                                    <input type="date" name="tgl2" class="form-control" value="<?= isset($_POST['submit']) ? $_POST['tgl2'] : '' ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Buyer</h4>
                                                    <?php
                                                        require_once "koneksi.php";
                                                        $q_buyer    = db2_exec($conn1, "SELECT DISTINCT 
                                                                                                BUYER
                                                                                            FROM
                                                                                                ITXVIEW_PELANGGAN 
                                                                                            WHERE 
                                                                                                NOT BUYER IS NULL");
                                                    ?>
                                                    <select class="form-control input-xl" name="buyer">
                                                        <option selected disabled value="">-</option>
                                                        <?php while ($d_buyer = db2_fetch_assoc($q_buyer)) { ?>
                                                            <option value="<?= $d_buyer['BUYER']; ?>" 
                                                            <?php
                                                            if (isset($_POST['submit'])) {
                                                                if ($d_buyer['BUYER'] == $_POST['buyer']) {
                                                                    echo "SELECTED";
                                                                }
                                                            }
                                                            ?>><?= $d_buyer['BUYER']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-xl-2 m-b-30">
                                                    <h4 class="sub-title">Season</h4>
                                                    <?php
                                                        require_once "koneksi.php";
                                                        $q_season    = db2_exec($conn1, "SELECT CODE, LONGDESCRIPTION FROM STATISTICALGROUP ORDER BY CODE ASC");
                                                    ?>
                                                    <select class="form-control input-xl" name="season">
                                                        <option selected disabled value="">-</option>
                                                        <?php while ($d_season = db2_fetch_assoc($q_season)) { ?>
                                                            <option value="<?= $d_season['CODE']; ?>" 
                                                            <?php
                                                            if (isset($_POST['submit'])) {
                                                                if ($d_season['CODE'] == $_POST['season']) {
                                                                    echo "SELECTED";
                                                                }
                                                            }
                                                            ?>><?= $d_season['CODE']; ?> - <?= $d_season['LONGDESCRIPTION']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-xl-1 m-b-30">
                                                    <h4 style="font-size: 12px;" class="sub-title">Article Group</h4>
                                                    <input type="text" name="article_group" class="form-control" value="<?php if (isset($_POST['submit'])) { echo $_POST['article_group']; } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-1 m-b-30">
                                                    <h4 style="font-size: 12px;" class="sub-title">Article Code</h4>
                                                    <input type="text" name="article_code" class="form-control" value="<?php if (isset($_POST['submit'])) {echo $_POST['article_code']; } ?>">
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
                                            <div class="dt-responsive table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                                                <table id="excel-LA" class="table table-striped table-bordered nowrap" style="overflow-x: auto; overflow-y: auto;">
                                                    <thead>
                                                        <tr>
                                                            <th>OPSI</th>
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
                                                            <th>TGL ESTIMASI PACKING</th>
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
                                                            <th>KONVERSI</th>
                                                            <th title="PENGAMBILAN LAPORAN PENGIRIMAN">QTY SUDAH KIRIM (KG)</th>
                                                            <th title="PENGAMBILAN LAPORAN PENGIRIMAN">QTY SUDAH KIRIM (YD/MTR)</th>
                                                            <th>QTY SELISIH KIRIM (KG)</th>
                                                            <th>QTY SELISIH KIRIM (YD/MTR)</th>
                                                            <th title="QTY NETTO - QTY KIRIM">QTY KURANG KIRIM (KG)</th>
                                                            <th title="QTY NETTO - QTY KIRIM">QTY KURANG KIRIM (YD/MTR)</th>
                                                            <th title="QTY KURANG (YD/MTR)/KONVERSI">QTY KURANG (KG)</th>
                                                            <th title="QTY NETTO - QTY KIRIM - QTY READY">QTY KURANG (YD/MTR)</th>
                                                            <th title="AMBIL DARI BALANCE">QTY READY (KG)</th>
                                                            <th title="AMBIL DARI BALANCE">QTY READY (YD/MTR)</th>
                                                            <th title="DELIVERY ACTUAL - TANGGAL HARI INI">DELAY</th>
                                                            <th>LOSS MASTER (KG)</th>
                                                            <th title="(Total Qty Bruto - Qty Packing) / Total Qty Bruto * 100%">LOSS AKTUAL (KG)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            ini_set("error_reporting", 1);
                                                            session_start();
                                                            require_once "koneksi.php";

                                                            $wheres = [];

                                                            if($_POST['no_order']){
                                                                $wheres[] = "isqd.NO_ORDER = '$_POST[no_order]'";
                                                            }
                                                            if($_POST['no_po']){
                                                                $wheres[] = "isqd.NO_PO = '$_POST[no_po]'";
                                                            }
                                                            if($_POST['tgl1'] && $_POST['tgl2']) {
                                                                $wheres[] = "isqd.ACTUAL_DELIVERY BETWEEN '$_POST[tgl1]' AND '$_POST[tgl2]'";
                                                            }
                                                            
                                                            if($_POST['season']){
                                                                $wheres[] = "s.STATISTICALGROUPCODE = '$_POST[season]'";
                                                            }
                                                            if($_POST['article_group'] && $_POST['article_code']){
                                                                $wheres[] = "isqd.SUBCODE02 = '$_POST[article_group]' AND isqd.SUBCODE03 = '$_POST[article_code]'";
                                                            }
                                                            if($_POST['buyer']){
                                                                $wheres[] = "ip.BUYER = '$_POST[buyer]'";
                                                            }

                                                            $where_and = implode(" AND ", $wheres);

                                                            $q_sum_po_selesai   = db2_exec($conn1, "SELECT
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
                                                                                                    $where_and
                                                                                                GROUP BY
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
                                                                                                    isqd.ORDERLINE ASC");
                                                            $totalQtyBrutoKg    = 0;
                                                            $totalQtyBrutoYdMtr = 0;
                                                            $totalQtyTotalBrutoKg    = 0;
                                                            $totalQtyTotalBrutoYdMtr = 0;
                                                            $totalQtyPackingKg    = 0;
                                                            $totalQtyPackingYdMtr = 0;
                                                            $totalQtySelisihKirimKg = 0;
                                                            $totalQtySelisihKirimYdMtr = 0;
                                                            while ($dt_sum = db2_fetch_assoc($q_sum_po_selesai)) :
                                                                $qty_bruto  = "SELECT 
                                                                                    LISTAGG(DISTINCT '''' || TRIM(CODE) || '''', ', ') AS PROUDUCTIONDEMANDCODE,
                                                                                    SUM(USERPRIMARYQUANTITY) AS BRUTO_KG,
                                                                                    SUM(USERSECONDARYQUANTITY) AS BRUTO_YD_MTR
                                                                                FROM
                                                                                    ITXVIEW_KGBRUTO
                                                                                WHERE
                                                                                    PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                    AND ORIGDLVSALORDERLINEORDERLINE = '$dt_sum[ORDERLINE]'
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
                                                                                                AND ik.ORIGDLVSALORDERLINEORDERLINE = '$dt_sum[ORDERLINE]'
                                                                                                AND ik.ITEMTYPE_DEMAND = 'KFF'
                                                                                                AND a.VALUESTRING = '058'";
                                                                $q_bagikain_salinan     = db2_exec($conn1, $qty_bagikain_salinan);
                                                                $dt_bagikain_salinan    = db2_fetch_assoc($q_bagikain_salinan);

                                                                $ResultLotCode  = "SELECT 
                                                                                        LISTAGG('''' || TRIM(PRODUCTIONORDERCODE) || '''', ', ' ) AS PRODUCTIONORDERCODE,
                                                                                        LISTAGG('''' || TRIM(PRODUCTIONDEMANDCODE) || '''', ', ' ) AS PRODUCTIONDEMANDCODE
                                                                                    FROM 
                                                                                        ITXVIEWKK
                                                                                    WHERE 
                                                                                        PROJECTCODE = '$dt_sum[NO_ORDER]' 
                                                                                        AND ITEMTYPEAFICODE = 'KFF'
                                                                                        AND ORIGDLVSALORDERLINEORDERLINE = '$dt_sum[ORDERLINE]'";
                                                                $exec_lotcode   = db2_exec($conn1, $ResultLotCode);
                                                                $fetch_lotcode  = db2_fetch_assoc($exec_lotcode);

                                                                if($fetch_lotcode['PRODUCTIONORDERCODE']){
                                                                    $query          = "SELECT
                                                                                            SUM(BASEPRIMARYQUANTITYUNIT) AS QTY_READY,
                                                                                            SUM(BASESECONDARYQUANTITYUNIT) AS QTY_READY_2
                                                                                        FROM
                                                                                            BALANCE b
                                                                                        WHERE
                                                                                            LOTCODE IN ($fetch_lotcode[PRODUCTIONORDERCODE])
                                                                                            AND LEFT(ELEMENTSCODE, 8) IN ($fetch_lotcode[PRODUCTIONDEMANDCODE])
                                                                                            AND LOGICALWAREHOUSECODE = 'M031'
                                                                                            AND PROJECTCODE = '$dt_sum[NO_ORDER]'";
                                                                    $q_qty_ready   = db2_exec($conn1, $query);
                                                                    $d_qty_ready   = db2_fetch_assoc($q_qty_ready);
                                                                    
                                                                    $qty_packing     = "SELECT 
                                                                                            ORDERLINE,
                                                                                            SUM(QTYPACKING_KG) AS QTYPACKING_KG,
                                                                                            SUM(QTYPACKING_YD_MTR) AS QTYPACKING_YD_MTR
                                                                                        FROM (
                                                                                            SELECT
                                                                                                st.ITEMELEMENTCODE,
                                                                                                st.LOTCODE,
                                                                                                s.ORDERLINE,
                                                                                                st.QUALITYREASONCODE,
                                                                                                (st.USERPRIMARYQUANTITY) AS QTYPACKING_KG,
                                                                                                (st.USERSECONDARYQUANTITY) AS QTYPACKING_YD_MTR
                                                                                            FROM
                                                                                                STOCKTRANSACTION st 
                                                                                            LEFT JOIN PRODUCTIONDEMAND p ON p.CODE = SUBSTR(st.ITEMELEMENTCODE, 1, 8)
                                                                                            LEFT JOIN SALESORDERLINE s ON s.SALESORDERCODE = p.ORIGDLVSALORDLINESALORDERCODE AND s.ORDERLINE = p.ORIGDLVSALORDERLINEORDERLINE 
                                                                                            WHERE
                                                                                                st.LOGICALWAREHOUSECODE = 'M033'
                                                                                                AND st.TEMPLATECODE = '303'
                                                                                                AND st.PROJECTCODE = '$dt_sum[NO_ORDER]'
                                                                                                AND s.ORDERLINE = '$dt_sum[ORDERLINE]'
                                                                                            GROUP BY 
                                                                                                st.ITEMELEMENTCODE,
                                                                                                st.LOTCODE,
                                                                                                s.ORDERLINE,
                                                                                                st.QUALITYREASONCODE,
                                                                                                st.USERPRIMARYQUANTITY,
                                                                                                st.USERSECONDARYQUANTITY
                                                                                            ) 
                                                                                        WHERE
                                                                                            QUALITYREASONCODE IN ('FOC','SA', 'SD', 'SF', 'SG', 'SM', 'SP', 'SR', 'ST', '100') OR QUALITYREASONCODE IS NULL
                                                                                        GROUP BY
                                                                                            ORDERLINE";
                                                                    $q_packing       = db2_exec($conn1, $qty_packing);
                                                                    $dt_packing      = db2_fetch_assoc($q_packing);
                                                                }

                                                                // Pastikan data ada dan tidak kosong
                                                                if (empty($dt_bruto['PROUDUCTIONDEMANDCODE'])) {
                                                                    error_log("Warning: PROUDUCTIONDEMANDCODE kosong.");
                                                                    $highestFinalScheduledDate = ''; // Tetap lanjutkan dengan data kosong
                                                                } else {
                                                                    // Bersihkan dan format data agar sesuai untuk SQL
                                                                    $codesArray = array_filter((array) $dt_bruto['PROUDUCTIONDEMANDCODE']); // Hapus nilai kosong

                                                                    if (!empty($codesArray)) {
                                                                        $codes = implode(",", array_map(fn($code) => "'" . trim($code) . "'", $codesArray));

                                                                        $query = "SELECT HIGHESTFINALSCHEDULEDDATE 
                                                                                FROM SCHEDULESOFSTEPS 
                                                                                WHERE CODE IN ($codes) 
                                                                                AND FIRSTSCHEDULEDWORKCENTERCODE = 'P3IN3'";

                                                                        // Debugging: tampilkan query sebelum dieksekusi (opsional)
                                                                        error_log("Debug Query: " . $query);

                                                                        $q_schedules_of_steps = @db2_exec($conn1, $query); // Tambahkan '@' untuk suppress error

                                                                        // Cek jika query gagal
                                                                        if (!$q_schedules_of_steps) {
                                                                        // error_log("Query gagal: " . db2_stmt_errormsg($conn1));
                                                                            $highestFinalScheduledDate = ''; // Tetap lanjutkan dengan data kosong
                                                                        } else {
                                                                            // Ambil hasil query
                                                                            $d_schedules_of_steps = db2_fetch_assoc($q_schedules_of_steps) ?? [];
                                                                            $highestFinalScheduledDate = $d_schedules_of_steps['HIGHESTFINALSCHEDULEDDATE'] ?? '';
                                                                        }
                                                                    } else {
                                                                        error_log("Warning: Tidak ada kode yang valid untuk query.");
                                                                        $highestFinalScheduledDate = '';
                                                                    }
                                                                }
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <a target="_blank" class="link-opacity-10" href="ppc_filter_poselesai_summary_detail.php?no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>&orderline=<?= $dt_sum['ORDERLINE']; ?>&PRODUCTIONORDERCODE=<?= $fetch_lotcode['PRODUCTIONORDERCODE'] ?>&PRODUCTIONDEMANDCODE=<?= $fetch_lotcode['PRODUCTIONDEMANDCODE'] ?>"><i class="icofont icofont-link"></i> Detail</a><br>
                                                                <!-- <a target="_blank" class="link-opacity-10" href="ppc_filter_poselesai_summary_detail_ready.php?PRODUCTIONORDERCODE=<?= $fetch_lotcode['PRODUCTIONORDERCODE'] ?>&PRODUCTIONDEMANDCODE=<?= $fetch_lotcode['PRODUCTIONDEMANDCODE'] ?>&no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>"><i class="icofont icofont-link"></i> Detail Qty Ready</a><br> -->
                                                                <!-- <a target="_blank" class="link-opacity-10" href="ppc_filter_poselesai_summary_detail_selisih_kirim.php?no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>&orderline=<?= $dt_sum['ORDERLINE']; ?>"><i class="icofont icofont-link"></i> Detail Qty Selisih Kirim</a><br> -->
                                                                <a target="_blank" class="link-opacity-10" href="https://online.indotaichen.com/laporan/ppc_filter.php?no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>&orderline=<?= $dt_sum['ORDERLINE']; ?>&kkoke="><i class="icofont icofont-link"></i> Detail Memo Penting</a><br>
                                                                <!-- <a target="_blank" class="link-opacity-10" href="ppc_filter_poselesai_summary_detail_foc_packing_kirim.php?no_order=<?= TRIM($dt_sum['NO_ORDER']); ?>&orderline=<?= $dt_sum['ORDERLINE']; ?>"><i class="icofont icofont-link"></i> Detail Qty FOC Packing & Kirim</a><br> -->
                                                            </td>
                                                            <td><?= $dt_sum['PELANGGAN']; ?></td>
                                                            <td><?= $dt_sum['NO_ORDER']; ?> - <?= $dt_sum['ORDERLINE']; ?></td>
                                                            <td><?= $dt_sum['NO_PO']; ?></td>
                                                            <td><?= $dt_sum['KET_PRODUCT']; ?></td>
                                                            <td><?= $dt_sum['STYLE']; ?></td>
                                                            <td align="center"><?= number_format($dt_sum['LEBAR'], 0); ?></td>
                                                            <td align="center"><?= number_format($dt_sum['GRAMASI'], 0); ?></td>
                                                            <td><?= $dt_sum['WARNA']; ?></td>
                                                            <td><?= $dt_sum['NO_WARNA']; ?></td>
                                                            <td><?= $dt_sum['ACTUAL_DELIVERY']; ?></td>
                                                            <td><?= $highestFinalScheduledDate ?: ""; ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO'], 2); ?></td>
                                                            <td align="right">
                                                                <?php
                                                                    if(TRIM($dt_sum['PRICEUNITOFMEASURECODE']) == 'm'){
                                                                        echo number_format($dt_sum['NETTO_M'] ?? 2, 0);
                                                                    }else{
                                                                        echo number_format($dt_sum['NETTO_2'] ?? 2, 0);
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
                                                            <td align="center"><?= $dt_sum['KONVERSI']; ?></td>
                                                            <td align="right"><?= number_format($dt_sum['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['QTY_SUDAH_KIRIM_2'], 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_packing['QTYPACKING_KG'] - $dt_sum['QTY_SUDAH_KIRIM'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format(str_replace(',', '', number_format($dt_packing['QTYPACKING_YD_MTR'] - $dt_sum['QTY_SUDAH_KIRIM_2'], 2)), 2); ?></td>
                                                            <td align="right"><?= number_format($dt_sum['NETTO']-$dt_sum['QTY_SUDAH_KIRIM'], 2); ?></td>
                                                            <td align="right">
                                                                <?= number_format(
                                                                    (trim($dt_sum['PRICEUNITOFMEASURECODE']) == 'm' ? $dt_sum['NETTO_M'] : $dt_sum['NETTO_2']) - $dt_sum['QTY_SUDAH_KIRIM_2'], 2); ?>
                                                            </td>
                                                            <td align="right">
                                                                <?= number_format(
                                                                    ((trim($dt_sum['PRICEUNITOFMEASURECODE']) == 'm' ? $dt_sum['NETTO_M'] : $dt_sum['NETTO_2']) - $dt_sum['QTY_SUDAH_KIRIM_2']-$d_qty_ready['QTY_READY_2'])/$dt_sum['KONVERSI'], 2); ?>

                                                            </td><!-- QTY KURANG (KG) -->
                                                            <td align="right">
                                                                <?= number_format(
                                                                    (trim($dt_sum['PRICEUNITOFMEASURECODE']) == 'm' ? $dt_sum['NETTO_M'] : $dt_sum['NETTO_2']) - $dt_sum['QTY_SUDAH_KIRIM_2']-$d_qty_ready['QTY_READY_2'], 2); ?>

                                                            </td> <!-- QTY KURANG (YD/MTR) -->
                                                            <td align="right"><?= number_format($d_qty_ready['QTY_READY'], 2); ?></td>
                                                            <td align="right"><?= number_format($d_qty_ready['QTY_READY_2'], 2); ?></td>
                                                            <td><?= $dt_sum['DELAY']; ?></td>
                                                            <?php $totalQtyBrutoKg += (float) str_replace(',', '', $dt_bruto['BRUTO_KG']); ?>
                                                            <?php $totalQtyBrutoYdMtr += (float) str_replace(',', '', $dt_bruto['BRUTO_YD_MTR']); ?>
                                                            <?php $totalQtyTotalBrutoKg += (float) str_replace(',', '', $dt_bruto['BRUTO_KG'] + $dt_bagikain_salinan['SALINAN_KG']); ?>
                                                            <?php $totalQtyTotalBrutoYdMtr += (float) str_replace(',', '', $dt_bruto['BRUTO_YD_MTR'] + $dt_bagikain_salinan['SALINAN_YD_MTR']); ?>
                                                            <?php $totalQtyPackingKg += (float) str_replace(',', '', $dt_packing['QTYPACKING_KG']); ?>
                                                            <?php $totalQtyPackingYdMtr += (float) str_replace(',', '', $dt_packing['QTYPACKING_YD_MTR']); ?>
                                                            <?php $totalQtySelisihKirimKg += (float) str_replace(',', '', $dt_packing['QTYPACKING_KG'] - $dt_sum['QTY_SUDAH_KIRIM']); ?>
                                                            <?php $totalQtySelisihKirimYdMtr += (float) str_replace(',', '', $dt_packing['QTYPACKING_YD_MTR'] - $dt_sum['QTY_SUDAH_KIRIM_2']); ?>
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
                                                        </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyBrutoKg, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyBrutoYdMtr, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyTotalBrutoKg, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyTotalBrutoYdMtr, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyPackingKg, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtyPackingYdMtr, 2); ?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtySelisihKirimKg, 2); ?></b></td>
                                                            <td style="background-color: #eb9dae;"><b><?= number_format($totalQtySelisihKirimYdMtr, 2); ?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
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
        }],
        scrollCollapse: true, // Mengaktifkan collapse pada scroll
        paging: false, // Menonaktifkan pagination
        fixedHeader: true // Menjaga header tetap terlihat saat scroll
    });

</script>
<?php require_once 'footer.php'; ?>