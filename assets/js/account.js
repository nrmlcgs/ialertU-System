$('.toggle-password').click(function () {
    var passwordField = $(this).closest('.input-group').find('input');
    var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $('#passeye').toggleClass('fa-eye fa-eye-slash');
});

$('form').submit(function (event) {
    event.preventDefault();

    var username = $('#lgnuname');
    var password = $('#lgnpass');

    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Account.php?f=lgn`,
        data: { user: username.val(), pass: password.val() },
        dataType: 'JSON',
        success: function (data) {
            switch (data.stat) {
                case 'accfound':
                    username.val('');
                    password.val('');
                    Swal.fire(
                        'Account Logined!',
                        'click ok to proceed!',
                        'success'
                    ).then((result) => {
                        localStorage.setItem("o", data.off)
                        window.location.href = data.u;
                    })

                    break;
                case 'accnotfound':
                    username.val('');
                    password.val('');
                    Swal.fire(
                        'Invalid Account!',
                        'click ok and try again!',
                        'error'
                    )
                    break;
            }

        }
    })
});
$('#lgo').click(function () {
    Swal.fire({
        title: "Are you sure to logout?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, logout!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: `/ialertu/Controllers/Account.php?f=lgo`,
                success: function (data) {
                    if (data == "logoutuser") {
                        window.location.href = /ialertu/;
                    } else {
                        Swal.fire({
                            title: "Unknown Error",
                            text: "Please try again!",
                            icon: "error"
                        });
                    }

                }
            })
        }
    });

});