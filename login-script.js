document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.querySelector('input[name="email"]').value;
    const password = document.querySelector('input[name="password"]').value;

    if (!email || !password) {
        e.preventDefault(); // Stop form submission
        alert("Please fill in all fields.");
    } else {
        // Optional: Show a loading spinner on the button
        const btn = document.querySelector('.login-btn');
        btn.innerText = "Authenticating...";
        btn.style.opacity = "0.7";
    }
});