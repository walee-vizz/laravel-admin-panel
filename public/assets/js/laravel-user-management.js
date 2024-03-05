(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === 'object' && typeof module === 'object')
    module.exports = factory();
  else if (typeof define === 'function' && define.amd)
    define([], factory);
  else {
    var a = factory();
    for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
  }
})(self, function () {
  return /******/ (function () { // webpackBootstrap
/******/ 	"use strict";
    var __webpack_exports__ = {};
    /*!*************************************************!*\
      !*** ./resources/js/laravel-user-management.js ***!
      \*************************************************/
    /**
     * Page User List
     */



    // Datatable (jquery)
    $(function () {
      // Variable declaration for table
      var dt_user_table = $('.datatables-users'),
        select2 = $('.select2'),
        userView = baseUrl + 'app/user/view/account',
        offCanvasForm = $('#offcanvasAddUser');
      if (select2.length) {
        select2.each(function () {
          $(this).wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select An Option',
            dropdownParent: $(this).parent()
          });
        });
      }

      // ajax setup
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Users datatable
      if (dt_user_table.length) {
        var dt_user = dt_user_table.DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: baseUrl + 'users'
          },
          columns: [
            // columns according to JSON
            {
              data: ''
            }, {
              data: 'id'
            }, {
              data: 'name'
            },
            {
              data: 'country'
            }, {
              data: 'role'
            }, {
              data: 'email'
            }, {
              data: 'email_verified_at'
            }, {
              data: 'action'
            }],
          columnDefs: [{
            // For Responsive
            className: 'control',
            searchable: false,
            orderable: false,
            responsivePriority: 2,
            targets: 0,
            render: function render(data, type, full, meta) {
              return '';
            }
          }, {
            searchable: false,
            orderable: false,
            targets: 1,
            render: function render(data, type, full, meta) {
              return "<span>".concat(full.fake_id, "</span>");
            }
          },
          {
            // User full name
            targets: 2,
            responsivePriority: 4,
            render: function render(data, type, full, meta) {
              var $name = full['name'];

              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6);
              var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
              var $state = states[stateNum],
                $name = full['name'],
                $initials = $name.match(/\b\w/g) || [],
                $output;
              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';

              // Creates full output for row
              var $row_output = '<div class="d-flex justify-content-start align-items-center user-name">' + '<div class="avatar-wrapper">' + '<div class="avatar avatar-sm me-3">' + $output + '</div>' + '</div>' + '<div class="d-flex flex-column">' + '<a href="' + userView + '" class="text-body text-truncate"><span class="fw-medium">' + $name + '</span></a>' + '</div>' + '</div>';
              return $row_output;
            }
          },
          {
            // Country name
            targets: 3,
            render: function render(data, type, row, meta) {
              if (row.country) {
                return row.country.name;
              }
              return '';
            }
          },
          {
            // User Role
            targets: 4,
            render: function render(data, type, full, meta) {
              var $roles = full['roles'];
              var roleBadgeObj = {
                user: '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="ti ti-user ti-sm"></i></span>',
                author: '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i class="ti ti-circle-check ti-sm"></i></span>',
                moderator: '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="ti ti-chart-pie-2 ti-sm"></i></span>',
                editor: '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30 me-2"><i class="ti ti-edit ti-sm"></i></span>',
                superadmin: '<span class="badge badge-center rounded-pill bg-label-secondary w-px-30 h-px-30 me-2"><i class="ti ti-device-laptop ti-sm"></i></span>'
              };
              let output = '';
              $roles.forEach(function (r, index) {
                console.log(r);
                output += "<span class='text-truncate d-flex align-items-center'>" + (roleBadgeObj[r.replace(' ', '')] + r);

                // Check if the current role is not the last one
                if (index < $roles.length - 1) {
                  output += ',';
                }
              });
              return output;
            }
          }, {
            // User email
            targets: 5,
            render: function render(data, type, full, meta) {
              var $email = full['email'];
              return '<span class="user-email">' + $email + '</span>';
            }
          }, {
            // email verify
            targets: 6,
            className: 'text-center',
            render: function render(data, type, full, meta) {
              var $verified = full['email_verified_at'];
              return "".concat($verified ? '<i class="ti fs-4 ti-shield-check text-success"></i>' : '<i class="ti fs-4 ti-shield-x text-danger" ></i>');
            }
          }, {
            // Actions
            targets: -1,
            title: 'Actions',
            searchable: false,
            orderable: false,
            render: function render(data, type, full, meta) {
              return '<div class="d-inline-block text-nowrap">' + "<button class=\"btn btn-sm btn-icon edit-record\" data-id=\"".concat(full['id'], "\" data-bs-toggle=\"offcanvas\" data-bs-target=\"#offcanvasAddUser\"><i class=\"ti ti-edit\"></i></button>") + "<button class=\"btn btn-sm btn-icon delete-record\" data-id=\"".concat(full['id'], "\"><i class=\"ti ti-trash\"></i></button>") + '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' + '<div class="dropdown-menu dropdown-menu-end m-0">' + '<a href="' + userView + '" class="dropdown-item">View</a>' + '<a href="javascript:;" class="dropdown-item">Suspend</a>' + '</div>' + '</div>';
            }
          }],
          order: [[2, 'desc']],
          dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
          language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Search..'
          },
          // Buttons with Dropdown
          buttons: [{
            extend: 'collection',
            className: 'btn btn-label-primary dropdown-toggle mx-3 waves-effect waves-light',
            text: '<i class="ti ti-logout rotate-n90 me-2"></i>Export',
            buttons: [{
              extend: 'print',
              title: 'Users',
              text: '<i class="ti ti-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function body(inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item instanceof Element && item.classList.contains('user-name')) {
                        result += item.lastChild.textContent;
                      } else {
                        result += item.innerText || item.textContent || '';
                      }
                    });
                    return result;
                  }
                }
              },
              customize: function customize(win) {
                //customize print view for dark
                $(win.document.body).css('color', config.colors.headingColor).css('border-color', config.colors.borderColor).css('background-color', config.colors.body);
                $(win.document.body).find('table').addClass('compact').css('color', 'inherit').css('border-color', 'inherit').css('background-color', 'inherit');
              }
            }, {
              extend: 'csv',
              title: 'Users',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function body(inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item instanceof Element && item.classList.contains('user-name')) {
                        result += item.lastChild.textContent;
                      } else {
                        result += item.innerText || item.textContent || '';
                      }
                    });
                    return result;
                  }
                }
              }
            }, {
              extend: 'excel',
              title: 'Users',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function body(inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item instanceof Element && item.classList.contains('user-name')) {
                        result += item.lastChild.textContent;
                      } else {
                        result += item.innerText || item.textContent || '';
                      }
                    });
                    return result;
                  }
                }
              }
            }, {
              extend: 'pdf',
              title: 'Users',
              text: '<i class="ti ti-file-text me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function body(inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item instanceof Element && item.classList.contains('user-name')) {
                        result += item.lastChild.textContent;
                      } else {
                        result += item.innerText || item.textContent || '';
                      }
                    });
                    return result;
                  }
                }
              }
            }, {
              extend: 'copy',
              title: 'Users',
              text: '<i class="ti ti-copy me-1" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be copy
                format: {
                  body: function body(inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item instanceof Element && item.classList.contains('user-name')) {
                        result += item.lastChild.textContent;
                      } else {
                        result += item.innerText || item.textContent || '';
                      }
                    });
                    return result;
                  }
                }
              }
            }]
          }, {
            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New User</span>',
            className: 'add-new btn btn-primary waves-effect waves-light',
            attr: {
              'data-bs-toggle': 'offcanvas',
              'data-bs-target': '#offcanvasAddUser'
            }
          }],
          // For responsive popup
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal({
                header: function header(row) {
                  var data = row.data();
                  return 'Details of ' + data['name'];
                }
              }),
              type: 'column',
              renderer: function renderer(api, rowIdx, columns) {
                var data = $.map(columns, function (col, i) {
                  return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                    ? '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' + '<td>' + col.title + ':' + '</td> ' + '<td>' + col.data + '</td>' + '</tr>' : '';
                }).join('');
                return data ? $('<table class="table"/><tbody />').append(data) : false;
              }
            }
          },
          initComplete: function initComplete() {
            // Adding role filter once table initialized
            this.api().columns(3).every(function () {
              var column = this;
              var select = $('<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Role </option></select>').appendTo('.user_role').on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });
              column.data().unique().sort().each(function (d, j) {
                if (!d) {
                  return;
                }
                select.append('<option value="' + d + '">' + d + '</option>');
              });
            });

            // Adding status filter once table initialized
            // this.api()
            //   .columns(5)
            //   .every(function () {
            //     var column = this;
            //     var select = $(
            //       '<select id="FilterTransaction" class="form-select text-capitalize"><option value=""> Select Status </option></select>'
            //     )
            //       .appendTo('.user_status')
            //       .on('change', function () {
            //         var val = $.fn.dataTable.util.escapeRegex($(this).val());
            //         column.search(val ? '^' + val + '$' : '', true, false).draw();
            //       });

            //     column
            //       .data()
            //       .unique()
            //       .sort()
            //       .each(function (d, j) {
            //         select.append(
            //           '<option value="' +
            //           statusObj[d].title +
            //           '" class="text-capitalize">' +
            //           statusObj[d].title +
            //           '</option>'
            //         );
            //       });
            //   });
          }
        });
      }

      // Delete Record
      $(document).on('click', '.delete-record', function () {
        var user_id = $(this).data('id'),
          dtrModal = $('.dtr-bs-modal.show');

        // hide responsive modal in small screen
        if (dtrModal.length) {
          dtrModal.modal('hide');
        }

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
            // delete the data
            $.ajax({
              type: 'DELETE',
              url: "".concat(baseUrl, "users/").concat(user_id),
              success: function success() {
                dt_user.draw();
              },
              error: function error(_error) {
                console.log(_error);
              }
            });

            // success sweetalert
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'The user has been deleted!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'The User is not deleted!',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      });

      // edit record
      $(document).on('click', '.edit-record', function () {
        var user_id = $(this).data('id'),
          dtrModal = $('.dtr-bs-modal.show');

        // hide responsive modal in small screen
        if (dtrModal.length) {
          dtrModal.modal('hide');
        }

        // changing the title of offcanvas
        $('#offcanvasAddUserLabel').html('Edit User');

        // get data
        $.get("".concat(baseUrl, "users/").concat(user_id, "/edit"), function (data) {
          $('#user_id').val(data.id);
          // $('#addNewUserForm')[0].reset();
          $('#add-user-fullname').val(data.name);
          $('#add-user-email').val(data.email);
          $('#add-user-country').val(data.country_id).trigger('change');
          $('#add-user-role').val(data.role_ids).trigger('change');
        });
      });

      // changing the title
      $('.add-new').on('click', function () {
        $('#user_id').val(''); //reseting input field
        $('#offcanvasAddUserLabel').html('Add User');
      });

      // Filter form control to default size
      // ? setTimeout used for multilingual table initialization
      setTimeout(function () {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
      }, 300);

      // validating form and updating user's data
      var addNewUserForm = document.getElementById('addNewUserForm');

      // user form validation
      var fv = FormValidation.formValidation(addNewUserForm, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Please enter fullname'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Please enter your email'
              },
              emailAddress: {
                message: 'The value is not a valid email address'
              }
            }
          },
          userContact: {
            validators: {
              notEmpty: {
                message: 'Please enter your contact'
              }
            }
          },
          company: {
            validators: {
              notEmpty: {
                message: 'Please enter your company'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            // Use this for enabling/changing valid/invalid class
            eleValidClass: '',
            rowSelector: function rowSelector(field, ele) {
              // field is the field name & ele is the field element
              return '.mb-3';
            }
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        }
      }).on('core.form.valid', function () {
        // adding or updating user when form successfully validate
        $.ajax({
          data: $('#addNewUserForm').serialize(),
          url: "".concat(baseUrl, "users"),
          type: 'POST',
          success: function success(status) {
            dt_user.draw();
            offCanvasForm.offcanvas('hide');

            // sweetalert
            Swal.fire({
              icon: 'success',
              title: "Successfully ".concat(status, "!"),
              text: "User ".concat(status, " Successfully."),
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function error(err) {
            offCanvasForm.offcanvas('hide');
            Swal.fire({
              title: 'Duplicate Entry!',
              text: 'Your email should be unique.',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      });

      // clearing form data when offcanvas hidden
      offCanvasForm.on('hidden.bs.offcanvas', function () {
        $('#addNewUserForm')[0].reset();
        $('#add-user-country').val('').trigger('change');
        $('#add-user-role').val('').trigger('change');

      });
      var phoneMaskList = document.querySelectorAll('.phone-mask');

      // Phone Number
      if (phoneMaskList) {
        phoneMaskList.forEach(function (phoneMask) {
          new Cleave(phoneMask, {
            phone: true,
            phoneRegionCode: 'US'
          });
        });
      }
    });
/******/ 	return __webpack_exports__;
    /******/
  })()
    ;
});
