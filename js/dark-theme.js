$(document).ready(function () {
  CheckTheme();

  $(".btn-theme").on("click", function () {
    // save data at local storage for prevent reset next time
    let data = JSON.parse(localStorage.getItem("data"));
    if (data == "deactive") {
      data = "dark-theme";
      $(".theme-icon").addClass("la-moon");
    } else {
      data = "deactive";
      WhiteTheme();
      $(".theme-icon").addClass("la-sun");
    }

    localStorage.setItem("data", JSON.stringify(data));
    CheckTheme();
  });

  function CheckTheme() {
    let data = JSON.parse(localStorage.getItem("data"));
    if (!data) {
      data= 'deactive';
      localStorage.setItem("data", JSON.stringify(data));

      WhiteTheme();
      $(".theme-icon").addClass("la-moon");
    } else if (data == "deactive") {
      $(".theme-icon").removeClass("la-sun");
      $(".theme-icon").addClass("la-moon");
      
    } else {
      DarkTheme();
      $(".theme-icon").removeClass("la-moon");
      $(".theme-icon").addClass("la-sun");
    }
  }

  function WhiteTheme() {
    document.documentElement.classList.remove("dark-theme");
    $(".menu").css("filter", "invert(0) hue-rotate(180deg)");
    let returner = "dark-theme";
    localStorage.setItem("data", JSON.stringify(returner));
  }

  function DarkTheme() {
    document.documentElement.classList.add("dark-theme");
    $(".menu").css("filter", "invert(1) hue-rotate(180deg)");
    let returner = "dark-theme";
    localStorage.setItem("data", JSON.stringify(returner));
  }
});
