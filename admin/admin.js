document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll("main section");
    sections.forEach(section => section.style.display = "none");
    document.getElementById("dashboard").style.display = "block";

    document.querySelectorAll(".menu-link").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            sections.forEach(section => section.style.display = "none");
            document.getElementById(this.getAttribute("data-section")).style.display = "block";

            if (this.getAttribute("data-section") === "users") fetchUsers();
            if (this.getAttribute("data-section") === "products") fetchProducts();
            if (this.getAttribute("data-section") === "orders") fetchOrders();
            if (this.getAttribute("data-section") === "payments") fetchPayments();
            if (this.getAttribute("data-section") === "reviews") fetchReviews();
        });
    });

    function fetchUsers() {
        fetch("get_users.php")
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById("user-list");
                table.innerHTML = "";
                data.forEach(user => {
                    table.innerHTML += `
                        <tr>
                            <td>${user.user_id}</td>
                            <td>${user.full_name}</td>
                            <td>${user.email}</td>
                            <td>${user.role}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser(${user.user_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.user_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

// Fetch Products (Now Includes Edit/Delete Buttons)
function fetchProducts() {
    fetch("get_products.php")
        .then(response => response.json())
        .then(data => {
            let table = document.getElementById("product-list");
            table.innerHTML = "";
            data.forEach(product => {
                table.innerHTML += `
                    <tr>
                        <td>${product.product_id}</td>
                        <td>${product.product_name}</td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editProduct(${product.product_id}, '${product.product_name}', '${product.description}', '${product.price}')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.product_id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

// Add Product
function addProduct() {
    let data = {
        product_name: document.getElementById("add-product-name").value,
        description: document.getElementById("add-product-description").value,
        price: document.getElementById("add-product-price").value
    };

    fetch("add_product.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(() => {
        fetchProducts();
        bootstrap.Modal.getInstance(document.getElementById("addProductModal")).hide();
    });
}

// Edit Product
function editProduct(productId, name, description, price) {
    document.getElementById("edit-product-id").value = productId;
    document.getElementById("edit-product-name").value = name;
    document.getElementById("edit-product-description").value = description;
    document.getElementById("edit-product-price").value = price;
    
    const modal = new bootstrap.Modal(document.getElementById("editProductModal"));
    modal.show();
}

function updateProduct() {
    let data = {
        product_id: document.getElementById("edit-product-id").value,
        product_name: document.getElementById("edit-product-name").value,
        description: document.getElementById("edit-product-description").value,
        price: document.getElementById("edit-product-price").value
    };

    fetch("update_product.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(() => {
        fetchProducts();
        bootstrap.Modal.getInstance(document.getElementById("editProductModal")).hide();
    });
}

// Delete Product
function deleteProduct(productId) {
    if (confirm("Are you sure?")) {
        fetch(`delete_product.php?id=${productId}`, { method: "GET" })
        .then(() => fetchProducts());
    }
}

// Initialize Product Functions
window.addProduct = addProduct;
window.updateProduct = updateProduct;
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;


    function fetchOrders() {
        fetch("get_orders.php")
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById("order-list");
                table.innerHTML = "";
                data.forEach(order => {
                    table.innerHTML += `
                        <tr>
                            <td>${order.order_id}</td>
                            <td>${order.user_id}</td>
                            <td>${order.order_date}</td>
                            <td>${order.status}</td>
                            <td>${order.total_price}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editOrder(${order.order_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteOrder(${order.order_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    function fetchPayments() {
        fetch("get_payments.php")
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById("payment-list");
                table.innerHTML = "";
                data.forEach(payment => {
                    table.innerHTML += `
                        <tr>
                            <td>${payment.payment_id}</td>
                            <td>${payment.order_id}</td>
                            <td>${payment.user_id}</td>
                            <td>${payment.amount}</td>
                            <td>${payment.payment_status}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editPayment(${payment.payment_id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deletePayment(${payment.payment_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    function fetchReviews() {
        fetch("get_reviews.php")
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById("review-list");
                table.innerHTML = "";
                data.forEach(review => {
                    table.innerHTML += `
                        <tr>
                            <td>${review.review_id}</td>
                            <td>${review.user_id}</td>
                            <td>${review.rating}</td>
                            <td>${review.comment}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteReview(${review.review_id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }
});

document.getElementById("logout-btn").addEventListener("click", function () {
    fetch("logout.php")
    .then(() => {
        window.location.href = "login.php";
    });
});
