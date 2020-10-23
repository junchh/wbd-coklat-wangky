const callback = (data) => {
  const jsonData = JSON.parse(data);
  generateDashboardItem(jsonData.payload);
};

checkCookie();
getAPI("/api/chocolate/getchocolates.php", callback);
