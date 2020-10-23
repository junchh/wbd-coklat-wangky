const callback = (data) => {
  const result = JSON.parse(data);
  if(result.hasOwnProperty('status') && result["status"] === "success"){
    const session_id = result['payload']['token'];
    clearCookie();
    setCookie(session_id, 3600);
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
