// script.js - Modal functionality and animation

// Open Register Modal
document.getElementById('show-register-modal').onclick = function() {
    document.getElementById('register-modal').style.display = 'block';
};

// Close Register Modal
document.getElementById('close-register-modal').onclick = function() {
    document.getElementById('register-modal').style.display = 'none';
};

// Close Register Modal if clicked outside
window.onclick = function(event) {
    if (event.target === document.getElementById('register-modal')) {
        document.getElementById('register-modal').style.display = 'none';
    }
};
