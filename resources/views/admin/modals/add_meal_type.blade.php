
<div class="modal fade" id="add_meal_type" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Meal Types</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addMealTypeForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Title:</label>
                            <input type="text" class="form-control form-control-sm" name="title"  required/>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required />
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Status:</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">Select a Status...</option>
                                <option value="1" selected>Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="form-label fw-semibold">Image</label>
                            <input type="file" class="form-control form-control-sm" name="image" />
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
    $(document).on('submit', '#addMealTypeForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.settings.meal.types.add') }}",
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
                    swalAlert('Meal type added successfully.', 'success', 'btn btn-success');
                    $('#addMealTypeForm')[0].reset();
                    $('#addMealTypeForm').find('input, select').val('').trigger('change');
                    $('#add_meal_type').modal('hide');
                    updateMealTypeDropdown();
                } else {
                    swalAlert('Failed to add meal type. Please try again.', 'error',
                        'btn btn-danger');
                }
            },
            error: function(xhr) {
                hideOverlay();
                swalAlert('An error occurred. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    });
    // Update Meal Type Dropdown
    function updateMealTypeDropdown() {
        $.ajax({
            url: "{{ route('admin.settings.get.meal.types') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var mealTypes = response.data;
                    var $dropdown = $('#meal_type_dropdown');
                    $dropdown.empty();
                    $dropdown.append('<option value="">Select a Meal Type...</option>');
                    $.each(mealTypes, function(index, mealType) {
                        $dropdown.append('<option value="' + mealType.uuid + '">' + mealType.title +
                            '</option>');
                    });
                    $dropdown.trigger('change');
                } else {
                    swalAlert('Failed to fetch meal types. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching meal types. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
