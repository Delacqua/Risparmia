//show / hide Consumo ---------------
function conosciConsumo(elemento) {
  if (elemento.checked) {
    document.getElementById("compilaCompleti").style.display = 'block';
    document.getElementById("compilaIncompleti").style.display = 'none';
  }
  else {
    document.getElementById("compilaCompleti").style.display = 'none';
    document.getElementById("compilaIncompleti").style.display = 'block';
  }
}

//show / hide IVA ---------------

function partitaIva(elemento) {
  if (elemento.checked) {
    document.getElementById("privati").style.display = 'none';
    document.getElementById("iva").style.display = 'block';
  }
  else {
    document.getElementById("privati").style.display = 'block';
    document.getElementById("iva").style.display = 'none';
  }
}


//Facebook ---------------

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.10&appId=217959564917248";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));