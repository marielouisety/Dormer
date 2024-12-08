function opencontainer(roomNumber) {
    //console.log("Opening container for room number: " + roomNumber);
    document.getElementById('roomnumber').value = roomNumber;  // Set hidden input field value
    console.log(hello);
    document.getElementById('roomnumber-display').innerText = "Room " + roomNumber;  // Display room number
    document.getElementById('add-tenant-container').style.display = 'block';  // Show the container
}

function closecontainer() {
    document.getElementById('add-tenant-container').style.display = 'none';  // Hide the container
}

window.onclick = function(event) {
    if (event.target == document.getElementById('add-tenant-container')) {
        closeModal();
    }
}



function showOverlay(roomNumber, fName, lName, availability, dateOfBirth, contactNumber, age, gender, email) {
    var tenantName = `${fName} ${lName}`;
    var tenantDetails = `
        <h3>Room Number: ${roomNumber}</h3>
        <p><strong>Tenant:</strong> ${tenantName}</p>
        <p><strong>Status:</strong> ${availability}</p>
    `;
    if (availability === 'Occupied') {
        tenantDetails += `
            <form id="tenantForm" method="POST" action="update_tenant.php">
                <input type="hidden" name="room_number" value="${roomNumber}">
                <div class="form-group">
                    <label for="fName">First Name:</label>
                    <input type="text" id="fName" name="fName" value="${fName}" required>
                </div>
                <div class="form-group">
                    <label for="lName">Last Name:</label>
                    <input type="text" id="lName" name="lName" value="${lName}" required>
                </div>
                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth:</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" value="${dateOfBirth}" oninput="calculateAge()" required>
                </div>
                <div class="form-group">
                    <label for="contactNumber">Contact Number:</label>
                    <input type="text" id="contactNumber" name="contactNumber" value="${contactNumber}" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="${age}" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="M" ${gender === 'M' ? 'selected' : ''}>Male</option>
                        <option value="F" ${gender === 'F' ? 'selected' : ''}>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="${email}" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="save-btn" onclick="updateTenant('${roomNumber}')">Save</button>
                    <button type="button" class="delete-btn" onclick="deleteTenant('${roomNumber}')">Delete</button>
                </div>
            </form>
        `;
    } else {
        tenantDetails += `
            <form id="tenantForm" method="POST" action="add_tenant.php">
                <input type="hidden" name="room_number" value="${roomNumber}">
                <div class="form-group">
                    <label for="fName">First Name:</label>
                    <input type="text" id="fName" name="fName" required>
                </div>
                <div class="form-group">
                    <label for="lName">Last Name:</label>
                    <input type="text" id="lName" name="lName" required>
                </div>
                <div class="form-group">
                    <label for="dateOfBirth">Date of Birth:</label>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" required oninput="calculateAge()">
                </div>
                <div class="form-group">
                    <label for="contactNumber">Contact Number:</label>
                    <input type="text" id="contactNumber" name="contactNumber" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Add</button>
                </div>
            </form>
        `;
    }
    document.getElementById('tenantDetails').innerHTML = tenantDetails;
    document.getElementById('overlay').style.display = 'flex';
}

function closeOverlay() {
    document.getElementById('overlay').style.display = 'none';
}

function checkQueryParams() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        alert(urlParams.get('success'));
    }
}

window.onload = checkQueryParams;

function updateTenant(roomNumber) {
    var form = document.getElementById('tenantForm');
    var formData = new FormData(form);
    formData.append('room_number', roomNumber); // Add room number to the form data

    fetch('update_tenant.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
    .then(data => {
        alert(data);
        closeOverlay();
        location.reload();
    });
}

function deleteTenant(roomNumber) {
    if (confirm('Are you sure you want to delete this tenant?')) {
        fetch('delete_tenant.php', {
            method: 'POST',
            body: new URLSearchParams(`room_number=${roomNumber}`)
        }).then(response => response.text())
        .then(data => {
            alert(data);
            closeOverlay();
            location.reload();
        });
    }
}

function addTenant(roomNumber) {
    var form = document.getElementById('tenantForm');
    var formData = new FormData(form);
    formData.append('room_number', roomNumber); // Add room number to the form data

    fetch('add_tenant.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
    .then(data => {
        alert(data);
        closeOverlay();
        location.reload();
    });
}

function calculateAge() {
    var dob = document.getElementById('dateOfBirth').value;
    var age = document.getElementById('age');
    if (dob) {
        var today = new Date();
        var birthDate = new Date(dob);
        var ageCalc = today.getFullYear() - birthDate.getFullYear();
        var monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            ageCalc--;
        }
        age.value = ageCalc;
    } else {
        age.value = '';
    }
}

function confirmLogout() {
    var confirmation = confirm("Are you sure you want to logout?");
    if (confirmation) {
        window.location.href = 'logout.php'; // Redirect to the logout script
    }
}