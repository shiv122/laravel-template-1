window.addEventListener("load", function () {
    var load_screen = document.getElementById("load_screen");
    document.body.removeChild(load_screen);
});

function setTheme(data) {

    const theme = $(data).children().attr('class');
    const type = theme.split(" ");
    const exp = (d => d.setFullYear(d.getFullYear() + 1))(new Date)
    document.cookie = (type[1] === 'feather-moon') ? 'theme=dark; expires=Thu, 01 Jan 2026 00:00:00 UTC' : 'theme=light; expires=Thu, 01 Jan 2026 00:00:00 UTC';
}



