const cartItems = document.getElementById("cart-items");
const cartSummary = document.getElementById("cart-summary");

function renderCart() {
  const cart = JSON.parse(localStorage.getItem('fitfuel_cart')) || [];
  cartItems.innerHTML = "";
  cartSummary.innerHTML = "";

  if (cart.length === 0) {
    cartItems.innerHTML = "<p>Your cart is empty.</p>";
    return;
  }

  let total = 0;

  cart.forEach((item, index) => {
    const itemDiv = document.createElement("div");
    itemDiv.className = "product";
    itemDiv.innerHTML = `
      <img src="${item.img}" alt="${item.name}" style="width:100px;height:100px;object-fit:contain;">
      <h3>${item.name}</h3>
      <p>Price: ₹${item.price}</p>
      <button onclick="removeItem(${index})">Remove</button>
    `;
    cartItems.appendChild(itemDiv);
    total += item.price;
  });

  cartSummary.innerHTML = `
    <h3>Total: ₹${total}</h3>
    <button onclick="checkout()">Checkout</button>
  `;
}

function removeItem(index) {
  const cart = JSON.parse(localStorage.getItem('fitfuel_cart')) || [];
  cart.splice(index, 1);
  localStorage.setItem('fitfuel_cart', JSON.stringify(cart));
  renderCart();
  updateCartCount();
}

function checkout() {
  const cart = JSON.parse(localStorage.getItem('fitfuel_cart')) || [];
  if (cart.length === 0) {
    alert("Your cart is empty.");
    return;
  }
  alert("Thank you for your purchase!");
  localStorage.removeItem('fitfuel_cart');
  renderCart();
  updateCartCount();
}

function addToCart(name, price, img) {
  const cart = JSON.parse(localStorage.getItem('fitfuel_cart')) || [];
  cart.push({ name, price, img });
  localStorage.setItem('fitfuel_cart', JSON.stringify(cart));
  alert(`${name} added to cart!`);
  updateCartCount();
}

function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem('fitfuel_cart')) || [];
  const countEl = document.getElementById('cart-count');
  if (countEl) countEl.textContent = cart.length;
}

document.addEventListener("DOMContentLoaded", () => {
  renderCart();
  updateCartCount();
});
