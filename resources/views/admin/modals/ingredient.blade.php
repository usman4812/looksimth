<div class="modal fade" id="add_ingredient" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Ingredient</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addIngredientForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" placeholder=""
                                value="" required />
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" placeholder=""
                                value="" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Status:</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">Select a Status...</option>
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Image</label>
                            <input type="file" class="form-control form-control-sm" name="icon" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="Create" class="btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#addIngredientForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.settings.ingredient.add') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert(response.message, 'success', 'btn btn-success');
                    $('#addIngredientForm')[0].reset();
                    $('#addIngredientForm').find(
                            'input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('').trigger('change');
                    $('#add_ingredient').modal('hide');
                    updateIngredients();
                } else {
                    swalAlert('Failed to add ingredient. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                // Handle error response
                hideOverlay();
                var errorMessage = xhr.responseJSON?.message ||
                    'Something went wrong. Please try again later.';
                swalAlert(errorMessage, 'error', 'btn btn-danger');
            }
        });
    });
    //  get update ingredients
    function updateIngredients() {
        $.ajax({
            url: "{{ route('get.ingredients') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var ingredients = response.data;
                    var $ingredientContainer = $('.ingredient-container');
                    $ingredientContainer.empty();
                    $.each(ingredients, function(index, ingredient) {
                        var checkboxHtml = `
                        <div class="col-lg-2 fv-row fv-plugins-icon-container mt-2">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-inline me-2">
                                    <input class="form-check-input"
                                           name="ingredients[]" type="checkbox"
                                           value="${ingredient.uuid}">
                                    <span class="fw-semibold ps-2 fs-6">${ingredient.name}</span>
                                </label>
                            </div>
                        </div>
                    `;
                        $ingredientContainer.append(checkboxHtml);
                    });
                } else {
                    swalAlert('Failed to fetch ingredients. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching ingredients. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
