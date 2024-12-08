function openModal(button) {
    document.getElementById('textReferenceNumber').innerText = button.getAttribute('data-id');
    document.getElementById('textRoomNumber').innerText = button.getAttribute('data-room');
    document.getElementById('textTenantIdDisplay').innerText = button.getAttribute('data-tenant');
    
    document.getElementById('modalReferenceNumber').value = button.getAttribute('data-id');
    document.getElementById('modalTenantId').value = button.getAttribute('data-tenant');
    document.getElementById('modalTenantFName').value = button.getAttribute('data-tenantfname');
    document.getElementById('modalTenantLName').value = button.getAttribute('data-tenantlname');
    document.getElementById('modalDateOfPayment').value = button.getAttribute('data-date');
    document.getElementById('modalAmount').value = button.getAttribute('data-amount');
    document.getElementById('modalStatus').value = button.getAttribute('data-status');

    document.getElementById('myModal').style.display = "block";
}

function closeModal() {
    document.getElementById('myModal').style.display = "none";
}


//window.onclick = function(event) {
//    if (event.target == document.getElementById('myModal')) {
//        closeModal();
//    }
//}


function opencreate(button) {
    document.getElementById('createrecord').style.display = "block";
}

function closecreate() {
    document.getElementById('createrecord').style.display = "none";
}

//window.onclick = function(event) {
//    if (event.target == document.getElementById('createrecord')) {
//        closecreate();
//    }
//}

document.addEventListener('DOMContentLoaded', function() {
    var createTenantIdElement = document.getElementById('createTenantId');
    if (createTenantIdElement) {
        createTenantIdElement.addEventListener('change', function(event) {
            event.preventDefault();
            updateTenantDetails();
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    var createRecordFormElement = document.getElementById('createRecordForm');
    if (createRecordFormElement) {
        document.getElementById('createRecordForm').addEventListener('submit', function(event) {
            event.preventDefault();
        
            var formData = new FormData(this);
        
            fetch('create.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      closecreate();
                      alert("Record created successfully");
                  } else {
                      document.getElementById("errorMessageDisplay").textContent = data.message;
                  }
              }).catch(error => {
                  console.error('Error:', error);
                  document.getElementById("errorMessageDisplay").textContent = "An error occurred. Please try again.";
              });
        });
    }
});



document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        var rowId = this.getAttribute('data-row-id');
        deleteRow(rowId);
    });
});

function deleteRow(rowId) {
    fetch(`delete.php?id=${rowId}`, {
        method: 'GET'
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              document.getElementById(`row-${rowId}`).remove();
          } else {
              alert('Error deleting row');
          }
      }).catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
      });
}

function updateTenantDetails() {
    var select = document.getElementById("createTenantId");
    var selectedOption = select.options[select.selectedIndex];
    if (selectedOption.value === "") {
        document.getElementById("tenantDetails").style.display = "none";
        return;
    }

    var roomRentalFee = parseFloat(selectedOption.getAttribute("data-room-rental-fee"));
    var electricityBasePrice = parseFloat(selectedOption.getAttribute("data-electricity-base-price"));
    var waterBasePrice = parseFloat(selectedOption.getAttribute("data-water-base-price"));

    document.getElementById("roomNumber").textContent = selectedOption.getAttribute("data-room-number");
    document.getElementById("roomRentalFee").textContent = roomRentalFee;
    document.getElementById("electricityBasePrice").textContent = electricityBasePrice;
    document.getElementById("waterBasePrice").textContent = waterBasePrice;

    document.getElementById("electricityBasePriceHidden").value = electricityBasePrice;
    document.getElementById("waterBasePriceHidden").value = waterBasePrice;

    document.getElementById("tenantDetails").style.display = "block";

    updateTotalCost();
}

function updateTotalCost() {
    var electricityConsumption = parseFloat(document.getElementById("electricitycons").value) || 0;
    var waterConsumption = parseFloat(document.getElementById("watercons").value) || 0;
    var electricityBasePrice = parseFloat(document.getElementById("electricityBasePrice").textContent) || 0;
    var waterBasePrice = parseFloat(document.getElementById("waterBasePrice").textContent) || 0;

    var totalElectricityCost = electricityConsumption * electricityBasePrice;
    var totalWaterCost = waterConsumption * waterBasePrice;
    var totalCost = totalElectricityCost + totalWaterCost;

    document.getElementById("totalcosts").textContent = totalCost.toFixed(2);
    document.getElementById("createAmount").value = totalCost.toFixed(2);
    document.getElementById("electricity_cost").textContent = totalElectricityCost.toFixed(2);
    document.getElementById("water_cost").textContent = totalWaterCost.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    var dateInput = document.getElementById('date_of_payment');
    if (dateInput) {
        var today = new Date();
        var todayDateString = today.toISOString().split('T')[0];
        dateInput.setAttribute('min', todayDateString);
    }

    var errorMessage = document.getElementById("errorMessageDisplay").textContent;
    if (errorMessage) {
        document.getElementById("tenantDetails").style.display = "block";
    }
});




function openServiceOverlay() {
    document.getElementById("serviceoverlay").style.display = "block";
}

function closeServiceOverlay() {
    document.getElementById("serviceoverlay").style.display = "none";
}


function confirmLogout() {
    var confirmation = confirm("Are you sure you want to logout?");
    if (confirmation) {
        window.location.href = 'logout.php'; // Redirect to the logout script
    }
}
