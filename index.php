<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/assets/validation/o.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/header.php");
?>
<div class="" style="margin: 0;height: 100vh;display: flex; align-items: center;justify-content: center;">
    <div class="lgndiv">
        <div class="text-center fw-bold mt-4">
            <div class="" style="margin-bottom: -17px !important;">
                <i class="fs-2 fa-solid fa-location-dot" style="color: #4a77c5;"></i>
            </div>
            <p class="fs-1 text-main mb-3">
                iAlertU
            </p>
            <form action="" id="frmlgn">
                <div class="px-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text text-main bg-white" style="border-right: none !important" id="inputGroup-sizing-default"><i class="fa-solid fa-user"></i></span>
                        <input type="text" class="form-control shadow-none py-2" id="lgnuname" name="lgnuname" style="border-left: none !important;" placeholder="username" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" autocomplete="off" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text text-main bg-white" style="border-right: none !important" id="inputGroup-sizing-default"><i class="fa-solid fa-key"></i></span>
                        <input type="password" class="form-control shadow-none py-2" id="lgnpass" name="lgnpass" placeholder="password" style="border-left: none !important;border-right: none !important;" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                        <span class="toggle-password input-group-text bg-white text-main c-pointer" style="border-left: none !important;"><i id="passeye" class="fa-solid fa-eye"></i></span>
                   
                    </div>
                   
                </div>
                <div class="text-end px-5 mt-3">
                    <button id="lgnbtn" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/footer.php");
?>