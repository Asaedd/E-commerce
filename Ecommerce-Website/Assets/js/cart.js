function calculateTotal(product_id, price) {
    var quantity = parseFloat(document.getElementById('quantity_' + product_id).value);
    var total = price * quantity;
    document.getElementById('subtotal-value_' + product_id).innerHTML = '$' + total.toFixed(2);
}

function calculateCartTotal() {
    const subtotals = document.querySelectorAll("[id^='subtotal-value_']");
    let total = 0;
    subtotals.forEach(element => {
    const value = parseFloat(element.innerHTML.replace('$', ''));
    total += value;
    });

    document.getElementById("cart-subtotal").innerHTML = "$" + total.toFixed(2);
    
    document.querySelectorAll("[id^='quantity_']").forEach(element => {
        element.addEventListener('input', calculateCartTotal);
    });
}

function updateQuantity(product_id, size, newQuantity) {
    var newUrl = window.location.href.split('?')[0] + '?update=' + product_id + '_' + size + '&quantity=' + newQuantity;

    window.location.href = newUrl;
}

calculateCartTotal();