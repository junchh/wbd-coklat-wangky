const verifyPassword = () => {
  const pass = document.getElementById("password");
  const rePass = document.getElementById("rePassword");

  return pass.value === rePass.value;
};
