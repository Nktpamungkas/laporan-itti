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
    <h3>Detail QTY PACKING FOC</h3>
    <table style="width:50%">
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
            
                while ($dt_FOCPacking = db2_fetch_assoc($exec_FOCPacking)) :
                
            ?>
                <tr>
                    <td><?= $dt_FOCPacking['PROJECTCODE']; ?></td>
                    <td><?= number_format($dt_FOCPacking['QTYPACKING_KG'], 2); ?></td>
                    <td><?= number_format($dt_FOCPacking['QTYPACKING_YD_MTR'], 2); ?></td>

                </tr>
             <?php endwhile; ?>
        </tbody>
    </table>
</center>

<center>
    <h3>Detail QTY KIRIM FOC</h3>
    <table style="width:50%">
        <thead>
            <tr>
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
            
                while ($dt_FOCKirim = db2_fetch_assoc($exec_FOCKirim)) :
                
            ?>
                <tr>
                    <td><?= $dt_FOCKirim['NO_ORDER']; ?></td>
                    <td><?= $dt_FOCKirim['WARNA']; ?></td>
                    <td><?= $dt_FOCKirim['NO_WARNA']; ?></td>
                    <td><?= number_format($dt_FOCKirim['QTY_SUDAH_KIRIM'], 2); ?></td>
                    <td><?= number_format($dt_FOCKirim['QTY_SUDAH_KIRIM_2'], 2); ?></td>

                </tr>
             <?php endwhile; ?>
        </tbody>
    </table>
</center>
