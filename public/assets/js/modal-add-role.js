/**
 * Add new role Modal JS
 */

'use strict';



document.addEventListener('DOMContentLoaded', function (e) {


  (function () {

    $('.role-edit-btn').on('click', function (e) {
      e.preventDefault();
      $('#addRoleModal').find('.role-title').text('Edit Role');
      let role = JSON.parse($(this).attr('data-role'));
      let roleForm = $('#addRoleForm');
      roleForm.find('#name').val(role.name);
      let roleIdField = roleForm.find('#roleId');
      if (roleIdField.length > 0) {
        roleIdField.val(role.id);
      } else {

        roleForm.append(`<input type="hidden" value="${role.id}" id="roleId" name="id"/>`)
      }

      if (role.permissions.length > 0) {
        // Get all checkboxes
        var checkboxes = roleForm.find('.form-check-input');
        let exists = false;
        let boxesChecked = 0;
        // Iterate through each checked checkbox
        checkboxes.each(function () {
          var permissionId = $(this).attr('id');
          // Check if any permission's ID matches the current checkbox's ID
          exists = role.permissions.some(permission => permission.id == permissionId);
          // If the permission exists, check the checkbox; otherwise, uncheck it
          $(this).prop("checked", exists);
          if (exists) boxesChecked++
        });
        if (boxesChecked == checkboxes.length - 1) {
          exists = true;
        } else {
          exists = false;
        }
        $('#selectAll').prop('checked', exists);
      }

    });

    $('#add-new-role-btn').on('click', function (e) {
      $('#addRoleModal').find('.role-title').text('Add New Role');
      $('#addRoleForm')[0].reset();

    });
    // ajax setup
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // add role form validation
    FormValidation.formValidation(document.getElementById('addRoleForm'), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: 'Please enter role name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      console.log($('#addRoleForm').serialize());
      let reqUrl = baseUrl + "role/create";
      let reqMethod = 'POST';
      let roleForm = $('#addRoleForm');
      let roleIdField = roleForm.find('#roleId');
      if (roleIdField.length > 0) {
        reqUrl = baseUrl + "role/update/" + roleIdField.val();
        reqMethod = 'PUT';
      }
      $.ajax({
        data: $('#addRoleForm').serialize(),
        url: reqUrl,
        type: reqMethod,
        success: function success(response) {
          // dt_user.draw();
          $('#addRoleModal').modal('hide');

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
          let errorTitle = 'Something went wrong!';
          let errorMessage = 'An error came when creating the role. Contact admin support if persists.';
          // Hide the modal on error
          $('#addRoleModal').modal('hide');
          // Check the HTTP status code
          if (err.status === 401) {
            // Unauthorized error (status code 401)
            // Handle unauthorized access
            errorTitle = 'Unauthorized access';
            errorMessage = 'You are not authorized to create roles in this system. Please contact your administrator for more information.';
            console.log('Unauthorized access');
          } else if (err.status === 500) {
            // Internal server error (status code 500)
            // Handle internal server error
            console.log('Internal server error');
          } else if (err.status === 422) {

            console.log(err);
            if (err.responseJSON.message) {
              errorMessage = err.responseJSON.message;
            }
            errorTitle = err.statusText;

            console.log(err.statusText);
          } else {
            // Other error cases
            // Handle other status codes
            console.log('Error: ' + err.status);
          }

          Swal.fire({
            title: errorTitle,
            text: errorMessage,
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    });

    // Select All checkbox click
    const selectAll = document.querySelector('#selectAll'),
      checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener('change', t => {
      checkboxList.forEach(e => {
        e.checked = t.target.checked;
      });
    });
  })();
});
