function viewCountry(id) {
    window.location = "newCountry.php?id=" + id;
}

async function addNewCountry() {
    const country = {
        countryName: document.getElementById("countryName").value,
        countryCode: document.getElementById("countryCode").value,
    };

    const response = await fetch("addNewCountry.php", {
        method: "POST",
        body: JSON.stringify(country),
        headers: {
            "Content-Type": "application/json",
        },
    });

    if (response.ok) {
        const json = await response.json();

        if (json.success) {
            alert(json.msg);
            window.location.reload();
        } else {
            alert(json.msg);
            window.location.reload();
        }
    } else {
        alert("Oops Something went wrong!");
    }
}

async function deleteCountry(id) {
    const country = {
        id: id,
    };

    const response = await fetch("deleteCountry.php", {
        method: "POST",
        body: JSON.stringify(country),
        headers: {
            "Content-Type": "application/json",
        },
    });

    if (response.ok) {
        const json = await response.json();

        if (json.success) {
            alert(json.msg);
            window.location = "country.php";
        } else {
            alert(json.msg);
            window.location.reload();
        }
    } else {
        alert("Oops Something went wrong!");
    }
}

async function searchCountry() {
    const country = {
        search: document.getElementById("search").value,
    };

    const response = await fetch("searchCountry.php", {
        method: "POST",
        body: JSON.stringify(country),
        headers: {
            "Content-Type": "application/json",
        },
    });

    if (response.ok) {
        const json = await response.json();

        if (json.success) {
            document.getElementById("countryTBody").innerHTML = json.content.html;
        } else {
            window.location.reload();
        }
    } else {
        alert("Oops Something went wrong!");
    }
}