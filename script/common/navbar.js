const createNavbar = () => {
  return `
  <nav class="navigation">
    <div class="navigation__linkcontainer">
      <a class="navigation__link" href="/" onclick="console.log('Home')">
        <span class="navigation__linkhover">
          Home
        </span>
      </a>
      <a class="navigation__link" href="/history.html" onclick="console.log('History')">
        <span class="navigation__linkhover">
          History
        </span>
      </a>
    </div>
    <div class="navigation__searchcontainer">
      <form method="GET" action="search.html" class="navigation__searchcontainer__form">
        <input class="navigation__search" type="text" name="q" value="" placeholder="Search" />
      </form>
    </div>
    <div class="navigation__logoutcontainer">
      <a class="navigation__link" href="#" onclick="logout()">
        <span class="navigation__linkhover">
          Logout
        </span>
      </a>
    </div>
  </nav>
  `;
};

document.getElementById("navigation-container").innerHTML = createNavbar();