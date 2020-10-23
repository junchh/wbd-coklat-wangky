const callback = (data) => {
  const jsonData = JSON.parse(data);
  generateDashboardItem(jsonData.payload);
};

checkCookie();
getAPI("/api/getchocolates.php", callback);
