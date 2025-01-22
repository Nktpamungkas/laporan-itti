<style>
    /* Gaya untuk tabel */
    table {
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%; /* Sesuaikan lebar tabel dengan kontainer */
    }

    /* Gaya untuk header tabel */
    th {
        border: 1px solid black;
        padding: 8px; /* Memberikan jarak di dalam sel */
        text-align: center; /* Meluruskan teks ke tengah */
        background-color: #f2f2f2; /* Memberikan warna latar belakang */
    }

    /* Gaya untuk sel tabel */
    td {
        border: 1px solid black;
        padding: 8px; /* Memberikan jarak di dalam sel */
        text-align: left; /* Meluruskan teks ke kiri */
    }
</style>

<center>
    <h3>AKJ/ Potong Qty</h3>
    <table style="width:50%">
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
                    $transactionNumbers = is_array($RowDataMain['TRANSACTIONNUMBER']) 
                        ? implode(',', $RowDataMain['TRANSACTIONNUMBER']) 
                        : $RowDataMain['TRANSACTIONNUMBER'];
                
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
            <?php 
                } }else {
                    die('TRANSACTIONNUMBER is empty or undefined.');
                }
            ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #c9637f; font-weight: bold">
                <td colspan="2" style="text-align: center;">Total</td>
                <td><?= number_format($totalQtyKg, 2); ?></td>
                <td><?= number_format($totalQtyYdMtr, 2); ?></td>
            </tr>
        </tfoot>
    </table>
</center>