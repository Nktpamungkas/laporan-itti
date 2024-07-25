<!DOCTYPE html>
<html lang="en">

<head>
    <title>DYE - Kartu Kerja By Suffix</title>
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
    <link rel="stylesheet" type="text/css" href="files\assets\pages\data-table\extensions\buttons\css\buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\jquery.mCustomScrollbar.css">
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
                                        <h5>Kartu Kerja By Suffix</h5>
                                    </div>
                                    <div class="card-block">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-sm-12 col-xl-6 m-b-30">
                                                    <h4 class="sub-title">RCODE:</h4>
                                                    <input type="text" class="form-control" name="subcode01" value="<?php if (isset($_POST['submit'])){ echo $_POST['subcode01']; } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-6 m-b-30">
                                                    <h4 class="sub-title">SUFFIX CODE:</h4>
                                                    <input type="text" class="form-control" name="suffix" value="<?php if (isset($_POST['submit'])){ echo $_POST['suffix']; } ?>">
                                                </div>
                                                <div class="col-sm-12 col-xl-4 m-b-30">
                                                    <button type="submit" name="submit" class="btn btn-primary"><i class="icofont icofont-search-alt-1"></i> Cari data</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php if (isset($_POST['submit'])) : ?>
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="table-responsive dt-responsive">
                                                <table id="basic-btn" class="table compact table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>CREATION DATE TIME</th>
                                                            <th>PRODUCTION DEMAND</th>
                                                            <th>PRODUCTION ORDER</th>
                                                            <th>POSISI TERAKHIR</th>
                                                            <th>QTY BAGIKAIN</th>
                                                            <th>RCODE</th>
                                                            <th>SUFFIX CODE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            require_once "koneksi.php";
                                                            $subcode01 = $_POST['subcode01'];
                                                            $suffix = $_POST['suffix'];

                                                            if($subcode01 && $suffix){
                                                                $WHERE  = "WHERE SUFFIXCODE LIKE '%$suffix%' AND SUBCODE01 LIKE '%$subcode01%'";
                                                                echo "subcode01 suffix";
                                                            }elseif(empty($subcode01) && $suffix){
                                                                $WHERE  = "WHERE SUFFIXCODE LIKE '%$suffix%'";
                                                                echo "suffix";
                                                            }elseif($subcode01 && empty($suffix)){
                                                                $WHERE  = "WHERE SUBCODE01 LIKE '%$subcode01%'";
                                                                echo "subcode01";
                                                            }
                                                            $db2_reservation = "SELECT * FROM ITXVIEWPROD_SUFFIX $WHERE ORDER BY PRODUCTIONORDERCODE DESC";
                                                            $stmt   = db2_exec($conn1, $db2_reservation);
                                                            $no     = 1;
                                                            while ($row_prod = db2_fetch_assoc($stmt)) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $row_prod['CREATIONDATETIME']; ?></td>
                                                            <td><a target="_BLANK" href="http://10.0.0.10/laporan/ppc_filter_steps.php?demand=<?= $row_prod['DEAMAND']; ?>"><?= $row_prod['DEAMAND']; ?></a></td>
                                                            <td><?= $row_prod['PRODUCTIONORDERCODE']; ?></td>
                                                            <?php 
                                                                $q_StatusTerakhir = db2_exec($conn1, "SELECT 
                                                                                                            p.PRODUCTIONORDERCODE, p.PRODUCTIONDEMANDCODE, 
                                                                                                            p.GROUPSTEPNUMBER, p.OPERATIONCODE, 
                                                                                                            p.LONGDESCRIPTION, 
                                                                                                            CASE
                                                                                                                WHEN p.PROGRESSSTATUS = 0 THEN 'Entered'
                                                                                                                WHEN p.PROGRESSSTATUS = 1 THEN 'Planned'
                                                                                                                WHEN p.PROGRESSSTATUS = 2 THEN 'Progress'
                                                                                                                WHEN p.PROGRESSSTATUS = 3 THEN 'Closed'
                                                                                                            END AS STATUS_OPERATION,
                                                                                                            wc.LONGDESCRIPTION AS DEPT, p.WORKCENTERCODE
                                                                                                        FROM 
                                                                                                            PRODUCTIONDEMANDSTEP p
                                                                                                        LEFT JOIN WORKCENTER wc ON wc.CODE = p.WORKCENTERCODE
                                                                                                        WHERE p.PRODUCTIONORDERCODE = '$row_prod[PRODUCTIONORDERCODE]' 
                                                                                                            AND p.PRODUCTIONDEMANDCODE = '$row_prod[DEAMAND]' 
                                                                                                            AND (p.PROGRESSSTATUS = '0' OR p.PROGRESSSTATUS = '1' OR p.PROGRESSSTATUS ='2')
                                                                                                        ORDER BY p.GROUPSTEPNUMBER ASC LIMIT 1");
                                                                $d_StatusTerakhir = db2_fetch_assoc($q_StatusTerakhir);
                                                            ?>
                                                            <td><?= $d_StatusTerakhir['LONGDESCRIPTION']; ?></td> <!--  STATUS TERAKHIR -->
                                                            <td><?= $row_prod['QTY_BAGIKAIN']; ?></td>
                                                            <td><?= $row_prod['SUBCODE01']; ?></td>
                                                            <td><?= $row_prod['SUFFIXCODE']; ?></td>
                                                        </tr>
                                                        <?php } ?>
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
</body>
</html>