<div class="modal fade" id="add_meal_size" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Meal Size</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body" style="width: 100%;">
                <form id="addMealSizeForm">
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Title:</label>
                            <input type="text" class="form-control form-control-sm" name="title" required/>
                        </div>
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required/>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Description:</label>
                            <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Sort Description:</label>
                            <textarea type="text" class="form-control form-control-sm" name="short_description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Calories Per Day:</label>
                            <input type="text" class="form-control form-control-sm" name="calories_per_day"
                                placeholder="" value="" />
                        </div>
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Servings:</label>
                            <input type="number" class="form-control form-control-sm" name="servings" placeholder=""
                                value="" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Protein:</label>
                            <input type="number" class="form-control form-control-sm" name="protein" placeholder=""
                                value="" />
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Sides:</label>
                            <input type="number" class="form-control form-control-sm" name="sides" placeholder=""
                                value="" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <label class="required form-label fw-semibold">Status:</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">Select a Status...</option>
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>
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
    $('#addMealSizeForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.settings.meal.size.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            beforeSend: function() {
                showOverlay();
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert(response.message, 'success', 'btn btn-success');
                    $('#addMealSizeForm')[0].reset();
                    $('#addMealSizeForm')
                        .find('input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('')
                        .trigger('change');
                    $('#add_meal_size').modal('hide');
                    appendMealSizeRow(response.mealSize);
                } else {
                    swalAlert('Failed to add Meal Size. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                var errorMessage = xhr.responseJSON?.message ||
                    'Something went wrong. Please try again later.';
                swalAlert(errorMessage, 'error', 'btn btn-danger');
            },
        });
    });
    // Function to append a new row to the meal size table dynamically
    function appendMealSizeRow() {
        $.ajax({
            url: "{{ route('get.meal.size') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var mealSizes = response.data;
                    var $table = $('#meal_size_table tbody');
                    $table.empty();
                    $.each(mealSizes, function(index, mealSize) {
                        const newRow = `
                        <tr>
                            <td class="align-middle">
                                <label class="fw-semibold fs-6">${mealSize.title}</label>
                                <input type="hidden" value="${mealSize.uuid}" 
                                       name="meal[nutrition_facts_attributes][meal_size_id]" 
                                       id="meal_nutrition_facts_attributes_${mealSize.uuid}_meal_size_id">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][calories]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][fat]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][carb]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][fiber]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][protein]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                            <td>
                                <input type="text" 
                                       name="meal[nutrition_facts_attributes][sodium]" 
                                       class="form-control form-control-md" placeholder="">
                            </td>
                        </tr>
                    `;
                        $table.append(newRow);
                    });
                } else {
                    swalAlert('Failed to fetch meal sizes. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching meal sizes. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
