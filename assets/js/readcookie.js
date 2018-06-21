var valeur = Cookies.get();

var panier = Object.keys(valeur).map(function(key) {
    return [Number(key), valeur[key]];
  });

console.log(panier);

var tr = document.createElement('tr')

for(var i=0; i< panier.length-1; i++){

    var tr = document.createElement('tr')
    var td = document.createElement('td')
    
    td.innerHTML = panier[i][1]
    tr.appendChild(td)
    document.getElementById('articles').append(tr);
}