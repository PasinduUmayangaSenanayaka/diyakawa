<?php
require_once "connection_db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Water Sports Daily Expenses Sheet | Diyakawa</title>

    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />

    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="images/logo.png">
</head>

<body onload="onloradFunctions();">
    <div class="container-scroller">
        <?php require "header.php"; ?>
        <?php require "nav_bar.php"; ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="col-12 col-md-12 ">
                                                    <h1 style="border: none;" class="card-title form-control fs-4">Bill Numbers : <select onchange="loradpaidBillDetailsCommission();" id="paidDetails" style="border: none;" class="fs-5 text-dark " type="text" value="">
                                                            <option value="0">Select</option>
                                                            <?php
                                                            $queryun = "SELECT * FROM billing_tb WHERE status_paid = ?";
                                                            $stmtun = $db->prepare($queryun);

                                                            if ($stmtun) {
                                                                $billId = 1;
                                                                $stmtun->bind_param("s", $billId);
                                                                $stmtun->execute();
                                                                $resultun = $stmtun->get_result();
                                                                for ($i = 0; $i < $resultun->num_rows; $i++) {
                                                                    $row = $resultun->fetch_assoc();

                                                                    $querycu = "SELECT * FROM customer WHERE id = ?";
                                                                    $stmt = $db->prepare($querycu);
                                                                    $cid = $row['costormer_id'];

                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['job_no']; ?> :-

                                                                        <?php

                                                                        if ($stmt) {
                                                                            $stmt->bind_param("i", $cid);
                                                                            $stmt->execute();
                                                                            $result = $stmt->get_result();
                                                                            if ($result->num_rows != 0) {
                                                                                $rowcu = $result->fetch_assoc();

                                                                                echo $rowcu['customer'];
                                                                            }
                                                                        } ?>


                                                                    </option>
                                                            <?php

                                                                }
                                                            }
                                                            ?>

                                                        </select>
                                                        <div class="text-end"><button class="btn btn-dark fs-6 text-end">Go Add Bill</button></div>
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Commission Method Operator</h4>
                                                <p class="card-description">

                                                </p>
                                                <div class="table-responsive">

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Operator</th>
                                                                <th>Amount</th>
                                                                <th>Guide</th>
                                                                <th>Amount</th>
                                                                <th>Driver</th>
                                                                <th>Vehicle No.</th>
                                                                <th>Amount</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="iteamListingTableBody">


                                                            <tr>
                                                                <td>
                                                                    <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM operator";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['officer_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="qty" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM operator";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['officer_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <Select onchange="currencyCalculate();" id="currencyToIteamSelect" class="form-control card-title">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM driver";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['driver_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="w" disabled class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td><i onclick="deleteRow(this)" class="fa fa-trash-o fs-5 text-danger"></i></td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <br>
                                                    <div class="text-end">
                                                        <button onclick="addRowOperaterCommisions()" class="btn btn-info">Add Row</button>
                                                        <button onclick="saveOperaterCommision()" class="btn btn-success">Save Commission</button>
                                                    </div>

                                                    <br><br>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function addRowOperaterCommisions() {


                                            const newRow = `
                                            <tr>
                                                <td>
                                                      <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM operator";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['officer_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="qty" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM operator";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['officer_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <Select onchange="currencyCalculate();" id="currencyToIteamSelect" class="form-control card-title">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM driver";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['driver_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="w" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="w" disabled class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td><i onclick="deleteRow(this)" class="fa fa-trash-o fs-5 text-danger"></i></td>
                                              
                                                
                                                </tr>
`;

                                            document
                                                .getElementById("iteamListingTableBody")
                                                .insertAdjacentHTML("beforeend", newRow);


                                        }
                                    </script>










                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Commission Method Vender</h4>
                                                <p class="card-description">

                                                </p>
                                                <div class="table-responsive">

                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Operator</th>
                                                                <th>Amount</th>
                                                                <th>Guide</th>
                                                                <th>Amount</th>
                                                                <th>Driver</th>
                                                                <th>Amount</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>

                                                        </thead>
                                                        <tbody id="iteamVenderTableBody">

                                                            <tr>
                                                                <td>
                                                                    <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM product";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['code']; ?> - <?php echo $row['prduct_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="qty" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="rate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="totalValueData" class="form-control inpuFieldsBorders" type="text" disabled />
                                                                </td>
                                                                <td>
                                                                    <Select onchange="currencyCalculate();" id="currencyToIteamSelect" class="form-control card-title">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM currency";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['currencyName']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="currencyRate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="currencyRate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>

                                                                <td><i onclick="deleteRow(this)" class="fa fa-trash-o fs-5 text-danger"></i></td>

                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <br>
                                                    <br>
                                                    <div class="text-end">
                                                        <button onclick="addRowVenderCommission()" class="btn btn-info">Add Row</button>
                                                    </div>

                                                    <br><br>

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
        </div>
    </div>

    <script>
        function addRowVenderCommission() {
            const newRow = `
<tr>
                                                                <td>
                                                                    <Select id="product" class="form-control card-title">
                                                                        <option value="0">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM product";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['code']; ?> - <?php echo $row['prduct_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="qty" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input onkeyup="calculateValu();" id="rate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="totalValueData" class="form-control inpuFieldsBorders" type="text" disabled />
                                                                </td>
                                                                <td>
                                                                    <Select onchange="currencyCalculate();" id="currencyToIteamSelect" class="form-control card-title">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $queryCategory = "SELECT * FROM currency";
                                                                        $resultCategory = $db->query($queryCategory);
                                                                        if ($resultCategory) {
                                                                            for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                                                $row = $resultCategory->fetch_assoc();
                                                                        ?>
                                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['currencyName']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Error: " . $db->error;
                                                                        }

                                                                        ?>

                                                                    </Select>
                                                                </td>
                                                                <td>
                                                                    <input id="currencyRate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>
                                                                <td>
                                                                    <input id="currencyRate" class="form-control inpuFieldsBorders" type="text" />
                                                                </td>

                                                                <td><i onclick="deleteRow(this)" class="fa fa-trash-o fs-5 text-danger"></i></td>

                                                            </tr>

            `;

            document
                .getElementById("iteamVenderTableBody")
                .insertAdjacentHTML("beforeend", newRow);
        }
    </script>

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="js/dailyBillingSystem.js"></script>
</body>

</html>