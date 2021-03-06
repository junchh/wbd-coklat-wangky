const addStockAmount = () => {
    addAmount = addAmount+1;
    document.getElementById("addStockAmount").innerHTML = addAmount;
}

const decStockAmount = () => {
    addAmount = Math.max(1, addAmount-1);
    document.getElementById("addStockAmount").innerHTML = addAmount;
}

const addCallback = (data) => {
    console.log(data);
    alert("Stock addition successful!");
    window.location = "/";
}

const doAddStock = () => {
    const id = new URLSearchParams(window.location.search).get("id");
    
    if(addAmount > 0){
        const formData = new FormData();
        formData.append('id', id);
        formData.append('currentQuantity', addAmount + amountAvailable);
        postAPI("/api/chocolate/updatestock.php", addCallback, formData);
    }
    
}