<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<center>
    <h3>Detail QTY READY</h3>
    <table style="width:50%">
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
                require_once "koneksi.php";

                $no_order       = $_GET['no_order'];
                $ket_product    = $_GET['ket_product'];
                $no_warna       = $_GET['no_warna'];
                $fetch_lotcode  = $_GET['PRODUCTIONORDERCODE'];

                $query          = "SELECT
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
                                        -- PROJECTCODE = '$no_order'
                                        -- AND TRIM(DECOSUBCODE02) || '-' || TRIM(DECOSUBCODE03) = '$ket_product' 
                                        -- AND TRIM(DECOSUBCODE05) = '$no_warna'
                                        -- AND LOGICALWAREHOUSECODE = 'M031'
                                        LOTCODE IN ($fetch_lotcode)
                                    GROUP BY
                                        PROJECTCODE,
                                        LOTCODE,
                                        SUBSTR(ELEMENTSCODE, 1,8),
                                        DECOSUBCODE02,
                                        DECOSUBCODE03
                                    ORDER BY
                                        LOTCODE ASC";

                $q_sum_po_selesai   = db2_exec($conn1, $query);
                while ($dt_sum_detail = db2_fetch_assoc($q_sum_po_selesai)) :
            ?>
            
                <tr>
                    <td><?= $dt_sum_detail['PROJECTCODE']; ?></td>
                    <td><?= $dt_sum_detail['LOTCODE']; ?></td>
                    <td>
                        <a target="_BLANK" href="http://online.indotaichen.com/laporan/ppc_filter_steps.php?demand=<?= $dt_sum_detail['PRODUCTIONDEMAND']; ?>&prod_order=<?= $dt_sum_detail['LOTCODE']; ?>">
                            <?= $dt_sum_detail['PRODUCTIONDEMAND']; ?>
                        </a>
                    </td> <!-- DEMAND -->
                    <td><?= $dt_sum_detail['KET_PRODUCT'] ?></td>
                    <td><?= $_GET['no_warna'] ?></td>

                    <td><?= number_format($dt_sum_detail['ROLL'], 0); ?></td>
                    <td><?= number_format($dt_sum_detail['QTY_READY'], 2); ?></td>
                    <td><?= number_format($dt_sum_detail['QTY_READY_2'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</center>