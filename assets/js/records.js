let table;
let selectedrow;
let selectedMap;
function editdatatable(data, _transaction) {
    let lname = document.getElementById('editlname'),
        fname = document.getElementById('editfname'),
        mname = document.getElementById('editmname'),
        bdate = document.getElementById('editbdate'),
        ddate = document.getElementById('editddate');
    let tr = $(data).closest('tr');
    let row = table.row(tr);
    selectedrow = row.data();
    switch (_transaction) {
        case 'update':
            lname.value = row.data().lname;
            fname.value = row.data().fname;
            mname.value = row.data().mname;
            bdate.value = row.data().dateofbirth;
            ddate.value = row.data().datedied;
            window.common.showModal('deceasedModal');
            break;
        case 'delete':
            Swal.fire({
                title: 'Are you sure?',
                html: `You are about to delete the data of<br> <b>${row.data().lname} ${row.data().fname} ${row.data().mname}    </b> <br>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    saveEditeddata(_transaction);
                }
            })

            break;
    }
}
function saveEditeddata(_transaction) {
    let lname = document.getElementById('editlname').value;
    let fname = document.getElementById('editfname').value;
    let mname = document.getElementById('editmname').value;
    let bdate = document.getElementById('editbdate').value;
    let ddate = document.getElementById('editddate').value;
    const setdata = deceasedData.find(item => item.id === selectedrow.id && item.tombnum === selectedrow.tombnum);
    function updateDataDB() {
        let a = JSON.stringify(deceasedData)
        $.ajax({
            type: "POST",
            url: `/CMIS/Controllers/Deceased.php?f=mdt`,
            data: { d: a, t: _transaction, l: selectedMap },
            success: function (data) {
                switch (data) {
                    case 'updatedtable':
                        // Data has been saved!
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data has been saved!',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        window.common.hideModal('deceasedModal');
                        break;
                    case 'datadeleted':
                        table.clear().rows.add(deceasedData).draw();
                        break;
                }
            }
        })
    }
    if (setdata !== -1) {
        switch (_transaction) {
            case 'update':
                setdata.lname = lname;
                setdata.fname = fname;
                setdata.mname = mname;
                setdata.dateofbirth = bdate;
                setdata.datedied = ddate;

                let rowIndex = -1;
                table.rows().every(function (index) {
                    if (this.data().id === selectedrow.id && this.data().tombnum === selectedrow.tombnum) {
                        rowIndex = index;
                        return false;
                    }
                });
                if (rowIndex !== -1) {
                    table.row(rowIndex).data(setdata);
                    table.draw();
                    updateDataDB();
                } else {
                    alert('error')
                }
                break;
            case 'delete':
                deceasedData = deceasedData.filter(item => !(item.id === setdata.id && item.tombnum === setdata.tombnum));
                if (deceasedData) {
                    updateDataDB();

                }
                break;
        }
        let rowIndex = -1;
        table.rows().every(function (index) {
            if (this.data().id === selectedrow.id && this.data().tombnum === selectedrow.tombnum) {
                rowIndex = index;
                return false;
            }
        });

    } else {
    }
}
function loadtabledata(mn) {
    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Records.php?f=gtd`,
        data: { s: mn },
        success: function (data) {
            $('#tbladcontent').html(data)
            $('#tblrecords').DataTable({
                // "autoWidth": true
                // "scrollY": "65vh"
            });
        }
    });
}
function viewreport(data, u) {

    let stat,attch;
    var jdata = JSON.parse(data);
    if (jdata['status'] == 1) {
        stat = ' <p class="text-success" style="text-indent: 20px;">Responded</p>';
    } else {
        stat = '<p class="text-danger" style="text-indent: 20px;">Not Responded</p>';
    }
    if (jdata['image'] == ""){
        attch = "default.png";
    }else{
        attch = jdata['image'];
    }
    var con = `
    <div class="row">
    <div class="col">
                <p class="m-0"><span class="fw-semibold">Emergency ID:</span> <br>
                <p style="text-indent: 20px;">${jdata['id']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Incident:</span> <br>
                <p style="text-indent: 20px;">${jdata['date']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Incident:</span> <br>
                <p style="text-indent: 20px;">${jdata['accident_type']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Number of Victims:</span> <br>
                <p style="text-indent: 20px;">${jdata['num_victims']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Individual who sent the report:</span> <br>
                <p style="text-indent: 20px;">${u}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Address:</span> <br>
                <p class="" style="text-indent: 20px;">${jdata['location']}</p>
                </p>
                <p class="m-0"><span class="fw-semibold">Status:</span> <br>
                ${stat}
                </p>
                </div>
                <div class="col">
                <p class="fw-semibold" style="">Attachment:</p>
                <img src="/ialertu/uploads/${attch}" alt="" width="220" height="200" style="border-radius:5px">
               
                </div>
                </div>
                <button type="button" onclick="window.common.hideModal('recordview');" class="py-2 px-4 bg-white" style="border:none;position: absolute; bottom: 0; right: 14px;">Close</button>
                `;
    $('#recordviewcon').html(con);
    window.common.showModal('recordview');
}