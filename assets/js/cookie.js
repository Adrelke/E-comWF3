function addCookie(article){
    Cookies.set(article, document.getElementById('name').innerHTML, { expires: 7 });
}