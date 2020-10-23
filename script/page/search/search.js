const origin = window.location.origin 
const path = window.location.pathname 
const query = new URL(window.location.href).searchParams
console.log(query.get("q"))

searchBox = document.getElementById("search-query")
searchBox.addEventListener('input', () => {

    query.set('q', searchBox.value)
    window.history.replaceState(null, '', origin + path + '?q=' + query.get('q'))
})