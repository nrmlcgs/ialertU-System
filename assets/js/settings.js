function loadtabledataacc(mn) {
    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Settings.php?f=gaa`,
        data: { s: mn },
        success: function (data) {
            $('#tbladcontent').html(data)
            $('#tblaccount').DataTable({
            });
        }
    });
}
function editacc(data) {
    let jsondata = JSON.parse(data);
    $('#idno').val(jsondata.id)
    $('#uname').val(jsondata.username)
    $('#fname').val(jsondata.fname)
    $('#mname').val(jsondata.mname)
    $('#lname').val(jsondata.lname)
    window.common.showModal('accview')


}
function updatepass(id) {
    $('#idnopass').val(id)
    window.common.showModal('accviewpass')
    // $.ajax({
    //     type: "POST",
    //     url: `/ialertu/Controllers/Settings.php?f=gaa`,
    //     data: { s: mn },
    //     success: function (data) {
    //         $('#uname').val(data)
    //         $('#fname').val(data)
    //         $('#mname').val(data)
    //         $('#lname').val(data)
    //         window.common.showModal('accview')
    //     }
    // });
}
function clearpass() {
    window.common.hideModal('accviewpass');
    $('#idnopass').val('');
    $('#newpass').val('');
    $('#conpass').val('');
    $('#oldpass').val('');
    var togglePasswordElements = document.getElementsByClassName('wrongpass');
    for (var i = 0; i < togglePasswordElements.length; i++) {
        togglePasswordElements[i].style.display = "none";
    }
}