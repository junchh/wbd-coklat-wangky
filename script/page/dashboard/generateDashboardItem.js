/**
 * Generate dashboard item for dashboard page
 * @param {Array.<{id:number, name:string, price:number, imagePath:string, quantitySold: number, currentQuantity:number}>} chocolateArray Array of listed chocolates
 */
const generateDashboardItem = (chocolateArray, limit, all) => {
  let items = "";

  let count = chocolateArray.length < limit ? chocolateArray.length : limit;
  if (all) {
    console.log("hehe");
    count = chocolateArray.length;
  }

  console.log(count);
  for (let i = 0; i < count; i++) {
    items += `
    <a href="/detail.html?id=${chocolateArray[i].id}" class="dashboard__link">
      <div class="dashboard__item">
        <img src="${chocolateArray[i].imagePath}" />
        <div class="dashboard__item__description">
          <div class="dashboard__item__description__title">${
            chocolateArray[i].name
          }</div>
          <div>
            <div class="dashboard__item__description__text">Amount sold: <span>${
              chocolateArray[i].quantitySold
            }</span></div>
            <div class="dashboard__item__description__text">Price: Rp <span>${parseInt(
              chocolateArray[i].price
            ).toLocaleString("id-ID")}</span></div>
          </div>
        </div>
      </div>
    </a>
    `;
  }
  document.getElementById("dashboard__itemcontainer").innerHTML = items;
};
