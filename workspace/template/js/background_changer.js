$(function () {
    var body = $('body');
    var backgrounds = [
      'url(/template/img/appbackground.jpg)',
      'url(/template/img/appbackground3.jpg)',
      'url(/template/img/appbackground4.jpg)',
      'url(/template/img/appbackground5.jpg)',
      'url(/template/img/appbackground2.jpg)'];
    var current = 0;

    function nextBackground() {
        body.css(
            'background',
        backgrounds[current = ++current % backgrounds.length]);

        setTimeout(nextBackground, 10000);
    }
    setTimeout(nextBackground, 10000);
    body.css('background', backgrounds[0]);
});