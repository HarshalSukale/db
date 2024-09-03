document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Clear previous error messages
    document.getElementById('usernameError').innerText = '';
    document.getElementById('emailError').innerText = '';
    document.getElementById('phoneError').innerText = '';
    document.getElementById('dobError').innerText = '';
    document.getElementById('genderError').innerText = '';
    document.getElementById('addressError').innerText = '';
    document.getElementById('courseError').innerText = '';
    document.getElementById('termsError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    document.getElementById('confirmPasswordError').innerText = '';

    // Get form values
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const dob = document.getElementById('dob').value.trim();
    const gender = document.querySelector('input[name="gender"]:checked');
    const address = document.getElementById('address').value.trim();
    const course = document.getElementById('course').value;
    const terms = document.getElementById('terms').checked;
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    let isValid = true;

    // Validate username
    if (username === '') {
        document.getElementById('usernameError').innerText = 'Username cannot be empty.';
        isValid = false;
    }

    // Validate email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '' || !emailPattern.test(email)) {
        document.getElementById('emailError').innerText = 'Please enter a valid email address.';
        isValid = false;
    }

    // Validate phone number
    const phonePattern = /^\d{10}$/;
    if (phone === '' || !phonePattern.test(phone)) {
        document.getElementById('phoneError').innerText = 'Please enter a valid 10-digit phone number.';
        isValid = false;
    }

    // Validate date of birth
    if (dob === '') {
        document.getElementById('dobError').innerText = 'Date of birth cannot be empty.';
        isValid = false;
    }

    // Validate gender
    if (!gender) {
        document.getElementById('genderError').innerText = 'Please select your gender.';
        isValid = false;
    }

    // Validate address
    if (address === '') {
        document.getElementById('addressError').innerText = 'Address cannot be empty.';
        isValid = false;
    }

    // Validate course
    if (course === '') {
        document.getElementById('courseError').innerText = 'Please select a course of study.';
        isValid = false;
    }

    // Validate terms and conditions
    if (!terms) {
        document.getElementById('termsError').innerText = 'You must agree to the terms and conditions.';
        isValid = false;
    }

    // Validate password
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$/;
    if (password === '' || !passwordPattern.test(password)) {
        document.getElementById('passwordError').innerText = 'Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*?&).';
        isValid = false;
    }

    // Validate confirm password
    if (confirmPassword !== password) {
        document.getElementById('confirmPasswordError').innerText = 'Confirm password does not match the password.';
        isValid = false;
    }

    // If all validations pass, submit the form
    if (isValid) {
        alert('Registration successful!');
        // You can add code here to actually submit the form, e.g., via AJAX or by removing event.preventDefault()
        // For example:
        // this.submit(); // Uncomment this line if you want the form to actually submit
    }
});