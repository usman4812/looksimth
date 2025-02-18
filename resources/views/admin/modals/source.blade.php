  <!-- Add Source Model-->
  <div class="modal fade" id="add_source_modal" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-md">
          <div class="modal-content rounded">
              <div class="modal-header border-5 pb-0 mb-4">
                  <h5 class="modal-title" id="exampleModalLabel">Source</h5>
                  <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                      <i class="ki-outline ki-cross fs-1"></i>
                  </div>
              </div>
              <div class="modal-body pt-0">
                  <form id="addSourceModal">
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
      $('#addSourceModal').submit(function(e) {
          e.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
              url: "{{ route('admin.settings.source.add') }}",
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
                      swalAlert('Source added successfully.', 'success', 'btn btn-success');
                      $('#addSourceModal')[0].reset();
                      $('#addSourceModal').find(
                              'input:not([type="button"]):not([type="submit"]), textarea, select')
                          .val('').trigger('change');
                      $('#add_source_modal').modal('hide');
                      updateSourceDropdown();
                  } else {
                      swalAlert('Failed to add Source. Please try again.', 'error',
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

      // Update Source Dropdown
      function updateSourceDropdown() {
          $.ajax({
              url: "{{ route('get.source') }}",
              type: 'GET',
              success: function(response) {
                  if (response.success) {
                      var sources = response.data;
                      var $dropdown = $('#source_dropdwon');
                      $dropdown.empty();
                      $dropdown.append('<option value="">Select a Source...</option>');
                      $.each(sources, function(index, source) {
                          $dropdown.append('<option value="' + source.uuid + '">' +
                              source.name + '</option>');
                      });
                      $dropdown.trigger('change');
                  } else {
                      swalAlert('Failed to fetch Source. Please try again.', 'error',
                          'btn btn-danger');
                  }
              },
              error: function(xhr) {
                  swalAlert('Error fetching vendors. Please try again later.', 'error', 'btn btn-danger');
              }
          });
      }
  </script>
