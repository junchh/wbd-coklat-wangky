const createnavbar = () => {
  return `
    <nav class="navigation">
      <div class="navigation__linkcontainer">
        <a class="navigation__link" href="/"">Home</a>
        <a class="navigation__link" href="/history.html"">History</a>
      </div>
      <div class="navigation__searchcontainer">
        <form method="GET" action="search.html" class="navigation__searchcontainer__form">
          <input class="navigation__search" type="text" name="q" value="" placeholder="Search" />
        </form>
      </div>
      <div class="navigation__logoutcontainer">
        <a class="navigation__link" href="#" onclick="logout()">Logout</a>
      </div>
    </nav>
  `;
};
