<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Store</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
<h1>My Store Products</h1>

<!-- Add Product Form -->
<h2>Add New Product</h2>
<form id="addForm">
<input type="text" name="title" placeholder="Title" required>
<input type="number" step="0.01" name="price" placeholder="Price" required>
<input type="text" name="description" placeholder="Description" required>
<input type="text" name="category" placeholder="Category" required>
<input type="text" name="image" placeholder="Image URL" required>
<button class="add-btn">Add Product</button>
</form>

<hr>

<div id="products"></div>

<script>
// Fetch all products
function loadProducts(){
    fetch('get_all_products.php')
    .then(res=>res.json())
    .then(data=>{
        let html = '';
        data.forEach(p=>{
            html += `<div class="product" data-id="${p.id}">
                <img src="${p.image}" alt="${p.title}">
                <h3>${p.title}</h3>
                <p class="price">$${p.price}</p>
                <p>${p.description}</p>
                <p><strong>Category:</strong> ${p.category}</p>
                <button class="update-btn">Update</button>
                <button class="delete-btn">Delete</button>
            </div>`;
        });
        document.getElementById('products').innerHTML = html;
        attachEvents();
    });
}

// Attach update/delete button events
function attachEvents(){
    document.querySelectorAll('.delete-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            let id = this.parentElement.dataset.id;
            if(confirm('Delete this product?')){
                fetch('delete_product.php?id='+id,{method:'GET'})
                .then(res=>res.json())
                .then(res=>{
                    alert(res.message);
                    loadProducts();
                });
            }
        });
    });

    document.querySelectorAll('.update-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            let parent = this.parentElement;
            let id = parent.dataset.id;
            let title = prompt('New title', parent.querySelector('h3').innerText);
            let price = prompt('New price', parent.querySelector('.price').innerText.replace('$',''));
            let description = prompt('New description', parent.querySelectorAll('p')[1].innerText);
            let category = prompt('New category', parent.querySelectorAll('p')[2].innerText.replace('Category: ',''));
            let image = prompt('New image URL', parent.querySelector('img').src);
            let obj = {title,price,description,category,image};

            fetch('update_product.php?id='+id,{
                method:'POST',
                headers:{'Content-Type':'application/json'},
                body: JSON.stringify(obj)
            }).then(res=>res.json())
            .then(res=>{
                alert(res.message);
                loadProducts();
            });
        });
    });
}

// Add new product
document.getElementById('addForm').addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
    let obj = {};
    formData.forEach((v,k)=>obj[k]=v);

    fetch('add_product.php',{
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(obj)
    }).then(res=>res.json())
    .then(res=>{
        alert(res.message);
        this.reset();
        loadProducts();
    });
});

// Initial load
loadProducts();
</script>

</div>
</body>
</html>
