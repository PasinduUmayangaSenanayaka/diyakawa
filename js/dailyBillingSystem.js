function deleteRow(element) {
  element.closest("tr").remove();
}

function onloradFunctions() {
  
  const dateInput = document.getElementById("date");
  const today = new Date();
  const timezoneOffsetInHours = today.getTimezoneOffset() / 60;
  const desiredTimeZoneOffset = 0;
  const adjustedDate = new Date(
    today.setHours(
      today.getHours() + timezoneOffsetInHours - desiredTimeZoneOffset
    )
  );
  const formattedDate = adjustedDate.toISOString().split("T")[0];
  dateInput.value = formattedDate;

  addRow();
  addRowcashOut();
  addIncomeRow();
  addExpenseRow();
  addSalaryDetailsRow();
  addemployeeDataRow();
}

$(document).ready(function () {
  $("#selectSearch").select2();
});

function addemployeeDataRow() {
  const tableBody = document.getElementById("employeeTableBody");
  const template = document.getElementById("employeeTemplateBody");
  const newRow = template.content.cloneNode(true);
  tableBody.appendChild(newRow);
}

let rowCount = 0;

function calculateRowTotal(rowId) {
  const exchangeRate =
    parseFloat(document.getElementById(`exchangeRate${rowId}`).value) || 0;
  const amount =
    parseFloat(document.getElementById(`amount${rowId}`).value) || 0;
  const rowTotal = exchangeRate * amount;
  document.getElementById(`rowTotal${rowId}`).textContent = rowTotal.toFixed(2);

  updateGrandTotal();
}

function updateGrandTotal() {
  let grandTotal = 0;

  const rowTotals = document.querySelectorAll("[id^='rowTotal']");
  rowTotals.forEach((rowTotal) => {
    grandTotal += parseFloat(rowTotal.textContent) || 0;
  });

  document.getElementById("grandTotal").value = grandTotal.toFixed(2);
}
// function deleteRow(element) {
//   const row = element.closest("tr");
//   row.remove();
//   updateGrandTotal();
// }

