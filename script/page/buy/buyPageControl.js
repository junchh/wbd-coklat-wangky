const updatePrice = () => {
    document.getElementById("totalPrice").innerHTML = parseInt(
        buyAmount * price
      ).toLocaleString("id-ID");;
}

const addBuyAmount = () => {
    buyAmount = Math.min(maxBuyAmount, buyAmount+1);
    document.getElementById("buyAmount").innerHTML = buyAmount;
    updatePrice();
}

const decBuyAmount = () => {
    buyAmount = Math.max(0, buyAmount-1);
    document.getElementById("buyAmount").innerHTML = buyAmount;
    updatePrice();
}

const buyCallback = (data) => {
    console.log(data)
}

const doBuy = () => {
    const id = new URLSearchParams(window.location.search).get("id");
    const date = new Date().toISOString().slice(0, 19).replace('T', ' ');
    const address = document.getElementById("buyAddress").value;
    
    if(buyAmount > 0){
        const formData = new FormData();
        formData.append('chocolate_id', id);
        formData.append('amount', buyAmount);
        formData.append('date', date);
        formData.append('address', address);

        postAPI("/api/transaction/createtransaction.php", buyCallback, formData);
    }
    
}