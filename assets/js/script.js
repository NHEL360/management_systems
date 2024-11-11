/project-root/assets/js/script.js
// JavaScript to open and close the modal
document.getElementById('addProductBtn').onclick = function() {
    document.getElementById('addProductModal').style.display = 'block';
};

document.getElementById('closeAddProductModal').onclick = function() {
    document.getElementById('addProductModal').style.display = 'none';
};
console.log('script.js loaded');
