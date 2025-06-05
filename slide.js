let cont = 1;
document.getElementById('radio1').checked = true;

setInterval(() => {
  cont++;
  if (cont > 3) cont = 1;
  document.getElementById('radio' + cont).checked = true;
}, 5000);