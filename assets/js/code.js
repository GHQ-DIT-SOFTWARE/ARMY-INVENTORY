$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted!',
                        'Your data has been deleted.',
                        'success'
                      )
                    }
                  })
    });

  });



$(function(){
    $(document).on('click','#ApproveBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Change This To Unserviceable?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Change To Unserviceable!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Approved!',
                        ' Unserviceable  Approved!!',
                        'success'
                      )
                    }
                  })
    });

  });

  $(function(){
    $(document).on('click','#UnserBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Change This To Serviceability?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Change To Serviceability!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Change!',
                        'Serviceability approved!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#serBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Change This To Unserviceability?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Change To Unserviceability!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Change!',
                        ' Unserviceability  approved!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#RescheduleBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Change This To Serviceable?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change To Serviceable !'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Changed!',
                        'Serviceable  Change!',
                        'success'
                      )
                    }
                  })
    });

  });

  $(function(){
    $(document).on('click','#AvailableEletronicBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Unavailable?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Availablity!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Available!',
                        'Avaialability Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#UnAvailableEletronicBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Available?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Availablity!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'available!',
                        'Unavailability Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#AvailableGeneralBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Unavailable?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Availablity!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Unavailable!',
                        'Avaialability Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#UnAvailableGeneralBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Available?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Availablity!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Available!',
                        'Unavailability Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#ElecLoanBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Approve This Status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve Status!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Approved!',
                        ' Status  Approved!!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#ElecreturnBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Approve This Status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve Status!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Approved!',
                        ' Status  Approved!!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#GeneraloanBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Approve This Status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve Status!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Approved!',
                        ' Status  Approved!!',
                        'success'
                      )
                    }
                  })
    });

  });

  $(function(){
    $(document).on('click','#GeneralreturnBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You Want To Approve This Status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Approve Status!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Approved!',
                        ' Status  Approved!!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#ActiveBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Inactive?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Activation!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Active!',
                        'Active Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
  $(function(){
    $(document).on('click','#InactiveBtn',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Active?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes,Change Activation!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Active!',
                        'Unactive Changed!',
                        'success'
                      )
                    }
                  })
    });

  });