function updateCashOutTotal() {
  let totalCashOut = 0;

  const amounts = document.querySelectorAll('[id^="rowTotalcashOut"]');
  amounts.forEach(function (amount) {
    totalCashOut += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalCashOut").value = totalCashOut.toFixed(2);
}

function updateCIncomeAmountTotal() {
  let rowCountinvoce = 0;

  const amounts = document.querySelectorAll('[id^="rowTotala"]');
  amounts.forEach(function (amount) {
    rowCountinvoce += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalAmountInvoice").value =
    rowCountinvoce.toFixed(2);
}

function updateCommitionAmountTotal() {
  let rowCommitioninvoce = 0;

  const amounts = document.querySelectorAll('[id^="rowTotalcommition"]');
  amounts.forEach(function (amount) {
    rowCommitioninvoce += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalCommitionInvoice").value =
    rowCommitioninvoce.toFixed(2);
}

function updateProfitAmountTotal() {
  let rowProfitinvoce = 0;

  const amounts = document.querySelectorAll('[id^="rowTotali"]');
  amounts.forEach(function (amount) {
    rowProfitinvoce += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalProfitInvoice").value =
    rowProfitinvoce.toFixed(2);
}

function updateAddExpenseRow() {
  let rowExpense = 0;

  const amounts = document.querySelectorAll('[id^="expense"]');
  amounts.forEach(function (amount) {
    rowExpense += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalExpense").value = rowExpense.toFixed(2);
}

function updaterowSalaryRow() {
  let rowSalary = 0;

  const amounts = document.querySelectorAll('[id^="salary"]');
  amounts.forEach(function (amount) {
    rowSalary += parseFloat(amount.value) || 0;
  });

  document.getElementById("totalSalary").value = rowSalary.toFixed(2);
}

function saveData() {
  const rows = document.querySelectorAll("#cashoutTableBody tr");
  let data = [];
  const date = document.getElementById("date").value; // Get the date value here

  rows.forEach((row) => {
    const jobNo = row.querySelector('input[name="job_no"]').value;
    const description = row.querySelector('input[name="description"]').value;
    const empName = row.querySelector('select[name="emp_name"]').value;
    const amount = row.querySelector('input[name="amount"]').value;

    if (jobNo && description && empName && amount) {
      data.push({
        job_no: jobNo,
        description: description,
        emp_id: empName,
        amount: amount,
        date_cash_out: date,
      });
    }
  });

  if (data.length > 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "saveCashOut.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
        alert("Data saved successfully");

        document.getElementById("cashoutTableBody").innerHTML = "";
        document.getElementById("totalCashOut").value = "0.00";
        addRowcashOut();
      }
    };
    xhr.send(JSON.stringify(data));
  } else {
    alert("Please fill out all fields before saving.");
  }
}

function saveTableData() {
  let tableData = [];

  const rows = document.querySelectorAll("#currencyTableBody tr");
  const date = document.getElementById("date").value;

  rows.forEach(function (row, index) {
    const currency = row.querySelector("select").value;
    const exchangeRate = parseFloat(
      row.querySelector(`#exchangeRate${index + 1}`).value
    );
    const amount = parseFloat(row.querySelector(`#amount${index + 1}`).value);

    if (currency && exchangeRate && amount) {
      tableData.push({
        currency: currency,
        exchangeRate: exchangeRate,
        amount: amount,
        date: date,
      });
    }
  });

  if (tableData.length > 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "saveCurrency.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        alert("Data saved successfully!");

        document.getElementById("currencyTableBody").innerHTML = "";
        document.getElementById("grandTotal").value = "0.00";
        addRow();
      }
    };

    xhr.send(JSON.stringify({ data: tableData }));
  } else {
    alert("Please fill in all fields before saving.");
  }
}

function saveSalaryDetails() {
  let salaryDetails = [];
  let rows = document.querySelectorAll("#SalaryDetailTableBody tr");

  rows.forEach(function (row) {
    let empName = row.querySelector(".empName").value;
    let amount = row.querySelector(".salaryAmount").value;
    let reason = row.querySelector(".reason").value;

    if (empName && amount && reason) {
      salaryDetails.push({
        empName: empName,
        amount: parseFloat(amount),
        reason: reason,
      });
    }
  });

  if (salaryDetails.length > 0) {
    fetch("saveSalaryDetails.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(salaryDetails),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Data saved successfully!");
        } else {
          alert("Failed to save data.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred.");
      });
  } else {
    alert("No data to save.");
  }
}

function addCustormer() {
  var custormerId = document.getElementById("custormerId").value;
  var custoermerName = document.getElementById("custoermerName").value;
  var custoermerMobile = document.getElementById("custoermerMobile").value;
  var custoermerAddress = document.getElementById("custoermerAddress").value;
  var custormerCountry = document.getElementById("custormerCountry").value;
  var custoermerCountactBy = document.getElementById(
    "custoermerCountactBy"
  ).value;
  var custormerCategory = document.getElementById("custormerCategory").value;
  var custormerSubCategory = document.getElementById(
    "custormerSubCategory"
  ).value;
  var company = document.getElementById("company").value;
  var currency = document.getElementById("currency").value;

  var f = new FormData();
  f.append("custormerId", custormerId);
  f.append("custoermerName", custoermerName);
  f.append("custoermerMobile", custoermerMobile);
  f.append("custoermerAddress", custoermerAddress);
  f.append("custormerCountry", custormerCountry);
  f.append("custoermerCountactBy", custoermerCountactBy);
  f.append("custormerCategory", custormerCategory);
  f.append("custormerSubCategory", custormerSubCategory);
  f.append("company", company);
  f.append("currency", currency);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      if (x.responseText == "success") {
        alert("Data saved successfully !");
        window.location.reload();
      } else {
        document.getElementById("errorMsgs").innerText = x.responseText;
      }
    }
  };

  x.open("POST", "saveCustormerData.php", true);
  x.send(f);
}

function getCustormer(id) {
  id = id;
  getCustormerMobile(id);
  getCustormereMAIL(id);
}

function getCustormerMobile(id) {
  var f = new FormData();
  f.append("mobile", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      document.getElementById("custormerSearchMobile").value = x.responseText;
    }
  };

  x.open("POST", "searchCustormerMobileNumber.php", true);
  x.send(f);
}

function getCustormereMAIL(id) {
  var f = new FormData();
  f.append("mobile", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      document.getElementById("custormerSearchEmail").value = x.responseText;
    }
  };

  x.open("POST", "searchCustormeReMAIL.php", true);
  x.send(f);
}

