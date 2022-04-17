

$(".sidebar-toggle").on('click', function () {
    if (window.innerWidth > 600){
        setTimeout(function () {
            if ($('.sidebar-mini').hasClass('sidebar-collapse')) {
                setCookie('sidebar-collapse', 1, 30)
            } else {
                setCookie('sidebar-collapse', 0, -1)
            }
        }, 100);

        setTimeout(function () {
            window.location.reload();
        }, 300);
    }
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}