
    <?php if (!empty($email_err)): ?>
        document.getElementById('emailError').innerText = "<?php echo $email_err; ?>";
    <?php endif; ?>
    <?php if (!empty($password_err)): ?>
        document.getElementById('passwordError').innerText = "<?php echo $password_err; ?>";
    <?php endif; ?>
 