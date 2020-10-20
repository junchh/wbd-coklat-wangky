const callback = (data) => {
  const result = JSON.parse(data);
  console.log(result["status"] + "\n" + result["description"]);
  if(result.hasOwnProperty('payload')){
    const session_id = result['payload']['token'];
    document.cookie = `session_id=${session_id}`;
    window.location = '/dashboard.html';
  }
}

const postRegisterForm = (event) => {
  event.preventDefault();
  if (verifyPassword()) {
    const formData = new FormData(event.target);
    postAPI("/api/register.php", callback, formData);
  }
  return;
};
