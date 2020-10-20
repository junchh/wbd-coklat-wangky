const getCookie = (key) => {
  const cookies = document.cookie.split(";");
  for(const pair of cookies) {
    var keyVal = pair.split("=");
    if(key == keyVal[0].trim()) {
        return decodeURIComponent(keyVal[1]);
    }
  }
  return null;
}

const checkCookie = () => {
  const session_id=getCookie("session_id");
  if (session_id === null) {
    window.location = '/login.html';
  }
  else {
  	// TODO: check cookie to session
  }
}