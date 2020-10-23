const getUsername = () => {
  getAPI("/api/auth/getuserdata.php", (data) => {
    const user = JSON.parse(data);
    console.log(user.payload.username);
    document.getElementById("username").innerHTML = user.payload.username;
  });
};

getUsername();
