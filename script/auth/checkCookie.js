const checkCookieCallback = (data) => {
    const result = JSON.parse(data);
    if (!result.hasOwnProperty("status") || result["status"] !== "success") {
        window.location = '/login.html'
    }
}
  
const checkCookie = () => {
    const session_id = getCookie("session_id");
    if (session_id === null)   {
        window.location = '/login.html';
    }
    else {
        getAPI('/api/verifycookie.php', checkCookieCallback);
    }
}