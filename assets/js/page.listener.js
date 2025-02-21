let menus = document.querySelectorAll('.menuitem'),
    dashboard = $("#lidash"),
    records = $("#lirecords"),
    reports = $("#lireports"),
    review = $("#lireview"),
    settings = $("#lisettings")
// emergency = $("#liemergency");


function addActiveMenu(parent) {
    for (let i = 0; i < menus.length; i++) {
        let child = menus[i].querySelector('.text-db');
        if (child) {
            child.classList.remove('text-db');
        }
    }
    parent.find("span").addClass('text-db');
}

function loadPage(page) {
    var pp = page.replace("#", "");
    document.getElementById('emerID').style.display = 'none';
    if (pp !== 'dashboard') {

        clearInterval(intervalId)
        isMapLoaded = false
    }
    $.ajax({
        url: "/ialertu/view/pages/" + pp + ".php",
        success: function (response) {
            $("#allcontent").html(response);
            switch (pp) {
                case 'dashboard':
                    var promises = [];
                    $.ajax({
                        url: `/ialertu/Controllers/Accident.php?f=ger`,
                        dataType: 'JSON',
                        success: function (response) {
                            locationsArray = [];
                            complete_location = [];
                            for (let i = 0; i < response.length; i++) {
                                var myObject = {
                                    id: response[i]['id'],
                                    lat: response[i]['lat'],
                                    lng: response[i]['lon'],
                                    vnum: response[i]['num'],
                                    pic: response[i]['picture'],
                                    type: response[i]['type'],
                                    uID: response[i]['uID'],
                                    o: response[i]['o'],
                                    col: response[i]['col'],
                                    est: response[i]['est'],
                                };
                                locationsArray.push(myObject);
                            }
                            for (let i = 0; i < locationsArray.length; i++) {
                                var promise = $.ajax({
                                    url: `https://nominatim.openstreetmap.org/reverse?lat=${locationsArray[i].lat}&lon=${locationsArray[i].lng}&format=json`,
                                    success: function (response) {
                                        let faddress = response.address;
                                        complete_location.push({
                                            lat: locationsArray[i].lat,
                                            lng: locationsArray[i].lng,
                                            title: faddress.road == undefined ? 'unknown' : faddress.road,
                                            area: faddress.neighbourhood,
                                            brgy: faddress.quarter,
                                            id: locationsArray[i].id,
                                            vnum: locationsArray[i].vnum,
                                            pic: locationsArray[i].pic,
                                            type: locationsArray[i].type,
                                            uID: locationsArray[i].uID,
                                            o: locationsArray[i]['o'],
                                            col: locationsArray[i]['col'],
                                            est: locationsArray[i]['est'],
                                        });
                                    },
                                    error: function (xhr, status, error) {
                                    }
                                });
                                promises.push(promise);
                            }
                            $.when.apply($, promises).then(function () {
                                console.log(complete_location)
                                mapconfig(complete_location);
                            });
                        },
                        error: function (xhr, status, error) { }
                    });
                    // let sound = $("#btnplaysound");

                    // sound.on("click", function () {
                    //     playRippleSound();
                    // });
                    // sound.click();
                    break;
                case 'records':
                    loadtabledata();
                    break;
                case 'reports':
                    const currentDate = new Date();
                    const currentYear = currentDate.getFullYear();
                    const currentMonth = currentDate.getUTCMonth() + 1;
                    const currentMonthinput = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Add +1 to get the correct month and pad with '0'
                    const defaultMonthYear = `${currentYear}-${currentMonthinput}`;
                    document.getElementById('mpicker').value = defaultMonthYear;
                    getchartdata(currentYear, currentMonth, 'all')
                    $(".yearpicker").yearpicker({
                        year: currentYear,
                        onChange: function (value) {
                            getchartdata(value, currentMonth, 'first')
                        }
                    });

                    $("#mpicker").on("change", function () {
                        var selectedDate = $(this).val();

                        // Split the date into an array [year, month]
                        var dateArray = selectedDate.split("-");

                        // Extract year and month
                        var selectedYear = dateArray[0];
                        var selectedMonth = dateArray[1];
                        getchartdata(selectedYear, selectedMonth, 'second')
                    });
                    break;
                case 'review':
                    loadtabledatareview()
                    break;
                case 'settings':
                    loadtabledataacc();
                    $('.toggle-password').click(function () {
                        var passwordField = $(this).closest('.input-group').find('input');
                        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                        passwordField.attr('type', type);
                        // $('#passeye').toggleClass('fa-eye fa-eye-slash');
                        $(this).find('.eye-icon').toggleClass('fa-eye fa-eye-slash');
                    });
                    $('#frmacc').submit(function (event) {
                        // Prevent the default form submission
                        event.preventDefault();
                        var formData = new FormData(this);
                        formData.append('s', 0);
                        $.ajax({
                            type: "POST",
                            url: `/ialertu/Controllers/Settings.php?f=ma`,
                            data: formData,
                            processData: false,  // important to prevent jQuery from processing the data
                            contentType: false,
                            success: function (data) {
                                let newData = JSON.parse(data)
                                switch (newData.stat) {
                                    case 'detupdated':
                                        if ($.fn.DataTable.isDataTable('#tblaccount')) {
                                            $('#tblaccount').DataTable().clear().destroy();
                                        }
                                        $('#tbladcontent').html(newData.data)
                                        $('#tblaccount').DataTable({
                                        });
                                        window.common.hideModal('accview')
                                        Swal.fire({
                                            title: "Details has been Updated",
                                            text: "click ok to proceed",
                                            icon: "success"
                                        });
                                        break;
                                }
                            }
                        });
                    });
                    $('#frmaccpass').submit(function (event) {
                        // Prevent the default form submission
                        event.preventDefault();
                        var formData = new FormData(this);
                        formData.append('s', 1);
                        $.ajax({
                            type: "POST",
                            url: `/ialertu/Controllers/Settings.php?f=ma`,
                            data: formData,
                            processData: false,  // important to prevent jQuery from processing the data
                            contentType: false,
                            success: function (data) {
                                let newData = JSON.parse(data)
                                switch (newData.stat) {
                                    case 'passupdated':
                                        clearpass();

                                        Swal.fire({
                                            title: "Password has been Updated",
                                            text: "click ok to proceed",
                                            icon: "success"
                                        });
                                        break;
                                    case 'passnotupdated':
                                        Swal.fire({
                                            title: "Password has been Updated",
                                            text: "click ok to proceed",
                                            icon: "error"
                                        });
                                        break;
                                }
                            }
                        });
                    });
                    $('#conpass').keyup(function () {
                        var newPassword = $('#newpass').val();
                        var confirmPassword = $(this).val();
                        if (newPassword !== confirmPassword) {
                            $('#btnpass').prop('disabled', true);
                            $('.wrongpass').show();
                        } else {
                            $('#btnpass').prop('disabled', false);
                            $('.wrongpass').hide();
                        }
                    });
                    break;
            }
        },
        error: function (xhr, status, error) {
            dashboard.click();
            window.location.hash = '#dashboard';
        }
    });
}

