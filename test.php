
<!-- Table to hold the dynamically added rows -->
<table id="currencyTable">
    <thead>
        <tr>
            <th>Currency</th>
            <th>Exchange Rate</th>
            <th>Amount</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="currencyTableBody">
        <!-- Rows will be added dynamically here -->
    </tbody>
</table>

<br>
<button onclick="addRow();" class="btn btn-info">Add Row</button>

<br>
<div>
    <h6 style="border: none;" class="form-control fs-6 text-end">
        Total Cash: <input id="grandTotal" type="text" disabled>
    </h6>
</div>

<!-- JavaScript for dynamic row addition and total calculation -->
<script>
    let rowCount = 0;

    // Function to add a new row dynamically
    function addRow() {
        rowCount++;  // Increment rowCount to ensure unique IDs

        // Create a new row with unique IDs for the input fields
        const newRow = `
            <tr>
                <td>
                    <select class="form-control">
                        <option value="">Select</option>
                        <?php echo $options; ?>
                    </select>
                </td>
                <td><input onchange="calculateRowTotal(${rowCount})" class="form-control text-end" placeholder="00.00" id="exchangeRate${rowCount}" type="number" step="0.01"></td>
                <td><input onchange="calculateRowTotal(${rowCount})" class="form-control text-end" placeholder="00.00" id="amount${rowCount}" type="number" step="0.01"></td>
                <td><span id="rowTotal${rowCount}">0.00</span></td>
                <td><i class="fa fa-trash-o fs-5 text-danger" onclick="deleteRow(this)"></i></td>
            </tr>
        `;

        // Append the new row to the table body
        document.getElementById("currencyTableBody").insertAdjacentHTML('beforeend', newRow);
    }

    // Function to calculate the total for a single row
    function calculateRowTotal(rowId) {
        const exchangeRate = parseFloat(document.getElementById(`exchangeRate${rowId}`).value) || 0;
        const amount = parseFloat(document.getElementById(`amount${rowId}`).value) || 0;
        const rowTotal = exchangeRate * amount;

        // Update the row total
        document.getElementById(`rowTotal${rowId}`).textContent = rowTotal.toFixed(2);

        // Recalculate the grand total
        updateGrandTotal();
    }

    // Function to update the grand total across all rows
    function updateGrandTotal() {
        let grandTotal = 0;

        // Get all row totals and sum them
        const rowTotals = document.querySelectorAll("[id^='rowTotal']");
        rowTotals.forEach(rowTotal => {
            grandTotal += parseFloat(rowTotal.textContent) || 0;
        });

        // Update the grand total display
        document.getElementById("grandTotal").value = grandTotal.toFixed(2);
    }

    // Function to delete a row
    function deleteRow(element) {
        const row = element.closest('tr');
        row.remove();

        // Recalculate the grand total after a row is deleted
        updateGrandTotal();
    }
</script>