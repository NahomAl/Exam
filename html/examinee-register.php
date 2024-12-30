<?php
    session_start();
    if (isset($_POST['register'])){

    }
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register As Examinee</title>
    <link rel="stylesheet" href="../css/org-reg-style.css">
</head>
<body>
    <form name="examinee-reg-form" action="examinee-register.php" method="post">
        <h2>Examinee Register</h2>
        <label for="first-name">First name</label><input type="text" name="first-name" id="first-name" required>
        <label for="last-name">Last name</label><input type="text" name="last-name" id="last-name" required>
        <label for="age">Age</label><input type="number" name="age" id="age" required>
        <label for="">Gender</label>
        <label class="gender-option">
            <input type="radio" name="gender" value="M" required>
            <span>Male</span>
        </label>
        <label class="gender-option">
            <input type="radio" name="gender" value="F">
            <span>Female</span>
        </label>
        
        <label for="country">Country</label> <input type="text" name="country" id="country" required>
        <label for="city">City</label> <input type="text" name="city" id="city" required>
        <select name="org" id="org">
            <?php
                require_once 'dbConnect.php';
                $result = mysqli_query($conn, "SELECT Organizer_ID, Organizer_name FROM organizer");
                while($row = mysqli_fetch_assoc($result)) {
                    $orgID = $row['Organizer_ID'];
                    $orgName = $row['Organizer_name'];
                    echo "<option value='$orgID'>$orgName</option>";
                }
            ?>
        </select>
        
        <label for="username">Username</label> <input type="text" name="username" id="username" required>
        <label for="password">Password</label> <input type="password" name="password" id="password" required>
        <label for="password2">Confirm Password</label> <input type="password" name="password2" id="password2" required>
        <div class="err-div"></div>
        <input type="submit" name="register" value="Register">
        <?php
            include('org-register-handler.php');
        ?>

    </form>
    <script>
        //alert('submitting');
        let form = document.forms['examinee-reg-form'];
        form.addEventListener('submit', (e) => validateForm(e));
        function validateForm(e){
            let errDiv = document.querySelector('.err-div');
            errDiv.innerText = '';
            const fName = form['first-name'];
            const lName = form['last-name'];
            const age = form['age'];
            const country = form['country'];
            const city = form['city'];
            const username = form['username'];
            const password = form['password'];
            const password2 = form['password2'];

            //let regex = /^[A-Za-z][A-Za-z0-9_- ]*$/;
            const regex = /^[A-Z][\w-_ ]*$/i;
            const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[-_@$!%*?&])[A-Za-z\d@$!%*?&]{6,20}$/;
            //at least one uppercase, lowercase0, digit and @$!%*?&. 6-20 characters
            if (!regex.test(fName.value))
                errDiv.innerText += 'Invalid First name\n';
            if (!regex.test(lName.value))
                errDiv.innerText += 'Invalid Last name\n';
            if (age.value <= 0)
                errDiv.innerText += 'Invalid age\n';
            if (!regex.test(country.value))
                errDiv.innerText += 'Invalid Country\n';
            if (!regex.test(city.value))
                errDiv.innerText += 'Invalid City\n';
            if (!regex.test(username.value))
                errDiv.innerText += 'Invalid username\n';
            if (!regexPassword.test(password.value))
                errDiv.innerText += `password should contain atleast one uppercase character, one lowecase character,
                                     one symbol among -_@$!%*?& and should be between 6-20 characters long\n`;
            if (password.value !== password2.value)
                errDiv.innerText += "Passwords don't match\n";
            if(errDiv.innerText !== '')
                e.preventDefault();
        }

    </script>
</body>
</html>