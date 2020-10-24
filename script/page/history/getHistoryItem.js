const callback = (data) => {
    const jsonData = JSON.parse(data);
    generateHistoryItem(jsonData.payload);
  };
  
  checkCookie();
  getAPI("/api/transaction/gettransactions.php", callback);
  