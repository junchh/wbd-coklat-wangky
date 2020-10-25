const origin = window.location.origin 
const path = window.location.pathname 
const query = new URL(window.location.href).searchParams

const itemPerPage = 2
let numOfPages = 0
let items = []
let currentPage = 1



const ceil = (a, b) => {
    if(a % b == 0) {
        return a / b;
    } else {
        return Math.floor(a / b) + 1;
    }
}

const changeUrl = (page) => {
    window.history.replaceState(null, '', origin + path + '?q=' + query.get('q') + '&page=' + page)
    currentPage = page
}

const displayPagination = (page) => {
    if(page >= 1 && page <= numOfPages) {
        const childs = document.getElementById("search-nav").childNodes 
        for(let i = 0; i < childs.length; i++) {
            childs[i].classList.remove("active")
        }

        document.getElementById(`search-${page}`).classList.add("active")
    }
}

const displaySearch = (page) => {
    if(page >= 1 && page <= numOfPages) {
        document.getElementById("search-result-container").innerHTML = items[page - 1]
    } else {
        document.getElementById("search-result-container").innerHTML = "<p>that page doesn't exist!</p>"
    }
}


const callback = (response) => {
    const resObj = JSON.parse(response)
    if(resObj.status == "success") {
        const searchResult = resObj.payload 

        let len = searchResult.length 

        numOfPages = ceil(len, itemPerPage)


        let cur = 0
        for(let i = 0; i < numOfPages; i++) {
            let str = ""
            for(let j = 0; j < itemPerPage && cur < len; j++) {
                const item = searchResult[cur]
                str += `
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
                cur++
            }
            items.push(str)
        }

        let str = ""
        for(let i = 0; i < numOfPages; i++) {
            if(i == 0) {
                str += `<li id="search-${i + 1}" value="${i + 1}" class="pagination-item active">${i + 1}</li>`
            } else {
                str += `<li id="search-${i + 1}" value="${i + 1}" class="pagination-item">${i + 1}</li>`
            }
        }
        document.getElementById("search-nav").innerHTML = str

        if(len != 0) {
            if(query.get("page")) {
                currentPage = parseInt(query.get("page"))
                displayPagination(currentPage)
                displaySearch(currentPage)
            }
            displayPagination(currentPage)
            displaySearch(currentPage)

            for(let i = 0; i < numOfPages; i++) {
                let cur = document.getElementById(`search-${i + 1}`)
                cur.addEventListener("click", (e) => {
                    let val = parseInt(e.target.value)
                    changeUrl(val)
                    displayPagination(val)
                    displaySearch(val)
                })
            }
        } else {
            document.getElementById("search-result-container").innerHTML = ""
        }
    }

}


// searchBox = document.getElementById("search-query")
// searchBox.value = query.get('q')

getAPI("/api/search.php?q=" + query.get('q'), callback)

// searchBox.addEventListener('input', () => {
//     query.set('q', searchBox.value)
//     window.history.replaceState(null, '', origin + path + '?q=' + query.get('q'))
    
//     getAPI("/api/search.php?q=" + searchBox.value, callback)

//     currentPage = 1

// })

