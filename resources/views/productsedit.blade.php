<!-- Edit Product Modal 
<div class="modal fade" id="productActionModal" tabindex="-1" role="dialog" aria-labelledby="productActionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productActionModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm">
                    <input type="hidden" id="productId" name="id">
                    <div class="form-group">
                        <label for="productNameUpdate">Product Name</label>
                        <input type="text" class="form-control" id="productNameUpdate" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="productDescriptionUpdate">Product Description</label>
                        <textarea class="form-control" id="productDescriptionUpdate" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productPriceUpdate">Price</label>
                        <input type="number" class="form-control" id="productPriceUpdate" name="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
