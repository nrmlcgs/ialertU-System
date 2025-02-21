function loadtabledatareview() {
    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Account.php?f=ur`,
        success: function (data) {
            $('#tblreviewcontent').html(data)
            $('#tblreview').DataTable({
                // "autoWidth": true
                // "scrollY": "65vh"
            });
        }
    });
}
function reviewUpdate(id, s) {
    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Account.php?f=rus`,
        data: { id: id, s: s },
        dataType: 'JSON',
        success: function (data) {
            switch (data.stat) {
                case 'rejected':
                    $('#tblreviewcontent').html(data.html)
                    window.common.hideModal('reviewview')
                    Swal.fire({
                        title: "Rejected",
                        text: `${data.data} account is rejected`,
                        icon: "info"
                    });
                    break;
                case 'approved':
                    $('#tblreviewcontent').html(data.html)
                    window.common.hideModal('reviewview')
                    Swal.fire({
                        title: "Approved",
                        text: `${data.data} account is approved`,
                        icon: "success"
                    });
                    break;
                case 'error':
                    Swal.fire({
                        title: "Unknown Error",
                        text: `please reload the page!`,
                        icon: "error"
                    });
                    break;
            }

        }
    });
}
function acctoreview(data) {
    let stat;
    let suff = "";
    var jdata = JSON.parse(data);
    if (jdata['status'] == 1) {
        stat = ' <p class="text-success" style="text-indent: 20px;">Responded</p>';
    } else {
        stat = '<p class="text-danger" style="text-indent: 20px;">Not Responded</p>';
    }
    if (jdata['suffix'] !== 'none'){
        suff = jdata['suffix'];
    }
    console.log(jdata)
    var con = `
    <div class="row">
    <div class="col">
                <p class="m-0"><span class="fw-semibold">Identification number:</span> <br>
                <p style="text-indent: 20px;">${jdata['id']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Fullname:</span> <br>
                <p style="text-indent: 20px;">${jdata['fname']} ${jdata['mname']} ${jdata['lname']} ${suff}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Gender</span> <br>
                <p style="text-indent: 20px;">${jdata['sex']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Birth date:</span> <br>
                <p style="text-indent: 20px;">${jdata['birthday']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Full address:</span> <br>
                <p style="text-indent: 20px;">${jdata['Barangay']} ${jdata['City']} ${jdata['province']} ${jdata['Zip_code']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Mobile number:</span> <br>
                <p class="" style="text-indent: 20px;">${jdata['mobile_num']}</p>
                </p>
               
                </div>
                <div class="col">
                <p class="fw-semibold" style="">Attachment:</p>
                <img src="/ialertu/uploads/account/${jdata['img']}" alt="" width="220" height="200" style="border-radius:5px">
               
                </div>
                </div>
                <button type="button" onclick="window.common.hideModal('reviewview');" class="py-2 px-4 bg-white" style="border:none;position: absolute; bottom: 0; right: 250px;">Close</button>
                <button type="button" onclick="reviewUpdate(${jdata['id']},'r')" class="py-2 px-4 bg-danger text-white" style="border-radius:5px;border:none;position: absolute; bottom: 0; right: 140px;">Reject</button>
                <button type="button" onclick="reviewUpdate(${jdata['id']},'a')" class="py-2 px-4 bg-db text-white" style="border-radius:5px;border:none;position: absolute; bottom: 0; right: 14px;">Approve</button>
                `;
    $('#reviewviewcon').html(con);
    window.common.showModal('reviewview');
}