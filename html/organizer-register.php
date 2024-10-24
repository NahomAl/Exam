<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register As Exam Organizer</title>
    <link rel="stylesheet" href="../css/new.css">
    <style>
        /*form{
            display: grid;

        }
        input, select{
            width: 50%;
            margin-bottom: 20px;
            padding: 5px;
        }
        input[type="submit"]{
            width: 10%;
            padding: 10px 0;

        }*/

    </style>
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
</head>
<body>
    
    <form name="org-reg-form" action="organizer-register.php" method="post">
        <label for="org-name">Organization name</label><input type="text" name="org-name" id="org-name" required>
        <label for="industry">Industry</label>
        <select name="industry">
            <option value="none" selected disabled>Select an industry</option>
            <option value="education">Education</option>
            <option value="corp-training">Corporate training</option>
            <option value="certification">Certification</option>
            <option value="other">Other</option>
        </select>
        <label for="email">E-mail</label> <input type="email" name="email" id="email" required>
        <label for="country">Country</label> <input type="text" name="country" id="country" required>
        <label for="city">City</label> <input type="text" name="city" id="city" required>
        
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
        let form = document.forms['org-reg-form'];
        form.addEventListener('submit', (e) => validateForm(e));
        function validateForm(e){
            let errDiv = document.querySelector('.err-div');
            errDiv.innerText = '';
            const orgName = form['org-name'];
            const industry = form['industry'];
            const country = form['country'];
            const city = form['city'];
            const username = form['username'];
            const password = form['password'];
            const password2 = form['password2'];

            //let regex = /^[A-Za-z][A-Za-z0-9_- ]*$/;
            const regex = /^[A-Z][\w-_ ]*$/i;
            const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[-_@$!%*?&])[A-Za-z\d@$!%*?&]{6,20}$/;
            //at least one uppercase, lowercase0, digit and @$!%*?&. 6-20 characters
            if (!regex.test(orgName.value))
                errDiv.innerText += 'Invalid Organization name\n';
            if (industry.value === 'none')
                errDiv.innerText += 'Industry not selected\n';
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