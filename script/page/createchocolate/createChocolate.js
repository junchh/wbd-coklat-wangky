const createChocolate = (event) => {
  event.preventDefault();
  const formData = new FormData(event.target);
  postAPI(
    "/api/chocolate/createchocolate.php",
    (response) => {
      const jsonData = JSON.parse(response);
      if (jsonData["status"] == "success") {
        alert("Chocolate creation successful!");
        window.location = "/";
      } else {
        alert("failed");
      }
    },
    formData
  );
  return;
};

checkAdmin();