/*
RR_script.js
Funcionalidad (3-5 líneas):
Este archivo implementa el carrito de compras dinámico de FoodExpress.
- Mantiene el carrito en sessionStorage para persistencia temporal.
- Permite agregar/quitar productos sin recargar la página, valida cantidades,
- Calcula subtotales por ítem y total global, y actualiza el contador de items.
*/

// Namespace simple rrCart
const rrCartKey = "rr_cart_v1";

function getCart() {
  const raw = sessionStorage.getItem(rrCartKey);
  return raw ? JSON.parse(raw) : {};
}

function saveCart(cart) {
  sessionStorage.setItem(rrCartKey, JSON.stringify(cart));
  renderCart();
}

function addToCart(id, name, price, qty) {
  qty = parseInt(qty) || 1;
  if (qty < 1) return;
  const cart = getCart();
  if (!cart[id]) {
    cart[id] = { id, name, price: parseFloat(price), qty: 0 };
  }
  cart[id].qty += qty;
  saveCart(cart);
}

function updateQty(id, qty) {
  qty = parseInt(qty) || 0;
  const cart = getCart();
  if (!cart[id]) return;
  if (qty <= 0) {
    delete cart[id];
  } else {
    cart[id].qty = qty;
  }
  saveCart(cart);
}

function removeItem(id) {
  const cart = getCart();
  if (cart[id]) delete cart[id];
  saveCart(cart);
}

function calculateTotals(cart) {
  let total = 0;
  let count = 0;
  for (const k in cart) {
    const it = cart[k];
    total += it.price * it.qty;
    count += it.qty;
  }
  return { total: parseFloat(total.toFixed(2)), count };
}

function renderCart() {
  const cart = getCart();
  const container = document.getElementById("rr-cart-items");
  container.innerHTML = "";
  for (const k in cart) {
    const it = cart[k];
    const div = document.createElement("div");
    div.className = "rr-cart-item";
    div.innerHTML = `<div class="rr-cart-item-name">${it.name}</div>
                         <div class="rr-cart-item-controls">
                           <input type="number" min="1" value="${
                             it.qty
                           }" data-id="${it.id}" class="rr-cart-qty-input">
                           <div class="rr-cart-item-sub">$${(
                             it.price * it.qty
                           ).toFixed(2)}</div>
                           <button class="rr-cart-remove" data-id="${
                             it.id
                           }">Eliminar</button>
                         </div>`;
    container.appendChild(div);
  }
  const totals = calculateTotals(cart);
  document.getElementById("rr-cart-total").textContent =
    totals.total.toFixed(2);
  document.getElementById("rr-cart-count").textContent = totals.count;

  // actualizar hidden input para checkout
  const hidden = document.getElementById("rr-cart-json");
  if (hidden) hidden.value = JSON.stringify(cart);
}

// Delegación de eventos
document.addEventListener("click", function (e) {
  if (e.target.matches(".rr-add-btn")) {
    const id = e.target.dataset.id;
    const name = e.target.dataset.name;
    const price = e.target.dataset.price;
    const input = e.target.parentElement.querySelector(".rr-qty");
    const qty = input ? input.value : 1;
    // Validación de cantidad
    if (parseInt(qty) < 1) {
      alert("La cantidad debe ser al menos 1");
      return;
    }
    addToCart(id, name, price, qty);
  }
  if (e.target.matches(".rr-cart-remove")) {
    const id = e.target.dataset.id;
    removeItem(id);
  }
});

document.addEventListener("input", function (e) {
  if (e.target.matches(".rr-cart-qty-input")) {
    const id = e.target.dataset.id;
    const qty = e.target.value;
    if (parseInt(qty) < 1) {
      e.target.value = 1;
      return;
    }
    updateQty(id, qty);
  }
});

// Filtrado de productos por categoría
document.addEventListener("DOMContentLoaded", function () {
  renderCart();

  document.querySelectorAll(".rr-filter-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const cat = btn.dataset.category;
      document.querySelectorAll(".rr-product-card").forEach((card) => {
        if (cat === "all" || card.dataset.category === cat) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      });
    });
  });

  // Al enviar el formulario de checkout, aseguramos que el carrito no esté vacío
  const checkout = document.getElementById("rr-checkout-form");
  if (checkout) {
    checkout.addEventListener("submit", function (e) {
      const cart = getCart();
      if (Object.keys(cart).length === 0) {
        e.preventDefault();
        alert(
          "El carrito está vacío. Agrega productos antes de confirmar el pedido."
        );
      }
    });
  }
});
