const addStockAmount = () => {
    addAmount = addAmount+1;
    document.getElementById("addStockAmount").innerHTML = addAmount;
}

const decStockAmount = () => {
    addAmount = Math.max(1, addAmount-1);
    document.getElementById("addStockAmount").innerHTML = addAmount;
}

const addCallback = (data) => {
    console.log(data)
}

const doAddStock = () => {
    const id = new URLSearchParams(window.location.search).get("id");
    
    if(addAmount > 0){
        const formData = new FormData();
        formData.append('chocolate_id', id);
        formData.append('amount', addAmount);
        // postAPI("/api/transaction/dummy.php", addCallback, formData);
    }
    
}