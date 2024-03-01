var img = document.querySelector("#icone3");
var input = document.querySelector('#senha');

img.onclick = function() {
  if (input.getAttribute('type') === 'password') {
    input.setAttribute('type', 'text');
    img.setAttribute('src', 'img/icones/olho2.png');
  } else {
    input.setAttribute('type', 'password');
    img.setAttribute('src', 'img/icones/olho.png');
  }
};