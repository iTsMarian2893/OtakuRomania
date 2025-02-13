var searchButton = document.querySelector(".search-button");
var searchBar = document.querySelector("#search-bar");
var searchInput = document.querySelector(".search-input");
var searchResultsList = document.querySelector(".search-results");

searchButton.addEventListener("click", function() {
  searchBar.style.display = "block";
  searchInput.focus();
});

function performSearch(event) {
  event.preventDefault();

  var searchValue = searchInput.value.trim().toLowerCase();

  if (searchValue.length > 0) {
    var results = [
      {
        title: "Naruto",
        image: "naruto.jpg",
        year: 2002,
        link: "naruto.html"
      },
      {
        title: "One Piece",
        image: "poze/one_piece_red.png",
        year: 1999,
        link: "pagini/one_piece_red/one_piece_red_detalii.php"
      },
      {
        title: "Boruto",
        image: "boruto.jpg",
        year: 2017,
        link: "boruto.html"
      },
      {
        title: "Hunter x Hunter",
        image: "hunter-x-hunter.jpg",
        year: 1999,
        link: "hunter-x-hunter.html"
      },
      {
        title: "Demon Slayer",
        image: "hunter-x-hunter.jpg",
        year: 1999,
        link: "hunter-x-hunter.html"
      },
      {
        title: "Goblin Slayer",
        image: "hunter-x-hunter.jpg",
        year: 1999,
        link: "hunter-x-hunter.html"
      },
      {
        title: "Attack on Titan",
        image: "attack-on-titan.jpg",
        year: 2013,
        link: "attack-on-titan.html"
      }
    ];

    var filteredResults = results.filter(function(result) {
      return result.title.toLowerCase().includes(searchValue);
    });

    searchResultsList.innerHTML = "";

    if (filteredResults.length > 0) {
      filteredResults.forEach(function(result) {
        var searchItem = document.createElement("li");

        var thumbnail = document.createElement("img");
        thumbnail.src = result.image;
        thumbnail.alt = result.title;

        var resultDetails = document.createElement("div");
        resultDetails.classList.add("result-details");

        var resultTitle = document.createElement("div");
        resultTitle.classList.add("result-title");
        resultTitle.textContent = result.title;

        var resultYear = document.createElement("div");
        resultYear.classList.add("result-year");
        resultYear.textContent = "Anul: " + result.year;

        var resultLink = document.createElement("a");
        resultLink.classList.add("result-link");
        resultLink.href = result.link;

        resultDetails.appendChild(resultTitle);
        resultDetails.appendChild(resultYear);
        searchItem.appendChild(thumbnail);
        searchItem.appendChild(resultDetails);
        searchItem.appendChild(resultLink);

        searchItem.addEventListener("click", function() {
          window.location.href = result.link;
        });

        searchResultsList.appendChild(searchItem);
      });
    } else {
      searchResultsList.innerHTML = "<li>Niciun rezultat găsit.</li>";
    }
  } else {
    searchResultsList.innerHTML = "";
  }
}

var searchForm = document.querySelector(".search-form");
searchForm.addEventListener("submit", performSearch);

searchInput.addEventListener("input", function() {
  performSearch(event);
});

document.addEventListener("click", function(event) {
  var target = event.target;
  if (!searchBar.contains(target) && !searchButton.contains(target)) {
    searchBar.style.display = "none";
  }
});