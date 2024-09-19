document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    const closeButton = document.getElementById('close-button');
    const overlay = document.getElementById('overlay');

    menuButton.addEventListener('click', () => {
        sidebar.style.left = '0';
        overlay.style.display = 'block';
    });

    closeButton.addEventListener('click', () => {
        sidebar.style.left = '-250px';
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', () => {
        sidebar.style.left = '-250px';
        overlay.style.display = 'none';
    });

    // Handle balance check form submission
    document.getElementById('check-balance-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const accountId = document.getElementById('account-id').value;
        const pin = document.getElementById('balance-pin').value;

        fetch('check_balance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'account-id': accountId,
                'pin': pin
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('balance-response').innerText = `Balance: $${data.balance}`;
            } else {
                document.getElementById('balance-response').innerText = 'Invalid PIN or account not found.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('balance-response').innerText = 'An error occurred.';
        });
    });

    // Handle payment form submission
    document.getElementById('payment-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('make_payment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('payment-response').textContent = data.message;
        });
    });

    // Handle airtime form submission
    document.getElementById('airtime-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('buy_airtime.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('airtime-response').textContent = data.message;
        });
    });

    // Handle send money form submission
    document.getElementById('send-money-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('send_money.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('send-money-response').textContent = data.message;
        });
    });
});
fetch('send_money.php', {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then(data => {
    console.log(data);  // Add this line
    document.getElementById('send-money-response').textContent = data.message;
})
.catch(error => {
    console.error('Error:', error);
    document.getElementById('send-money-response').textContent = 'An error occurred.';
});
