<div class="modal" id="recordview">
    <div class="d-flex" style="height: 100vh; width:100vw;justify-content: center; align-items: center;">
        <div class="bg-white pb-2" style="max-height:80;width:50vw;border-radius:3px;">
            <div class="">
                <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:3px;border-top-right-radius:3px;">
                    <p class="fs-4 fw-bold m-0">Emergency Report Details</p>
                </div>
                <!-- <hr style="border: none;height: 1px;" class="bg-green"> -->
            </div>

            <div id="recordviewcon" class="mt-2 p-3" style="border-radius:5px;height:82%;position: relative;">
                <!-- <div class="row">
                    <div class="col">
                        <p class="m-0"><span class="fw-semibold">Emergency ID:</span> <br>
                        <p class="" style="text-indent: 20px;">29</p>
                        </p>

                        <p class="m-0"><span class="fw-semibold">Incident:</span> <br>
                        <p class="" style="text-indent: 20px;">Vehicle Incident</p>
                        </p>
                        <p class="m-0"><span class="fw-semibold">Number of Victims:</span> <br>
                        <p class="" style="text-indent: 20px;">29</p>
                        </p>
                        <p class="m-0"><span class="fw-semibold">Individual who sent the report:</span> <br>
                        <p class="" style="text-indent: 20px;">Bryan Yamashita</p>
                        </p>
                        <p class="m-0"><span class="fw-semibold">Address:</span> <br>
                        <p class="" style="text-indent: 20px;">pasdnakjsbda</p>
                        </p>
                    </div>
                    <div class="col">

                        <p class="fw-semibold" style="">Attachment:</p>
                        <img src="/ialertu/assets/img/Picture1.jpg" alt="" width="220" height="200" style="border-radius:5px">

                    </div>
                </div>
                <button type="button" onclick="window.common.hideModal('recordview');" class="py-2 px-4 bg-white" style="border:none;position: absolute; bottom: 0; right: 14px;">Close</button> -->
            </div>

        </div>
    </div>
</div>

<div class="row m-0 rp" style="padding-left:260px;height: 100vh;width:100%">
    <div class="col p-0 px-3 pb-3 " style="background: rgba(255, 255, 255, 0.5);backdrop-filter: blur(18px);">
        <div class="radius-c  p-5">
            <!-- background: rgba(255, 255, 255, 0.8);backdrop-filter: blur(14px); -->
            <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:5px;border-top-right-radius:5px; backdrop-filter: blur(17px);">
                <p class="fs-4 fw-bold m-0">Emergency Records</p>
            </div>
            <div class="px-2 pb-2 pt-3 bg-light" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;backdrop-filter: blur(17px);">
                <table class="table table-hover" id="tblrecords" style="overflow-y: scroll;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Location</th>
                            <th scope="col">Accident Type</th>
                            <th scope="col">Number of Victims</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tbladcontent">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>