function calculateValu() {
  let quentity = 0;
  let rate = 0;
  let total = 0;

  var qty = document.getElementById("qty").value;
  var ratedata = document.getElementById("rate").value;
  var totalvalue = document.getElementById("totalValueData");

  if (qty != null) {
    quentity = qty;
  }

  if (ratedata != null) {
    rate = ratedata;
  }

  total = rate * quentity;
  totalvalue.value = total;
}

function calculateValuunpaid() {
  let quentity = 0;
  let rate = 0;
  let total = 0;

  var qty = document.getElementById("qtyupaid").value;
  var ratedata = document.getElementById("rateunpaid").value;
  var totalvalue = document.getElementById("totalValueDataunpaid");

  if (qty != null) {
    quentity = qty;
  }

  if (ratedata != null) {
    rate = ratedata;
  }

  total = rate * quentity;
  totalvalue.value = total;
}

function calculateValuDiscountWith(id) {
  var id = id;
  let quentity = 0;
  let rate = 0;
  let total = 0;
  let discount = 0;
  let disountValue = 0;

  var qty = document.getElementById("qty" + id).value;
  var ratedata = document.getElementById("rate" + id).value;
  var discounts = document.getElementById("dicountPresentage" + id).value;
  var totalvalue = document.getElementById("totalValue" + id);
  var discountvalues = document.getElementById("discount" + id);

  if (qty != null) {
    quentity = qty;
  }

  if (ratedata != null) {
    rate = ratedata;
  }

  if (discounts != null) {
    discount = discounts;
  }

  total = rate * quentity;
  total = total - (total * discount) / 100;
  disountValue = (total * discount) / 100;
  totalvalue.value = total;
  discountvalues.value = disountValue;
}

function calculateValuDiscountWithUnpaid(id) {
  var id = id;
  let quentity = 0;
  let rate = 0;
  let total = 0;
  let discount = 0;
  let disountValue = 0;

  var qty = document.getElementById("productqty" + id).value;
  var ratedata = document.getElementById("productrate" + id).value;
  var discounts = document.getElementById("productdiscount" + id).value;
  var totalvalue = document.getElementById("totalunpaidrow" + id);
  var discountvalues = document.getElementById("piddiscount" + id);

  if (qty != null) {
    quentity = qty;
  }

  if (ratedata != null) {
    rate = ratedata;
  }

  if (discounts != null) {
    discount = discounts;
  }

  total = rate * quentity;
  total = total - (total * discount) / 100;
  disountValue = (total * discount) / 100;
  totalvalue.value = total;
  discountvalues.value = disountValue;
}

function currencyCalculate(id) {
  var id = id;
  var currency = document.getElementById("currencyToIteamSelect" + id).value;
  var total = document.getElementById("totalValue" + id).value;

  var f = new FormData();
  f.append("currency", currency);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      total = total / x.responseText;
      document.getElementById("currencyRate" + id).value = total;
    }
  };

  x.open("POST", "currencyCalculation.php", true);
  x.send(f);
}

function saveFunction() {
  saveIteamListing();
  custormerDataUpdate();
  saveData();
}

