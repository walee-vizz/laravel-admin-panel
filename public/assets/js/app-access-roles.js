/**
 * App user list
 */

'use strict';

(function () {
  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('.role-delete-btn').on('click', function (e) {
    let clickedBtn = $(this);
    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        var role = clickedBtn.data('role');
        // console.log(role);
        // return;
        $.ajax({
          url: baseUrl + "role/delete/" + role.id,
          type: 'DELETE',
          success: function success(response) {
            // sweetalert
            Swal.fire({
              icon: 'success',
              title: "Successfully ".concat(response.status, "!"),
              text: "Role ".concat(response.status, " Successfully."),
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then((result) => {
              // Reload the page after the SweetAlert is closed
              location.reload();
            });

          },
          error: function error(err) {
            // sweetalert
            Swal.fire({
              icon: 'error',
              title: "Something went wrong!",
              text: "An error occured while deleting the role please try again later!",
              customClass: {
                confirmButton: 'btn btn-success'
              }
            })

          }
        });

      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The Role is not deleted!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }

    });

  });

})();
