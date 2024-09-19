document.addEventListener('DOMContentLoaded', function() {
    // Handle balance check form submission
    document.getElementById('check-balance-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const accountId = document.getElementById('account-id').value;
        
        // Send the account ID to the server
        fetch('savings.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'account-id': accountId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('balance-response').innerText = `Balance: $${data.balance}`;
            } else {
                document.getElementById('balance-response').innerText = 'Account not found or error retrieving balance.';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('balance-response').innerText = 'An error occurred.';
        });
    });
});