function saveIteamListing() {
  var cid = document.getElementById("custormerSearchMobileValue").value;
  var project = document.getElementById("project").value;
  var location = document.getElementById("location").value;
  var pxg = document.getElementById("pxg").value;
  var tourno = document.getElementById("tourno").value;
  var tourtype = document.getElementById("tourtype").value;
  var billmethod = document.getElementById("billmethod").value;
  var billstatus = document.getElementById("billstatus").value;
  var company = document.getElementById("company").value;
  var vender = document.getElementById("vender").value;
  var operater = document.getElementById("operater").value;
  var billId = document.getElementById("billId").value;
  var date = document.getElementById("date").value;

  var form = new FormData();

  form.append("billId", billId);
  form.append("date", date);
  form.append("cid", cid);
  form.append("project", project);
  form.append("location", location);
  form.append("pxg", pxg);
  form.append("tourno", tourno);
  form.append("tourtype", tourtype);
  form.append("billmethod", billmethod);
  form.append("billstatus", billstatus);
  form.append("company", company);
  form.append("vender", vender);
  form.append("operater", operater);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {
      if (req.responseText == "success") {
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "addBillPayiedData.php", true);
  req.send(form);
}

function custormerDataUpdate() {
  var cid = document.getElementById("custormerSearchMobileValue").value;
  var cmobile = document.getElementById("custormerSearchMobile").value;
  var cemail = document.getElementById("custormerSearchEmail").value;

  var f = new FormData();
  f.append("cid", cid);
  f.append("cmobile", cmobile);
  f.append("cemail", cemail);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
    }
  };

  x.open("POST", "updateCustormerData.php", true);
  x.send(f);
}

function saveData() {
  const rows = document.querySelectorAll("#iteamListingTableBody tr");
  let data = [];
  const date = document.getElementById("date").value;
  const billId = document.getElementById("billId").value;

  rows.forEach((row) => {
    const product = row.querySelector('input[name="product"]').value;
    const qty = row.querySelector('input[name="qty"]').value;
    const rate = row.querySelector('input[name="rate"]').value;
    const discount = row.querySelector('input[name="discount"]').value;
    const currency = row.querySelector('select[name="currencyNameId"]').value;

    if (product && qty && rate && discount && currency) {
      data.push({
        product_id: product,
        qty: qty,
        rate: rate,
        discount: discount,
        currency_name_add_id: currency,
        date: date,
        job_no: billId,
      });
    }
  });

  if (data.length > 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "addProductListing.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        try {
          const response = JSON.parse(xhr.responseText);

          if (response.status === "success") {
            alert("Bill saved successfully!");
            window.location.reload();
          } else {
            alert(response.message || "An error occurred while saving data.");
          }
        } catch (e) {
          console.error("Failed to parse response:", e);
          alert("An unexpected error occurred.");
        }
      }
    };
    xhr.send(JSON.stringify(data));
  } else {
    document.getElementById("errormassege").innerHTML =
      "Please fill out all fields before saving.";
  }
}

function loradUnpaidBillDetails() {
  var id = document.getElementById("unpaidDetails").value;
  var loard = document.getElementById("onlordActivedive");
  var unloard = document.getElementById("onlordInactiveDiv");
  billIdChange(id);
  loard.classList.add("d-none");
  unloard.classList.remove("d-none");

  var f = new FormData();
  f.append("id", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      unloard.innerHTML = x.responseText;
    }
  };

  x.open("POST", "loardDailyBillSystem.php", true);
  x.send(f);
}

function billIdChange(id) {
  var billid = document.getElementById("billId");
  var f = new FormData();
  f.append("id", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      billid.value = x.responseText;
    }
  };

  x.open("POST", "getBillID.php", true);
  x.send(f);
}

//////////////////////////////////////////////

function filterFunction() {
  var input, filter, dropdownList, div, i;
  input = document.getElementById("searchInput");
  filter = input.value.toLowerCase();
  dropdownList = document.getElementById("dropdownList");
  div = dropdownList.getElementsByTagName("div");

  dropdownList.style.display = filter ? "block" : "none";

  for (i = 0; i < div.length; i++) {
    if (div[i].innerHTML.toLowerCase().indexOf(filter) > -1) {
      div[i].style.display = "";
    } else {
      div[i].style.display = "none";
    }
  }
}

function selectOption(option) {
  document.getElementById("searchInput").value = option;
  document.getElementById("dropdownList").style.display = "none";
}

window.onclick = function (event) {
  if (!event.target.matches("#searchInput")) {
    document.getElementById("dropdownList").style.display = "none";
  }
};

