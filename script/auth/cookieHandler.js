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

const setCookie = (session_id, expiry) => {
  const d = new Date();
  d.setTime(d.getTime() + (expiry * 1000));
  document.cookie = `session_id=${session_id};expires=${d.toUTCString()};path=/`;
}

const clearCookie = () => {
  const expiredDate = "Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = `session_id=;expires=${expiredDate};path=/`
}

const checkCookie = () => {
  const session_id = getCookie("session_id");
  if (session_id === null)   {
    window.location = '/login.html';
  }
  else {
  	// TODO: check cookie to session
  }
}