$(document).ready(function () {
    if (window.location.href.indexOf("?tab") > -1) {
        $("ul.nav.nav-tabs li").removeClass("active");
        $(
            'ul.nav.nav-tabs li[data-tab="' +
                window.location.search.replace("?tab=", "") +
                '"]'
        ).addClass("active");
        $(".tab-content .tab-pane").removeClass("active");
        $(
            ".tab-content .tab-pane#" +
                window.location.search.replace("?tab=", "") +
                ""
        ).addClass("active");
    }
    console.log("ready..!");
    setTimeout(function () {
        $("#example").DataTable();
    }, 101);
    setTimeout(function () {
        $("#example1").DataTable();
    }, 102);
    setTimeout(function () {
        $("#example2").DataTable({
            scrollX: true,
            pageLength: 50,
        });
    }, 103);
    setTimeout(function () {
        $("#example3").DataTable();
    }, 104);
    setTimeout(function () {
        $("#example14").DataTable();
    }, 105);
    setTimeout(function () {
        $("#example20").DataTable();
    }, 105);
    setTimeout(function () {
        $("#example21").DataTable();
    }, 105);
    setTimeout(function () {
        $("#example23").DataTable();
    }, 110);
    setTimeout(function () {
        $("#example24").DataTable();
    }, 111);
    setTimeout(function () {
        $("#example4").DataTable();
    }, 106);
    setTimeout(function () {
        $("#example5").DataTable();
    }, 107);
    setTimeout(function () {
        $("#example6").DataTable({
            scrollX: true,
        });
    }, 108);
    setTimeout(function () {
        $("#personalinfos").DataTable();
    }, 109);
});
// seller index...
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
// end seller index...
