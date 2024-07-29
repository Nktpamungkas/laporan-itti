<table border="1">
    <thead>
        <tr>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">PROD DEMAND</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">LOT</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">PROD ORDER</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY BAGI</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">QTY SALINAN</th>

            <th colspan="3" style="vertical-align: middle; text-align: center;">QTY KIRIM</th>

            <th rowspan="2" style="vertical-align: middle; text-align: center;">NO SJ</th>
            <th rowspan="2" style="vertical-align: middle; text-align: center;">TGL KIRIM</th>

            <th colspan="3" style="vertical-align: middle; text-align: center;">QTY READY</th>

            <th rowspan="2" style="vertical-align: middle; text-align: center;">STATUS TERAKHIR</th> 
        </tr>
        <tr>
            <th style="vertical-align: middle; text-align: center;">ROLLS</th>
            <th style="vertical-align: middle; text-align: center;">KGS</th>
            <th style="vertical-align: middle; text-align: center;">YARDS</th>
            
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
                                    QTY_SUDAH_KIRIM,
                                    QTY_SUDAH_KIRIM_2,
                                    QTY_READY,
                                    QTY_READY2
                                FROM 
                                    ITXVIEW_SUMMARY_QTY_DELIVERY 
                                WHERE 
                                    NO_ORDER = '$no_order' 
                                    AND ORDERLINE = '$orderline' 
                                ORDER BY 
                                    SALESDOCUMENTPROVISIONALCODE 
                                    ASC";

            $q_sum_po_selesai   = db2_exec($conn1, $query);
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
                        <?php else : ?>
                            0
                        <?php endif; ?>
                    <?php else : ?>
                        <?= number_format($d_qtybagikain['QTY_BAGIKAIN'], 2); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($d_orig_pd_code['ORIGINALPDCODE']) : ?>
                        <?php if ($d_cek_salinan['SALINAN_058'] == '058') : ?>
                            0
                        <?php else : ?>
                            <?= number_format($d_qtysalinan['USERPRIMARYQUANTITY'], 3) ?>
                        <?php endif; ?>
                    <?php else : ?>
                        0
                    <?php endif; ?>
                </td>

                <td><?= $d_roll_pengiriman['ROLL']; ?></td>
                <td><?= $dt_sum_detail['QTY_SUDAH_KIRIM'] ?></td>
                <td><?= $dt_sum_detail['QTY_SUDAH_KIRIM_2'] ?></td>

                <td><?= $dt_sum_detail['SALESDOCUMENTPROVISIONALCODE'] ?></td>
                <td><?= $dt_sum_detail['GOODSISSUEDATE'] ?></td>

                <td><?= $d_roll_ready['ROLL']; ?></td>
                <td><?= $dt_sum_detail['QTY_READY'] ?></td>
                <td><?= $dt_sum_detail['QTY_READY2'] ?></td>

                <td></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>