function deleteRowUnpaid(element) {
  var row = element.closest("tr");
  var hiddenInput = row.querySelector("#hiddenPID");
  var id = hiddenInput.value;

  var f = new FormData();
  f.append("id", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
    }
  };

  x.open("POST", "deleteProductListingTable.php", true);
  x.send(f);

  row.remove();
}

function deleteUnpaidFunction() {
  var id = document.getElementById("unpaidDetails").value;

  var f = new FormData();
  f.append("id", id);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      if (x.responseText == "success") {
        window.location.reload();
      } else {
        alert(x.responseText);
      }
    }
  };

  x.open("POST", "deleteProductListing.php", true);
  x.send(f);
}

function saveUnpaidFunction() {
  saveDataUnpaid();
  saveIteamListingUnpaid();
  updateCustormerDataUnpaid();
}

function saveDataUnpaid() {
  const rows = document.querySelectorAll("#iteamListingTableBodyUnpaid tr");
  let data = [];

  const date = document.getElementById("date").value;
  const billId = document.getElementById("billId").value;

  rows.forEach((row) => {
    const product = row.querySelector('input[name="productunpaid"]').value;
    const pid = row.querySelector('input[name="hiddenPID"]').value;
    const qty = row.querySelector('input[name="qtyunpaid"]').value;
    const rate = row.querySelector('input[name="rateunpaid"]').value;
    const discount = row.querySelector('input[name="discountunpaid"]').value;
    const currency = row.querySelector('select[name="currencyunpaid"]').value;

    if (pid && product && qty && rate && discount && currency) {
      data.push({
        productlist_id: pid,
        product_id: product,
        qty: qty,
        rate: rate,
        discount: discount,
        currency_name_add_id: currency,
        date: date,
        job_no: billId,
      });
    }
  });

  if (data.length > 0) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "updateProductListing.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.status === "success") {
            alert("Bill saved successfully!");
            window.location.reload();
          } else {
            alert(response.message || "An error occurred while saving data.");
          }
        } catch (e) {
          console.error("Failed to parse response:", e);
          alert("An unexpected error occurred.");
        }
      }
    };
    xhr.send(JSON.stringify(data));
  } else {
    document.getElementById("errormassege").innerHTML =
      "Please fill out all fields before saving.";
  }
}

function saveIteamListingUnpaid() {
  var project = document.getElementById("projectunpaid").value;
  var location = document.getElementById("locationunpaid").value;
  var pxg = document.getElementById("pxgUnpaid").value;
  var tourno = document.getElementById("tournoUnpaid").value;
  var tourtype = document.getElementById("tourtypeUnpaid").value;
  var billmethod = document.getElementById("billmethodunpaid").value;
  var billstatus = document.getElementById("billstatusunpaid").value;
  var company = document.getElementById("companyunpaid").value;
  var vender = document.getElementById("venderunpaid").value;
  var operater = document.getElementById("operaterunpaid").value;
  var billId = document.getElementById("billId").value;

  var form = new FormData();

  form.append("billId", billId);
  form.append("project", project);
  form.append("location", location);
  form.append("pxg", pxg);
  form.append("tourno", tourno);
  form.append("tourtype", tourtype);
  form.append("billmethod", billmethod);
  form.append("billstatus", billstatus);
  form.append("company", company);
  form.append("vender", vender);
  form.append("operater", operater);

  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState === 4 && req.status === 200) {
      if (req.responseText == "success") {
        alert(req.responseText);
      } else {
        alert(req.responseText);
      }
    }
  };

  req.open("POST", "addBillUnPayiedData.php", true);
  req.send(form);
}

function updateCustormerDataUnpaid() {
  var cid = document.getElementById("custormerSearchMobileValueUnpaid").value;
  var mobile = document.getElementById("custormerSearchMobileUnpaid").value;
  var email = document.getElementById("custormerSearchEmailUnpaid").value;

  var f = new FormData();
  f.append("cid", cid);
  f.append("cmobile", mobile);
  f.append("cemail", email);

  var x = new XMLHttpRequest();

  x.onreadystatechange = function () {
    if (x.readyState === 4 && x.status === 200) {
      alert(x.responseText);
    }
  };

  x.open("POST", "updateCustormerData.php", true);
  x.send(f);
}

function caclulateFinaleValue() {}
