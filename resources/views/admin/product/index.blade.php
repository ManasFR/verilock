@extends('admin.layout.app')

@include('admin.navbar.header')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <h3 class="text-center mb-4">Product Management</h3>
<br>
    <div class="d-flex justify-content-between mb-4">
        <h5>Product List</h5>
        <input type="text" id="searchInput" class="form-control" placeholder="Search products..." style="width: 50%;">
        <a href="{{ route('products') }}" class="btn btn-success" style="width: 20%"><i class="fas fa-box"></i>  Create Product</a>
    </div>

    @if ($products->isEmpty())
        <p class="text-center">No products found. Click "Create Product" to add a new one.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>{{ $product->updated_at }}</td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?');" style="background: red"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const productTable = document.getElementById("productTable");
        const productCheckboxes = document.querySelectorAll(".productCheckbox");
        const deleteSelectedBtn = document.getElementById("deleteSelectedBtn");

        // Search Function
        searchInput.addEventListener("keyup", function () {
            let filter = searchInput.value.toLowerCase();
            let rows = productTable.getElementsByTagName("tr");
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                let found = false;
                for (let j = 1; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        });

        // Handle individual checkbox selection
        productCheckboxes.forEach(cb => cb.addEventListener("change", toggleDeleteButton));

        function toggleDeleteButton() {
            let anyChecked = Array.from(productCheckboxes).some(cb => cb.checked);
            deleteSelectedBtn.style.display = anyChecked ? "inline-block" : "none";
        }

        // Bulk Delete
        deleteSelectedBtn.addEventListener("click", function () {
            let selectedIds = Array.from(productCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (selectedIds.length === 0) return;
            if (!confirm("Are you sure you want to delete the selected products?")) return;

            fetch("", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ product_ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                alert("Selected products deleted successfully!");
                location.reload();
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>
