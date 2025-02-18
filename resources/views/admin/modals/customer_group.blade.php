 <!-- Add Customer Group Model-->
 <div class="modal fade" id="add_customer_group" tabindex="-1" style="display: none;" aria-hidden="true">
     <div class="modal-dialog modal-md">
         <div class="modal-content rounded">
             <div class="modal-header border-5 pb-0 mb-4">
                 <h5 class="modal-title" id="exampleModalLabel">Customer Group</h5>
                 <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                     <i class="ki-outline ki-cross fs-1"></i>
                 </div>
             </div>
             <div class="modal-body pt-0">
                 <form id="addCustomerGroup">
                     <div class="row">
                         <div class="col-lg-12 mb-4">
                             <label class="required form-label fw-semibold">Name:</label>
                             <input type="text" class="form-control form-control-sm" name="name" required />
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
     $('#addCustomerGroup').submit(function(e) {
         e.preventDefault();
         var formData = $(this).serialize();
         $.ajax({
             url: "{{ route('admin.settings.customer.group.add') }}",
             type: 'POST',
             data: formData,
             headers: {
                 'X-CSRF-TOKEN': "{{ csrf_token() }}"
             },
             beforeSend: function() {
                 showOverlay();
             },
             success: function(response) {
                 hideOverlay();
                 if (response.success) {
                     swalAlert('Customer Group added successfully.', 'success', 'btn btn-success');
                     $('#addCustomerGroup')[0].reset();
                     $('#addCustomerGroup').find(
                             'input:not([type="button"]):not([type="submit"]), textarea, select')
                         .val('').trigger('change');
                     $('#add_customer_group').modal('hide');
                     updateCustomerGroupDropdown();
                 } else {
                     swalAlert('Failed to add Customer Group. Please try again.', 'error',
                         'btn btn-danger');
                 }
             },
             error: function(xhr) {
                 hideOverlay();
                 var errorMessage = xhr.responseJSON?.message ||
                     'Something went wrong. Please try again later.';
                 swalAlert(errorMessage, 'error', 'btn btn-danger');
             }
         });
     });

     // Update Customer Group Dropdown
     function updateCustomerGroupDropdown() {
         $.ajax({
             url: "{{ route('get.customer.group') }}",
             type: 'GET',
             success: function(response) {
                 if (response.success) {
                     var customerGroups = response.data;
                     var $dropdown = $('#customer_group_dropdown');
                     $dropdown.empty();
                     $dropdown.append('<option value="">Select a Customer Group...</option>');
                     $.each(customerGroups, function(index, customerGroup) {
                         $dropdown.append('<option value="' + customerGroup.uuid + '">' +
                             customerGroup.name + '</option>');
                     });
                     $dropdown.trigger('change');
                 } else {
                     swalAlert('Failed to fetch Customer Group. Please try again.', 'error',
                         'btn btn-danger');
                 }
             },
             error: function(xhr) {
                 swalAlert('Error fetching vendors. Please try again later.', 'error', 'btn btn-danger');
             }
         });
     }
 </script>
