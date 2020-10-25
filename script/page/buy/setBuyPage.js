let price = 0;
let buyAmount = 1;
let maxBuyAmount = 0;

const setBuyPage = (chocoId) => {
  getAPI(`/api/chocolate/getchocolate.php?id=${chocoId}`, (data) => {
    const jsonData = JSON.parse(data);
    console.log(jsonData);

    if (jsonData.status === "success") {
      const chocolate = jsonData.payload;
      document.getElementById("chocolate-name").innerHTML = chocolate.name;
      document.getElementById("chocolate-image").src = chocolate.imagePath;
      document.getElementById("chocolate-quantity-sold").innerHTML =
        chocolate.quantitySold;
      document.getElementById("chocolate-price").innerHTML = parseInt(
        chocolate.price
      ).toLocaleString("id-ID");
      document.getElementById("chocolate-current-quantity").innerHTML =
        chocolate.currentQuantity;
      document.getElementById("chocolate-description").innerHTML =
        chocolate.description;
      price = chocolate.price;
      maxBuyAmount = chocolate.currentQuantity;
      document.getElementById("buyAmount").innerHTML = buyAmount;
      document.getElementById("totalPrice").innerHTML = parseInt(
        buyAmount * price
      ).toLocaleString("id-ID");;
    } else {
      document.getElementById("detail-container").innerHTML =
        "Invalid chocolate gan";
    }
  });
};

checkLogin();
setBuyPage(new URLSearchParams(window.location.search).get("id"));

setInterval(() => {
  getAPI(`/api/chocolate/getchocolate.php?id=${new URLSearchParams(window.location.search).get("id")}`, (data) => {
    const jsonData = JSON.parse(data);

    if (jsonData.status === "success") {
      const chocolate = jsonData.payload;
      document.getElementById("chocolate-quantity-sold").innerHTML =
        chocolate.quantitySold;
      document.getElementById("chocolate-current-quantity").innerHTML =
        chocolate.currentQuantity;
      maxBuyAmount = chocolate.currentQuantity;
    }
  });
}, 1000)