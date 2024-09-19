// sign_up.js
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signupForm');
    const message = document.getElementById('message');

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        
        const formData = new FormData(form);
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm-password');

        // Basic client-side validation
        if (password !== confirmPassword) {
            message.textContent = 'Passwords do not match!';
            message.style.color = 'red';
            return;
        }

        // Send form data using AJAX
        fetch('sign_up.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                message.textContent = 'Sign-up successful!';
                message.style.color = 'green';
                form.reset();
            } else {
                message.textContent = data.message || 'Sign-up failed!';
                message.style.color = 'red';
            }
        })
        .catch(error => {
            message.textContent = 'An error occurred!';
            message.style.color = 'red';
        });
    });
});
