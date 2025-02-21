<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/assets/validation/i.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/header.php");
?>
<div id="divModalBackground" style="position: fixed; background-color: black; width: 100%; height: 100vh; z-index: 101; top: 0; left: 0; opacity: 70%; display: none"></div>
<aside class="sidebar">
    <div class="logo pt-4 pb-3">
        <img src="/ialertu/assets/img/<?php echo $_SESSION['img'] ?>" alt="logo">

        <h2 class="fw-bold fs-2 pt-2">iAlertU</h2>
        <hr>
    </div>
    <ul class="links ps-0">
        <h4>Main Menu</h4>
        <li class="menuitem" id="lidash">
            <span class="material-symbols-outlined">dashboard</span>
            <a href="#dashboard">Dashboard</a>
        </li>
        <!-- <li class="menuitem" id="liemergency">
            <span class="material-symbols-outlined">emergency</span>
            <a href="#emergency">Emergency</a>
        </li> -->
        <li class="menuitem" id="lirecords">
            <span class="material-symbols-outlined">flag</span>
            <a href="#records">Records</a>
        </li>
        <li class="menuitem" id="lireports">
            <span class="material-symbols-outlined">show_chart</span>
            <a href="#reports">Reports</a>
        </li>
        <hr>
        <h4>Account</h4>
        <li class="menuitem" id="lireview">
            <span class="material-symbols-outlined">content_paste_search</span>
            <a href="#review">Review</a>
        </li>
        <li class="menuitem" id="lisettings">
            <span class="material-symbols-outlined">settings</span>
            <a href="#settings">Settings</a>
        </li>
        <!-- <li class="logout-link">

        </li> -->
    </ul>
    <div class="logout-link mb-2" id="lgo">
        <span class="material-symbols-outlined">logout</span>
        <a>Logout</a>
    </div>
</aside>
<div class="contentparent">
    <div id="allcontent" style="height: 100vh;overflow-y:scroll">

    </div>
</div>
<div class="fixed-div" id="emerID">
    <p class="fw-bold fs-5"> <i class="text-danger fa-solid fa-triangle-exclamation me-2"></i>Emergency Report</p>
    <div class="" id="infoDiv">
    </div>
    <!-- <button type="button" onclick="tryeditmap(event)">Find Directions</button> -->

</div>










<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/ialertu/view/footer.php");
?>