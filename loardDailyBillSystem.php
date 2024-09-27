<?php
session_start();

require "connection_db.php";

if (isset($_POST)) {
    $id = $_POST['id'];
    if (empty($id)) {
        echo "Please enter username.";
    } else if ($id == "0") {
        echo "Please Select Valide Bill Number.";
    } else {

        $query = "SELECT * FROM billing_tb WHERE id = $id";
        $result = $db->query($query);
        if ($result) {
            if ($result->num_rows != 0) {

                $rowc = $result->fetch_assoc();
?>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title fs-4 fw-bold" style="letter-spacing: 1px;">Bill Details </h4>
                            <p class="card-description" id="errormassege">

                            </p>
                            <div class="table-responsive">
                                <table class="table">

                                    <tbody id="currencyTableBody">
                                        <tr>
                                            <th>Custormer Name</th>
                                            <th>Custormer Mobile</th>
                                            <th>Custormer Email</th>
                                            <th>Project</th>
                                            <th>Location</th>

                                        </tr>

                                        <tr>
                                            <td>



                                                <?php
                                                $custormerEmail = "";
                                                $custormermobile = "";
                                                ?>
                                                <?php
                                                $cid = $rowc['costormer_id'];
                                                $queryCategory = "SELECT * FROM customer WHERE id = $cid";
                                                $resultCategory = $db->query($queryCategory);
                                                if ($resultCategory) {
                                                    if ($resultCategory->num_rows != 0) {

                                                        $row = $resultCategory->fetch_assoc();
                                                        $custormerEmail = $row['costormer_address'];
                                                        $custormermobile = $row['costormer_mobile'];
                                                ?><input id="custormerSearchMobileValueUnpaid" value="<?php echo $row['id']; ?>" type="text" class="d-none">
                                                        <input value="<?php echo $row['customer']; ?>" style="display: inline-block; width: 250px;" class="form-control card-title" disabled>







                                            </td>
                                            <td>
                                                <input value="<?php echo $custormermobile; ?>" id="custormerSearchMobileUnpaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>
                                            <td>
                                                <input value="<?php echo $custormerEmail; ?>" id="custormerSearchEmailUnpaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>

                                    <?php
                                                    }
                                                } else {
                                                    echo "Error: " . $db->error;
                                                }

                                    ?>
                                    <td>
                                        <Select id="projectunpaid" class="form-control card-title">
                                            <?php
                                            $cidp = $rowc['project_id'];
                                            $queryCategory = "SELECT * FROM project_type WHERE id = $cidp";
                                            $resultCategory = $db->query($queryCategory);
                                            if ($resultCategory) {
                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                    $row = $resultCategory->fetch_assoc();
                                            ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                            <?php
                                                }
                                            } else {
                                                echo "Error: " . $db->error;
                                            }

                                            ?>
                                            <?php
                                            $queryCategory = "SELECT * FROM project_type";
                                            $resultCategory = $db->query($queryCategory);
                                            if ($resultCategory) {
                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                    $row = $resultCategory->fetch_assoc();
                                                    if ($row['id'] != $rowc['project_id']) {
                                            ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                            <?php
                                                    }
                                                }
                                            } else {
                                                echo "Error: " . $db->error;
                                            }

                                            ?>


                                        </Select>
                                    </td>
                                    <td>
                                        <Select id="locationunpaid" class="form-control card-title">

                                            <?php
                                            $cidp = $rowc['location_id'];
                                            $queryCategory = "SELECT * FROM location WHERE id = $cidp";
                                            $resultCategory = $db->query($queryCategory);
                                            if ($resultCategory) {
                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                    $row = $resultCategory->fetch_assoc();
                                            ?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['location']; ?></option>
                                            <?php
                                                }
                                            } else {
                                                echo "Error: " . $db->error;
                                            }

                                            ?>
                                            <?php
                                            $queryCategory = "SELECT * FROM location";
                                            $resultCategory = $db->query($queryCategory);
                                            if ($resultCategory) {
                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                    $row = $resultCategory->fetch_assoc();
                                                    if ($row['id'] != $rowc['location_id']) {
                                            ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['location']; ?></option>
                                            <?php
                                                    }
                                                }
                                            } else {
                                                echo "Error: " . $db->error;
                                            }

                                            ?>

                                        </Select>
                                    </td>



                                        </tr>

                                        <tr>
                                            <th>Passengers</th>
                                            <th>Tour NO</th>
                                            <th>Tour Type</th>
                                            <th>Bill Method</th>
                                            <th>Bill Status</th>

                                        </tr>

                                        <tr>
                                            <td>
                                                <input value="<?php echo $rowc['pax_amount']; ?>" id="pxgUnpaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>
                                            <td>
                                                <input value="<?php echo $rowc['tour_no']; ?>" id="tournoUnpaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>
                                            <td>
                                                <Select id="tourtypeUnpaid" class="form-control card-title">

                                                    <?php
                                                    $cidp = $rowc['traverler_typr_id'];
                                                    $queryCategory = "SELECT * FROM traverler_type WHERE id = $cidp";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                    <?php
                                                    $queryCategory = "SELECT * FROM traverler_type";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['traverler_typr_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['type']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                            <td>
                                                <Select id="billmethodunpaid" class="form-control card-title">

                                                    <?php
                                                    $cidp = $rowc['payment_method_id'];
                                                    $queryCategory = "SELECT * FROM payment_method WHERE id = $cidp";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_method']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                    <?php
                                                    $queryCategory = "SELECT * FROM payment_method";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['payment_method_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_method']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                            <td>
                                                <Select id="billstatusunpaid" class="form-control card-title">

                                                    <?php
                                                    $cidp = $rowc['stutas_id'];
                                                    $queryCategory = "SELECT * FROM billing_status WHERE id = $cidp";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                    <?php
                                                    $queryCategory = "SELECT * FROM billing_status";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['stutas_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['status']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>


                                        </tr>


                                        <tr>


                                            <th>Company</th>
                                            <th>Vender Name</th>
                                            <th>Operater</th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <Select id="companyunpaid" class="form-control card-title">


                                                    <?php
                                                    $cidp = $rowc['company_id'];
                                                    $queryCategory = "SELECT * FROM company WHERE id = $cidp";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['company_name']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                    <?php
                                                    $queryCategory = "SELECT * FROM company";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['company_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['company_name']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                            <td>
                                                <Select id="venderunpaid" class="form-control card-title">


                                                    <?php
                                                    $cidp = $rowc['vender_id'];
                                                    $queryCategory = "SELECT * FROM vendor WHERE id = $cidp";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['vender_name']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                    <?php
                                                    $queryCategory = "SELECT * FROM vendor";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['vender_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['vender_name']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                            <td>


                                                <Select id="operaterunpaid" class="form-control card-title">


                                                    <?php
                                                    $cidp = $rowc['operetor_id'];
                                                    $queryCategory = "SELECT * FROM operator WHERE id = $cidp";
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

                                                    <?php
                                                    $queryCategory = "SELECT * FROM operator";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                            $row = $resultCategory->fetch_assoc();
                                                            if ($row['id'] != $rowc['operetor_id']) {
                                                    ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['officer_name']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                        </tr>



                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Item Listing</h4>
                            <p class="card-description">

                            </p>
                            <div class="table-responsive">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Quntity</th>
                                            <th>Rate</th>
                                            <th>Cost</th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <Select id="productunpaid" class="form-control card-title">
                                                    <?php
                                                    $queryCategory = "SELECT * FROM product";
                                                    $resultCategory = $db->query($queryCategory);
                                                    if ($resultCategory) {
                                                        for ($i = 0; $i < $resultCategory->num_rows; $i++) {

                                                            $row = $resultCategory->fetch_assoc();
                                                    ?>
                                                            <option value="<?php echo $row['code']; ?>"><?php echo $row['code']; ?> - <?php echo $row['prduct_name']; ?></option>
                                                    <?php
                                                        }
                                                    } else {
                                                        echo "Error: " . $db->error;
                                                    }

                                                    ?>

                                                </Select>
                                            </td>
                                            <td>
                                                <input onkeyup="calculateValuunpaid();" id="qtyupaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>
                                            <td>
                                                <input onkeyup="calculateValuunpaid();" id="rateunpaid" class="form-control inpuFieldsBorders" type="text" />
                                            </td>
                                            <td>
                                                <input id="totalValueDataunpaid" class="form-control inpuFieldsBorders" type="text" disabled />
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                                <br>
                                <br>
                                <div class="text-end">
                                    <button onclick="addRowIteamListingUnpaid ()" class="btn btn-info">Add Row</button>
                                </div>

                                <br><br>

                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function discountadd() {
                        var discountPresentage = document.getElementById("dicountPresentage").value;
                        var total = document.getElementById("totalValue").value;

                    }
                </script>


                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Item Code</th>
                                            <th>Quntity</th>
                                            <th>Rate</th>
                                            <th>Discount %</th>
                                            <th>Discount</th>
                                            <th>Currency</th>
                                            <th>Currency Rate</th>
                                            <th>Total</th>

                                        </tr>
                                    </thead>
                                    <tbody id="iteamListingTableBodyUnpaid">

                                        <?php
                                        $cidp = $rowc['id'];

                                        $queryp = "SELECT product_listing.id AS pid, product_listing.job_no AS pjob, product_listing.qty AS pqty, 
                                        product_listing.rate, product_listing.currency_name_add_id AS currencyid, product_listing.product_id AS productid, 
                                        product_listing.discount AS pdicount FROM product_listing INNER JOIN billing_tb ON 
                                        product_listing.job_no = billing_tb.job_no WHERE billing_tb.id = $cidp;";
                                        $resultp = $db->query($queryp);
                                        if ($resultp) {

                                            $productlistingcount = 0;

                                            for ($j = 0; $j < $resultp->num_rows; $j++) {
                                                $productlistingcount++;
                                                $rowp = $resultp->fetch_assoc();
                                        ?>

                                                <tr readonly id="firstRow">
                                                    <td><i onclick="deleteRowUnpaid(this)" class="fa fa-trash-o fs-5 text-danger"></i></td>
                                                    <input type="hidden" name="hiddenPID" id="hiddenPID" class="d-none" value="<?php echo $rowp['pid']; ?>" />
                                                    <td>
                                                        <?php
                                                        $qty = 0;
                                                        $rate = 0;
                                                        $discount = 0;
                                                        $total = 0;

                                                        if (isset($rowp['pqty'])) {
                                                            $qty = $rowp['pqty'];
                                                        }

                                                        if (isset($rowp['rate'])) {
                                                            $rate = $rowp['rate'];
                                                        }

                                                        if (isset($rowp['pdicount'])) {
                                                            $discount = $rowp['pdicount'];
                                                        }

                                                        $total = $qty * $rate;
                                                        $total = $total - $total * ($discount / 100);

                                                        $discountprice = $total * ($discount / 100);
                                                        $pids = $rowp['productid'];
                                                        $querys = "SELECT * FROM product WHERE id = $pids";
                                                        $results = $db->query($querys);
                                                        if ($results) {
                                                            if ($results->num_rows != 0) {
                                                                $rowcode = $results->fetch_assoc();
                                                        ?>
                                                                <input name="productunpaid" id='productId' value="<?php echo $rowcode['code']; ?>" readonly class="form-control inpuFieldsBorders" type="text" />
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <input name="qtyunpaid" onkeyup="calculateValuDiscountWithUnpaid(<?php echo $productlistingcount; ?>);" id="productqty<?php echo $productlistingcount; ?>" value="<?php echo $rowp['pqty']; ?>" class="form-control inpuFieldsBorders" type="number" />
                                                    </td>
                                                    <td>
                                                        <input name="rateunpaid" onkeyup="calculateValuDiscountWithUnpaid(<?php echo $productlistingcount; ?>);" id="productrate<?php echo $productlistingcount; ?>" value="<?php echo $rowp['rate']; ?>" class="form-control inpuFieldsBorders" type="text" />
                                                    </td>

                                                    <td>
                                                        <input name="discountunpaid" onkeyup="calculateValuDiscountWithUnpaid(<?php echo $productlistingcount; ?>);" id="productdiscount<?php echo $productlistingcount; ?>" value="<?php echo $rowp['pdicount']; ?>" class="form-control inpuFieldsBorders" type="text" />
                                                    </td>

                                                    <td>
                                                        <input readonly  id="piddiscount<?php echo $productlistingcount; ?>" value="<?php echo $discountprice; ?>" class="form-control inpuFieldsBorders" type="text" />
                                                    </td>
                                                    <td>
                                                        <Select name="currencyunpaid" id="productcurrency<?php echo $productlistingcount; ?>" class="form-control card-title" onchange="currencyCalculate(this);">
                                                            <?php
                                                            $currencyValue = 0;
                                                            $currencyRateValidation = 0;
                                                            $cidp = $rowp['currencyid'];
                                                            $queryCategory = "SELECT * FROM currency WHERE id = $cidp";
                                                            $resultCategory = $db->query($queryCategory);
                                                            if ($resultCategory) {
                                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                                    $row = $resultCategory->fetch_assoc();
                                                                    $today = date("Y-m-d");
                                                                    $valuec = $row['id'];
                                                                    $querycurrency = "SELECT * FROM currency_value WHERE date = $today AND currency = $cidp;";
                                                                    $resultCurrency = $db->query($querycurrency);
                                                                    if ($resultCurrency) {
                                                                        if ($resultCurrency->num_rows != 0) {
                                                                            $exchangeRate = $resultCurrency->fetch_assoc();
                                                                            $currencyValue = $exchangeRate['exchange_rate'];
                                                                            $currencyRateValidation = $total / $currencyValue;
                                                                        }
                                                                    }


                                                            ?>
                                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['currencyName']; ?></option>
                                                            <?php

                                                                }
                                                            } else {
                                                                echo "Error: " . $db->error;
                                                            }

                                                            ?>

                                                            <?php
                                                            $queryCategory = "SELECT * FROM currency";
                                                            $resultCategory = $db->query($queryCategory);
                                                            if ($resultCategory) {
                                                                for ($i = 0; $i < $resultCategory->num_rows; $i++) {
                                                                    $row = $resultCategory->fetch_assoc();
                                                                    if ($row['id'] != $rowp['currencyid']) {
                                                            ?>
                                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['currencyName']; ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                            } else {
                                                                echo "Error: " . $db->error;
                                                            }

                                                            ?>



                                                        </Select>
                                                    </td>
                                                    <td>
                                                        <input value="<?php echo $currencyRateValidation; ?>" class="form-control inpuFieldsBorders" type="text" disabled />
                                                    </td>

                                                    <td>
                                                        <input  id="totalunpaidrow<?php echo $productlistingcount; ?>" value="<?php echo $total; ?>" class="form-control inpuFieldsBorders" type="text" disabled />
                                                    </td>

                                                </tr>
                                        <?php


                                            }
                                        } else {
                                            echo "Error: " . $db->error;
                                        }
                                        ?>
                                    </tbody>
                                </table>




                            </div>
                            <br>
                            <br>
                            <div class="col-12 text-end " style="display: inline-block;">
                                <button style="display: inline-block;" onclick="deleteUnpaidFunction();" class="btn btn-danger text-end  ">Delete Bill</button>
                                <button style="display: inline-block;" onclick="saveUnpaidFunction();" class="btn btn-success text-end  ">Save Unpaid Data</button>
                                <button style="display: inline-block;" onclick="saveFunction();" class="btn btn-info text-end d-none ">Save Data</button>


                            </div>


                            <br><br>

                        </div>
                    </div>
                </div>





                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Currency</th>
                                            <th>Amount</th>
                                            <th>Commission</th>
                                            <th>Profit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

<?php
            }
        } else {
            echo "Error: " . $db->error;
        }
    }
}
?>