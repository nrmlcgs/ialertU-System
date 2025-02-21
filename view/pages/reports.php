<div class="row m-0 rp" style="padding-left:260px;height: 100vh;width:100%">
    <div class="col p-0 px-3 pb-3 " style="background: rgba(255, 255, 255, 0.5);backdrop-filter: blur(18px);">
        <div class="radius-c pt-4">
            <!-- background: rgba(255, 255, 255, 0.8);backdrop-filter: blur(14px); -->
            <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:5px;border-top-right-radius:5px; backdrop-filter: blur(17px);">
                <p class="fs-4 fw-bold m-0">Emergency Reports</p>
            </div>
            <div class="px-2 pb-2 pt-3 bg-light" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;backdrop-filter: blur(17px);">
                <div class="row m-0 p-0" style="z-index: 99999;position:relative">
                    <div class="col p-0" style="width: 100%;">
                        <div class="" style="float: right;">
                            <input type="text" class="yearpicker text-center" id="yearselectorreport">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" style="height: 70vh;max-height:70vh;margin-top:-45px !important">
                    <div class="col px-4">
                        <p class="fw-bold fs-5" style="color: #203864;width:50%"><i class="fa-solid fa-person-falling-burst me-2"></i>Accidents</p>
                        <div id="chartdiv" style="width: 100%;height:90%"></div>
                    </div>
                </div>
                <br>
                <div class="row" style="height: 35vh;">
                    <div class="col px-4">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p class="fw-bold fs-5" style="color: #203864;"><i class="fa-solid fa-layer-group me-2"></i>Areas</p>
                            <input type="month" class="text-center" id="mpicker" placeholder="Select Year and Month" style="margin-bottom:1rem;user-select: none; float: right;">
                        </div>
                        <div id="chartdiv2" style="width: 100%;height:90%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>