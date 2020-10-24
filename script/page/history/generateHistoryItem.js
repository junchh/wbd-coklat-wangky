/**
 * Generate items for transaction history page
 * @param {Array.<{name:string, amount:number, price:number, datetime:string, address:string}>} historyArray Array of listed transactions
 */
const generateHistoryItem = (historyArray) => {
    const format = { year: 'numeric', month: 'long', day: 'numeric' };
    if(historyArray.length > 0){
      let items = `
      <table class="history__table" >
      <tr>
          <th>Chocolate Name</th>
          <th>Amount</th>
          <th>Total Price</th>
          <th>Date</th>
          <th>Time</th>
          <th>Address</th>
      </tr>
      `;
      for (let i = 0; i < historyArray.length; i++) {
        const itemDate = new Date(historyArray[i].date);
        items += `
        <tr>
          <td>${historyArray[i].name}</td>
          <td>${historyArray[i].amount}</td>
          <td>Rp <span>${
            parseInt(historyArray[i].price*historyArray[i].amount)
            .toLocaleString("id-ID")
          }</span></td>
          <td><span>${itemDate.toLocaleDateString("en-EN", format)}</span></td>
          <td><span>${itemDate.toLocaleTimeString("en-EN")}</td>
          <td>${historyArray[i].address}</td>
        </tr>
        `;
      }
      items += `</table>`;
      document.getElementById("history__tablecontainer").innerHTML = items;
    }
    else{
      noitems = '<div>No transactions yet.</div>';
      document.getElementById("history__tablecontainer").innerHTML = noitems;
    }
    
  };
  