const checkLoginCallback = (data) => {
    const result = JSON.parse(data);
    if (!result.hasOwnProperty("status") || result["status"] !== "success") {
        window.location = '/login.html'
    }
}
  
const checkLogin = () => {
    const session_id = getCookie("session_id");
    if (session_id === null)   {
        window.location = '/login.html';
    }
    else {
        getAPI('/api/verifycookie.php', checkLoginCallback);
    }
}

const checkAdminCallback = (data) => {
    const result = JSON.parse(data);
    if (!result.hasOwnProperty("status") || result["status"] !== "success") {
        window.location = '/index.html'
    }
}

const checkAdmin = () => {
    const session_id = getCookie("session_id");
    if (session_id === null)   {
        window.location = '/login.html';
    }
    else {
        getAPI('/api/verifyadmin.php', checkAdminCallback);
    }
}

const checkNotAdminCallback = (data) => {
    const result = JSON.parse(data);
    if (result.hasOwnProperty("status") && result["status"] === "success") {
        window.location = '/index.html'
    }
}

const checkNotAdmin = () => {
    const session_id = getCookie("session_id");
    if (session_id === null)   {
        window.location = '/login.html';
    }
    else {
        getAPI('/api/verifyadmin.php', checkNotAdminCallback);
    }
}