dashboard.on("click", function () {
    addActiveMenu(dashboard);
    var pageToLoad = $(this).find("a").attr("href");
    loadPage(pageToLoad);
});
// emergency.on("click", function () {
//     addActiveMenu(emergency);
//     var pageToLoad = $(this).find("a").attr("href");
//     loadPage(pageToLoad);
// });
records.on("click", function () {
    addActiveMenu(records);
    var pageToLoad = $(this).find("a").attr("href");
    loadPage(pageToLoad);
});
reports.on("click", function () {
    addActiveMenu(reports);
    var pageToLoad = $(this).find("a").attr("href");
    loadPage(pageToLoad);
});
review.on("click", function () {
    addActiveMenu(review);
    var pageToLoad = $(this).find("a").attr("href");
    loadPage(pageToLoad);
});
settings.on("click", function () {
    addActiveMenu(settings);
    var pageToLoad = $(this).find("a").attr("href");
    loadPage(pageToLoad);
});

try {
    function hashchecker() {
        if ((window.location.hash == "#dashboard") || (window.location.hash == "")) {
            dashboard.click();
        } else if (window.location.hash == "#emergency") {
            emergency.click();
        } else if (window.location.hash == "#records") {
            records.click()
        } else if (window.location.hash == "#reports") {
            reports.click()
        } else if (window.location.hash == "#review") {
            review.click()
        } else if (window.location.hash == "#settings") {
            settings.click()
        }
    }
    hashchecker();
} catch (error) {

}
