<div class="modal fade" id="add_vendor" tabindex="-1" style="display: none;" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header border-5 pb-0 mb-4 w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title text-start w-100" id="exampleModalLabel">Vendor</h5>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form id="addVendor">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label class="required form-label fw-semibold">Name:</label>
                            <input type="text" class="form-control form-control-sm" name="name" required/>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <label class="form-label fw-semibold">Description:</label>
                            <textarea type="text" class="form-control form-control-sm" name="description"></textarea>
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
    $('#addVendor').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('admin.settings.vendors.add') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                showOverlay(); // Show overlay before data fetch
            },
            success: function(response) {
                hideOverlay();
                if (response.success) {
                    swalAlert('Vendor added successfully.', 'success', 'btn btn-success');
                    $('#addVendor')[0].reset();
                    $('#addVendor').find(
                            'input:not([type="button"]):not([type="submit"]), textarea, select')
                        .val('').trigger('change');
                    $('#add_vendor').modal('hide');
                    updateVendorDropdown();
                } else {
                    swalAlert('Failed to add Vendor. Please try again.', 'error',
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

    // Update Vendors Dropdown
    function updateVendorDropdown() {
        $.ajax({
            url: "{{ route('get.vendors') }}",
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var vendors = response.data;
                    var $dropdown = $('#vendor_dropdown');
                    $dropdown.empty();
                    $dropdown.append('<option value="">Select a Vendor...</option>');
                    $.each(vendors, function(index, vendor) {
                        $dropdown.append('<option value="' + vendor.uuid + '">' + vendor.name +'</option>');
                    });
                    $dropdown.trigger('change');
                } else {
                    swalAlert('Failed to fetch vendors. Please try again.', 'error', 'btn btn-danger');
                }
            },
            error: function(xhr) {
                swalAlert('Error fetching vendors. Please try again later.', 'error', 'btn btn-danger');
            }
        });
    }
</script>
