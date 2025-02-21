<div class="modal" id="accview">
    <div class="d-flex" style="height: 100vh; width:100vw;justify-content: center; align-items: center;">
        <div class="bg-white pb-5" style="max-height:80;width:50vw;border-radius:3px;">
            <div class="">
                <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:3px;border-top-right-radius:3px;">
                    <p class="fs-4 fw-bold m-0">Update Details</p>
                </div>
                <!-- <hr style="border: none;height: 1px;" class="bg-green"> -->
            </div>

            <div id="accviewcon" class="mt-3 p-3" style="border-radius:5px;height:82%;position: relative;">
                <form action="" id="frmacc">
                    <input type="text" name="idno" id="idno" hidden>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-user"></i></span>
                        <input type="text" class="form-control shadow-none" id="uname" name="uname" placeholder="Username" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-user"></i></span>
                        <input type="text" class="form-control shadow-none" id="fname" name="fname" placeholder="First Name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-user"></i></span>
                        <input type="text" class="form-control shadow-none" id="mname" name="mname" placeholder="Middle Name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-user"></i></span>
                        <input type="text" class="form-control shadow-none" id="lname" name="lname" placeholder="Last Name">
                    </div>
                    <button type="button" onclick="window.common.hideModal('accview');" class="py-2 px-4 bg-white" style="border:none;position: absolute; bottom: -28px; right: 100px;">Cancel</button>
                    <button type="submit" class="py-2 px-4 bg-db text-white" style="border:none;border-radius:5px;position: absolute; bottom: -28px; right: 14px;">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal" id="accviewpass">
    <div class="d-flex" style="height: 100vh; width:100vw;justify-content: center; align-items: center;">
        <div class="bg-white pb-5" style="max-height:80;width:50vw;border-radius:3px;">
            <div class="">
                <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:3px;border-top-right-radius:3px;">
                    <p class="fs-4 fw-bold m-0">Change Password</p>
                </div>
                <!-- <hr style="border: none;height: 1px;" class="bg-green"> -->
            </div>

            <div id="accviewcon" class="mt-3 p-3" style="border-radius:5px;height:82%;position: relative;">
                <form action="" id="frmaccpass">
                    <input type="text" name="idnopass" id="idnopass" hidden>
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-key"></i></span>
                        <input type="text" class="form-control shadow-none" id="oldpass" name="oldpass" placeholder="Current Password" required>
                        <span class="toggle-password input-group-text bg-white text-main c-pointer" style="border-left: none !important;"><i class="eye-icon fa-solid fa-eye"></i></span>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-key"></i></span>
                        <input type="password" class="form-control shadow-none not-valid" id="newpass" name="newpass" placeholder="Password" required>
                        <span class="toggle-password input-group-text bg-white text-main c-pointer" style="border-left: none !important;"><i class="eye-icon fa-solid fa-eye"></i></span>
                    </div><span class="wrongpass">Password does not match!</span>

                    <div class="input-group mt-3">
                        <span class="input-group-text bg-db" id=""><i class="text-white fa-solid fa-key"></i></span>
                        <input type="password" class="form-control shadow-none" id="conpass" name="conpass" placeholder="Confirm Password" required>
                        <span class="toggle-password input-group-text bg-white text-main c-pointer" style="border-left: none !important;"><i class="eye-icon fa-solid fa-eye"></i></span>
                    </div><span class="wrongpass">Password does not match!</span>

                    <button type="button" onclick="clearpass();" class="py-2 px-4 bg-white" style="border:none;position: absolute; bottom: -28px; right: 100px;">Cancel</button>
                    <button type="submit" id="btnpass" class="py-2 px-4 bg-db text-white" style="border:none;border-radius:5px;position: absolute; bottom: -28px; right: 14px;">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row m-0 rp" style="padding-left:260px;height: 100vh;width:100%">
    <div class="col p-0 px-3 pb-3 " style="background: rgba(255, 255, 255, 0.5);backdrop-filter: blur(18px);">
        <div class="radius-c  p-5">
            <!-- background: rgba(255, 255, 255, 0.8);backdrop-filter: blur(14px); -->
            <div class="bg-db shadow  p-3 text-white" style="border-top-left-radius:5px;border-top-right-radius:5px; backdrop-filter: blur(17px);">
                <p class="fs-4 fw-bold m-0">Accounts</p>
            </div>
            <div class="px-2 pb-2 pt-3 bg-light" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;backdrop-filter: blur(17px);">
                <table class="table table-hover" id="tblaccount" style="overflow-y: scroll;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Middle Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider" id="tbladcontent">
                        <tr>
                            <td>1</td>
                            <td>admin</td>
                            <td>Clark</td>
                            <td></td>
                            <td></td>
                            <td><i class="me-2 fa-solid fa-pen-to-square"></i><i class="c-pointer fa-solid fa-key" style="color:#203864;" onclick="editacc('')"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>