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
            $query          = "SELECT * FROM ITXVIEW_SUMMARY_QTY_DELIVERY WHERE NO_ORDER = '$no_order' AND ORDERLINE = '$orderline' ORDER BY ORDERLINE ASC";

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
            <?php if($d_demand['PRODUCTIONDEMANDCODE']) : ?>
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
            <?php else : ?>
                <?php
                    $query          = "SELECT
                                            *
                                        FROM
                                            ITXVIEW_MEMOPENTINGPPC
                                        WHERE
                                            NO_ORDER = '$no_order'
                                            AND ORDERLINE = '$orderline'";

                    $q_ITXVIEWKK   = db2_exec($conn1, $query);
                    while ($rowdb2 = db2_fetch_assoc($q_ITXVIEWKK)) :
                ?>
                <?php
                    //Deteksi Production Demand Closed Atau Belum
                    if ($rowdb2['PROGRESSSTATUS_DEMAND'] == 6) {
                        $status = 'AAA';
                        $kode_dept          = '-';
                        $status_terakhir    = '-';
                        $status_operation   = 'KK Oke';
                    } else {
                        // 1. Deteksi Production Order Closed Atau Belum
                        if ($rowdb2['PROGRESSSTATUS'] == 6) {
                            $status = 'AA';
                            $kode_dept          = '-';
                            $status_terakhir    = '-';
                            $status_operation   = 'KK Oke';
                        } else {
                            // mendeteksi statusnya close
                            $q_deteksi_status_close = db2_exec($conn1, "SELECT 
                                                                            p.PRODUCTIONORDERCODE AS PRODUCTIONORDERCODE, 
                                                                            -- CASE
                                                                            --     WHEN TRIM(p.STEPTYPE) = '0' THEN p.GROUPSTEPNUMBER
                                                                            --     WHEN TRIM(p.STEPTYPE) = '3' THEN p2.STEPNUMBER 
                                                                            --     ELSE p.GROUPSTEPNUMBER
                                                                            -- END AS GROUPSTEPNUMBER,
                                                                            TRIM(p.GROUPSTEPNUMBER) AS GROUPSTEPNUMBER,
                                                                            TRIM(p.PROGRESSSTATUS) AS PROGRESSSTATUS
                                                                        FROM 
                                                                            VIEWPRODUCTIONDEMANDSTEP p
                                                                        -- LEFT JOIN PRODUCTIONDEMANDSTEP p2 ON p2.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND p2.STEPTYPE = p.STEPTYPE AND p2.OPERATIONCODE = p.OPERATIONCODE 
                                                                        WHERE
                                                                            p.PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND
                                                                            (p.PROGRESSSTATUS = '3' OR p.PROGRESSSTATUS = '2') ORDER BY p.GROUPSTEPNUMBER DESC LIMIT 1");
                            $row_status_close = db2_fetch_assoc($q_deteksi_status_close);

                            // UNTUK DELAY PROGRESS STATUS PERMINTAAN MS. AMY
                            if ($row_status_close['PROGRESSSTATUS'] == '2') { // KALAU PROGRESS STATUSNYA ENTERED
                                $q_delay_progress_selesai   = db2_exec($conn1, "SELECT 
                                                                                        p.PRODUCTIONORDERCODE AS PRODUCTIONORDERCODE, 
                                                                                        CASE
                                                                                            WHEN TRIM(p.STEPTYPE) = '0' THEN p.GROUPSTEPNUMBER
                                                                                            WHEN TRIM(p.STEPTYPE) = '3' THEN p2.STEPNUMBER 
                                                                                            WHEN TRIM(p.STEPTYPE) = '1' THEN p2.STEPNUMBER
                                                                                            ELSE p.GROUPSTEPNUMBER
                                                                                        END AS GROUPSTEPNUMBER,
                                                                                        iptip.MULAI,
                                                                                        DAYS(CURRENT DATE) - DAYS(iptip.MULAI) AS DELAY_PROGRESSSTATUS,
                                                                                        p.PROGRESSSTATUS AS PROGRESSSTATUS
                                                                                    FROM 
                                                                                        PRODUCTIONDEMANDSTEP p
                                                                                    LEFT JOIN PRODUCTIONDEMANDSTEP p2 ON p2.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND p2.STEPTYPE = p.STEPTYPE AND p2.OPERATIONCODE = p.OPERATIONCODE 
                                                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_IN_PRODORDER iptip ON iptip.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND iptip.DEMANDSTEPSTEPNUMBER = p.STEPNUMBER
                                                                                    WHERE
                                                                                        p.PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND p.PROGRESSSTATUS = '2' ORDER BY p.GROUPSTEPNUMBER DESC LIMIT 1");
                                $d_delay_progress_selesai   = db2_fetch_assoc($q_delay_progress_selesai);
                                $jam_status_terakhir        = $d_delay_progress_selesai['MULAI'];
                                $delay_progress_status      = $d_delay_progress_selesai['DELAY_PROGRESSSTATUS'] . ' Hari';
                            } elseif ($row_status_close['PROGRESSSTATUS'] == '3') { // KALAU PROGRESS STATUSNYA PROGRESS
                                $q_delay_progress_mulai   = db2_exec($conn1, "SELECT 
                                                                                        p.PRODUCTIONORDERCODE AS PRODUCTIONORDERCODE, 
                                                                                        CASE
                                                                                            WHEN TRIM(p.STEPTYPE) = '0' THEN p.GROUPSTEPNUMBER
                                                                                            WHEN TRIM(p.STEPTYPE) = '3' THEN p2.STEPNUMBER 
                                                                                            WHEN TRIM(p.STEPTYPE) = '1' THEN p2.STEPNUMBER
                                                                                            ELSE p.GROUPSTEPNUMBER
                                                                                        END AS GROUPSTEPNUMBER,
                                                                                        COALESCE(iptop.SELESAI, SUBSTRING(p2.LASTUPDATEDATETIME, 1, 19)) AS SELESAI,
                                                                                        DAYS(CURRENT DATE) - COALESCE(DAYS(iptop.SELESAI), DAYS(p2.LASTUPDATEDATETIME)) AS DELAY_PROGRESSSTATUS,
                                                                                        p.PROGRESSSTATUS AS PROGRESSSTATUS
                                                                                    FROM 
                                                                                        VIEWPRODUCTIONDEMANDSTEP p
                                                                                    LEFT JOIN PRODUCTIONDEMANDSTEP p2 ON p2.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE AND p2.STEPTYPE = p.STEPTYPE AND p2.OPERATIONCODE = p.OPERATIONCODE
                                                                                    LEFT JOIN ITXVIEW_POSISIKK_TGL_OUT_PRODORDER iptop ON iptop.PRODUCTIONORDERCODE = p.PRODUCTIONORDERCODE 
                                                                                                                                        AND iptop.DEMANDSTEPSTEPNUMBER = 
                                                                                                                                            CASE
                                                                                                                                                WHEN TRIM(p.STEPTYPE) = '0' THEN p.GROUPSTEPNUMBER
                                                                                                                                                WHEN TRIM(p.STEPTYPE) = '3' THEN p2.STEPNUMBER 
                                                                                                                                                WHEN TRIM(p.STEPTYPE) = '1' THEN p2.STEPNUMBER
                                                                                                                                                ELSE p.GROUPSTEPNUMBER
                                                                                                                                            END
                                                                                    WHERE
                                                                                        p.PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND p.PROGRESSSTATUS = '3' 
                                                                                        AND (NOT iptop.SELESAI IS NULL OR NOT p2.LASTUPDATEDATETIME IS NULL)
                                                                                    ORDER BY 
                                                                                        CASE
                                                                                            WHEN TRIM(p.STEPTYPE) = '0' THEN p.GROUPSTEPNUMBER 
                                                                                            WHEN TRIM(p.STEPTYPE) = '3' THEN p2.STEPNUMBER 
                                                                                            WHEN TRIM(p.STEPTYPE) = '1' THEN p2.STEPNUMBER
                                                                                            ELSE p.GROUPSTEPNUMBER
                                                                                        END DESC 
                                                                                    LIMIT 1");
                                $d_delay_progress_mulai   = db2_fetch_assoc($q_delay_progress_mulai);
                                $jam_status_terakhir      = $d_delay_progress_mulai['SELESAI'];
                                $delay_progress_status    = $d_delay_progress_mulai['DELAY_PROGRESSSTATUS'] . ' Hari';
                            } else {
                                $jam_status_terakhir      = '';
                                $delay_progress_status    = '';
                            }
                            // UNTUK DELAY PROGRESS STATUS PERMINTAAN MS. AMY

                            if (!empty($row_status_close['GROUPSTEPNUMBER'])) {
                                $groupstepnumber    = $row_status_close['GROUPSTEPNUMBER'];
                            } else {
                                $groupstepnumber    = '0';
                            }

                            $q_cnp1             = db2_exec($conn1, "SELECT 
                                                                        GROUPSTEPNUMBER,
                                                                        TRIM(OPERATIONCODE) AS OPERATIONCODE,
                                                                        o.LONGDESCRIPTION AS LONGDESCRIPTION,
                                                                        PROGRESSSTATUS,
                                                                        CASE
                                                                            WHEN PROGRESSSTATUS = 0 THEN 'Entered'
                                                                            WHEN PROGRESSSTATUS = 1 THEN 'Planned'
                                                                            WHEN PROGRESSSTATUS = 2 THEN 'Progress'
                                                                            WHEN PROGRESSSTATUS = 3 THEN 'Closed'
                                                                        END AS STATUS_OPERATION
                                                                    FROM 
                                                                        VIEWPRODUCTIONDEMANDSTEP v
                                                                    LEFT JOIN OPERATION o ON o.CODE = v.OPERATIONCODE
                                                                    WHERE 
                                                                        PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND PROGRESSSTATUS = 3 
                                                                    ORDER BY 
                                                                        GROUPSTEPNUMBER DESC LIMIT 1");
                            $d_cnp_close        = db2_fetch_assoc($q_cnp1);

                            if ($d_cnp_close['PROGRESSSTATUS'] == 3) { // 3 is Closed From Demands Steps 
                                $status = 'A';
                                if ($d_cnp_close['OPERATIONCODE'] == 'PPC4') {
                                    if ($rowdb2['PROGRESSSTATUS'] == 6) {
                                        $status = 'B';
                                        $kode_dept          = '-';
                                        $status_terakhir    = '-';
                                        $status_operation   = 'KK Oke';
                                    } else {
                                        $status = 'C';
                                        $kode_dept          = '-';
                                        $status_terakhir    = '-';
                                        $status_operation   = 'KK Oke | Segera Closed Production Order!';
                                    }
                                } else {
                                    $status = 'D';
                                    if ($row_status_close['PROGRESSSTATUS'] == 2) {
                                        $status = 'E';
                                        $groupstep_option       = "= '$groupstepnumber'";
                                    } else { //kalau status terakhirnya bukan PPC dan status terakhirnya CLOSED
                                        $status = 'F';
                                        $q_deteksi_total_step    = db2_exec($conn1, "SELECT COUNT(*) AS TOTALSTEP FROM VIEWPRODUCTIONDEMANDSTEP 
                                                                                    WHERE PRODUCTIONORDERCODE = '$rowdb2[NO_KK]'");
                                        $d_deteksi_total_step    = db2_fetch_assoc($q_deteksi_total_step);

                                        $q_deteksi_total_close  = db2_exec($conn1, "SELECT COUNT(*) AS TOTALCLOSE FROM VIEWPRODUCTIONDEMANDSTEP 
                                                                                    WHERE PRODUCTIONORDERCODE = '$rowdb2[NO_KK]'
                                                                                    AND PROGRESSSTATUS = 3");
                                        $d_deteksi_total_close  = db2_fetch_assoc($q_deteksi_total_close);

                                        if ($d_deteksi_total_step['TOTALSTEP'] ==  $d_deteksi_total_close['TOTALCLOSE']) {
                                            $groupstep_option       = "= '$groupstepnumber'";
                                        } else {
                                            $groupstep_option       = "> '$groupstepnumber'";
                                        }
                                    }
                                    // $status = 'G';
                                    $q_not_cnp1             = db2_exec($conn1, "SELECT 
                                                                                    GROUPSTEPNUMBER,
                                                                                    TRIM(OPERATIONCODE) AS OPERATIONCODE,
                                                                                    TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
                                                                                    o.LONGDESCRIPTION AS LONGDESCRIPTION,
                                                                                    PROGRESSSTATUS,
                                                                                    CASE
                                                                                        WHEN PROGRESSSTATUS = 0 THEN 'Entered'
                                                                                        WHEN PROGRESSSTATUS = 1 THEN 'Planned'
                                                                                        WHEN PROGRESSSTATUS = 2 THEN 'Progress'
                                                                                        WHEN PROGRESSSTATUS = 3 THEN 'Closed'
                                                                                    END AS STATUS_OPERATION
                                                                                FROM 
                                                                                    VIEWPRODUCTIONDEMANDSTEP v
                                                                                LEFT JOIN OPERATION o ON o.CODE = v.OPERATIONCODE
                                                                                WHERE 
                                                                                    PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND 
                                                                                    GROUPSTEPNUMBER $groupstep_option
                                                                                ORDER BY 
                                                                                    GROUPSTEPNUMBER ASC LIMIT 1");
                                    $d_not_cnp_close        = db2_fetch_assoc($q_not_cnp1);

                                    if ($d_not_cnp_close) {
                                        $kode_dept          = $d_not_cnp_close['OPERATIONGROUPCODE'];
                                        $status_terakhir    = $d_not_cnp_close['LONGDESCRIPTION'];
                                        $status_operation   = $d_not_cnp_close['STATUS_OPERATION'];
                                    } else {
                                        $status = 'H';
                                        $groupstep_option       = "= '$groupstepnumber'";
                                        $q_not_cnp1             = db2_exec($conn1, "SELECT 
                                                                                    GROUPSTEPNUMBER,
                                                                                    TRIM(OPERATIONCODE) AS OPERATIONCODE,
                                                                                    TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
                                                                                    o.LONGDESCRIPTION AS LONGDESCRIPTION,
                                                                                    PROGRESSSTATUS,
                                                                                    CASE
                                                                                        WHEN PROGRESSSTATUS = 0 THEN 'Entered'
                                                                                        WHEN PROGRESSSTATUS = 1 THEN 'Planned'
                                                                                        WHEN PROGRESSSTATUS = 2 THEN 'Progress'
                                                                                        WHEN PROGRESSSTATUS = 3 THEN 'Closed'
                                                                                    END AS STATUS_OPERATION
                                                                                FROM 
                                                                                    VIEWPRODUCTIONDEMANDSTEP v
                                                                                LEFT JOIN OPERATION o ON o.CODE = v.OPERATIONCODE
                                                                                WHERE 
                                                                                    PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND 
                                                                                    GROUPSTEPNUMBER $groupstep_option
                                                                                ORDER BY 
                                                                                    GROUPSTEPNUMBER ASC LIMIT 1");
                                        $d_not_cnp_close        = db2_fetch_assoc($q_not_cnp1);

                                        $kode_dept          = $d_not_cnp_close['OPERATIONGROUPCODE'];
                                        $status_terakhir    = $d_not_cnp_close['LONGDESCRIPTION'];
                                        $status_operation   = $d_not_cnp_close['STATUS_OPERATION'];
                                    }
                                }
                            } else {
                                $status = 'H';
                                if ($row_status_close['PROGRESSSTATUS'] == 2) {
                                    $status = 'I';
                                    $groupstep_option       = "= '$groupstepnumber'";
                                } else {
                                    $status = 'J';
                                    $groupstep_option       = "> '$groupstepnumber'";
                                }
                                $status = 'K';
                                $q_StatusTerakhir   = db2_exec($conn1, "SELECT 
                                                                            p.PRODUCTIONORDERCODE, 
                                                                            p.GROUPSTEPNUMBER, 
                                                                            p.OPERATIONCODE, 
                                                                            TRIM(o.OPERATIONGROUPCODE) AS OPERATIONGROUPCODE,
                                                                            o.LONGDESCRIPTION AS LONGDESCRIPTION, 
                                                                            CASE
                                                                                WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
                                                                                WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
                                                                                WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
                                                                                WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
                                                                            END AS STATUS_OPERATION,
                                                                            wc.LONGDESCRIPTION AS DEPT, 
                                                                            p.WORKCENTERCODE
                                                                        FROM 
                                                                            VIEWPRODUCTIONDEMANDSTEP p
                                                                        LEFT JOIN WORKCENTER wc ON wc.CODE = p.WORKCENTERCODE
                                                                        LEFT JOIN OPERATION o ON o.CODE = p.OPERATIONCODE
                                                                        WHERE 
                                                                            p.PRODUCTIONORDERCODE = '$rowdb2[NO_KK]' AND
                                                                            (p.PROGRESSSTATUS = '0' OR p.PROGRESSSTATUS = '1' OR p.PROGRESSSTATUS ='2') 
                                                                            AND p.GROUPSTEPNUMBER $groupstep_option
                                                                        ORDER BY p.GROUPSTEPNUMBER ASC LIMIT 1");
                                $d_StatusTerakhir   = db2_fetch_assoc($q_StatusTerakhir);
                                $kode_dept          = $d_StatusTerakhir['OPERATIONGROUPCODE'];
                                $status_terakhir    = $d_StatusTerakhir['LONGDESCRIPTION'];
                                $status_operation   = $d_StatusTerakhir['STATUS_OPERATION'];
                            }
                        }
                    }
                ?>
                    <tr>
                        <td><a target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $rowdb2['DEMAND']; ?>&prod_order=<?= $rowdb2['NO_KK']; ?>"><?= $rowdb2['DEMAND']; ?></a></td>
                        <td><?= $rowdb2['LOT']; ?></td>
                        <td><?= $rowdb2['NO_KK']; ?></td>
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

                        <td>
                            <?= $status_terakhir; ?>
                            <?php if ($status_operation != 'KK Oke') : ?>
                                (<?= $jam_status_terakhir; ?>)
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        <?php endwhile; ?>
    </tbody>
</table>