const callback = (data) => {
    const jsonData = JSON.parse(data);
    generateHistoryItem(jsonData.payload);
  };
  
  checkNotAdmin();
  getAPI("/api/transaction/gettransactions.php", callback);
  