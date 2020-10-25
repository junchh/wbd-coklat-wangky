const getDashboardItem = (limit, all) => {
  getAPI("/api/chocolate/getchocolates.php", (data) => {
    const jsonData = JSON.parse(data);
    generateDashboardItem(jsonData.payload, limit, all);
  });
};

getDashboardItem(10, false);
