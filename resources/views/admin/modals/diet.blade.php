<div class="modal fade" id="add_diet" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Diet</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addDietForm">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required/>
                        </div>

                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Abbr:</label>
                            <input type="text" class="form-control form-control-sm" name="abbr" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Sort Order:</label>
                            <input type="number" class="form-control form-control-sm" name="sort_order" required/>
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
                            <label class="form-label fw-semibold">Description:</label>
                            <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
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
    $(document).on('submit', '#addDietForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('admin.settings.diets.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay(); // Show loader
            },
            success: function(response) {
                hideOverlay(); // Hide loader
                if (response.success) {
                    swalAlert('Meal type added successfully.', 'success', 'btn btn-success');
                    $('#addDietForm')[0].reset();
                    $('#addDietForm').find('input, select').val('').trigger('change');
                    $('#add_diet').modal('hide');
                    updateDietsData();
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

    // Update Diet Data
    function updateDietsData() {
        $.ajax({
            url: "{{ route('get.diets') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var diets = response.data;
                    var $dietsContainer = $('.diets-container');
                    $dietsContainer.empty();
                    $.each(diets, function(index, diet) {
                        var checkboxHtml = `
                        <div class="col-lg-2 fv-row fv-plugins-icon-container mt-2">
                            <div class="d-flex align-items-center">
                                <label class="form-check form-check-custom form-check-inline me-2">
                                    <input class="form-check-input" name="diets[]" type="checkbox"
                                           value="${diet.uuid}">
                                    <span class="fw-semibold ps-2 fs-6">${diet.name}</span>
                                </label>
                            </div>
                        </div>
                    `;
                        $dietsContainer.append(checkboxHtml);
                    });
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
