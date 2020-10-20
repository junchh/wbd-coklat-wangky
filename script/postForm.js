const callback = (data) => {
  const result = JSON.parse(data);
  alert(result["status"] + "\n" + result["description"]);
}

const postForm = (event) => {
  event.preventDefault();
  if (verifyPassword()) {
    const formData = new FormData(event.target);
    postAPI("/api/register.php", callback, formData);
  }
  return;
};
