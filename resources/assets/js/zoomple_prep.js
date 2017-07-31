$(document).ready(function() {
    $('.zoomple').zoomple({
        blankURL : 'images/blank.gif',
        bgColor : 'white',
        offset : {x:-150,y:-150},
        zoomWidth : 300,
        zoomHeight : 300,
        roundedCorners : true,
        attachWindowToMouse: true,
    });
});