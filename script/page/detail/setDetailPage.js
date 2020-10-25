const setDetailPage = (chocoId) => {
  getAPI(`/api/chocolate/getchocolate.php?id=${chocoId}`, (data) => {
    const jsonData = JSON.parse(data);

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
    } else {
      document.getElementById("detail-container").innerHTML =
        "Invalid chocolate id, please return to homepage.";
    }
  });
  getAPI(`/api/verifyadmin.php`, (data) => {
    const jsonData = JSON.parse(data);

    if (jsonData.status === "success") {
      document.getElementById(
        "buy-button"
      ).href = `/addstock.html?id=${chocoId}`;
      document.getElementById("buy-button").innerHTML = "Add Stock";
    } else {
      document.getElementById("buy-button").href = `/buy.html?id=${chocoId}`;
      document.getElementById("buy-button").innerHTML = "Buy";
    }
  });
};

checkCookie();
setDetailPage(new URLSearchParams(window.location.search).get("id"));
