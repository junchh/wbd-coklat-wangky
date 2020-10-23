const origin = window.location.origin 
const path = window.location.pathname 
const query = new URL(window.location.href).searchParams

const callback = (response) => {
    const resObj = JSON.parse(response)
    if(resObj.status == "success") {
        const searchResult = resObj.payload 

        let items = ""
        let len = searchResult.length 
        for(let i = 0; i < len; i++) {
            const item = searchResult[i]
            items += `
            <div class="search-items">
                <div class="search-image">
                    <a href="/detail.html?id=${item.id}"><img src="${item.imagePath}" /></a>
                </div>
                <div class="search-item-description">
                    <h1><a href="/detail.html?id=${item.id}">${item.name}</a></h1>
                    <h2>Amount sold: ${item.quantitySold}</h2>
                    <h2>Price: ${parseInt(item.price).toLocaleString("id-ID")}</h2>
                    <h2>Amount remaining: ${item.currentQuantity}</h2>
                    <h2>Description</h2>
                    <p>
                        ${item.description}
                    </p>
                </div>
            </div>
            `
        }
        document.getElementById("search-result-container").innerHTML = items
    }

}

searchBox = document.getElementById("search-query")
searchBox.value = query.get('q')
getAPI("/api/search.php?q=" + searchBox.value, callback)

searchBox.addEventListener('input', () => {

    query.set('q', searchBox.value)
    window.history.replaceState(null, '', origin + path + '?q=' + query.get('q'))
    
    getAPI("/api/search.php?q=" + searchBox.value, callback)
})