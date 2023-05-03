<?php
header("Access-Control-Allow-Origin: *");
$activePage = 'home';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Media Library</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

  <!-- Navigation Bar -->
  <?php include 'header.php';?>

  <!-- Grid View -->
  <div class="container my-4">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mb-4">Home</h1>
      </div>
    </div>
    <div class="row" id="grid-view">
    </div>
  </div>

  <?php include 'footer.php';?>
  <script>
    $(document).ready(function() {
  // Make API call to retrieve home data
  $.ajax({
    url: "https://service-media-library.onrender.com/gethome",
    method: "GET",
    dataType : 'json',
    crossDomain: true,
    success: function(response) {
      // Extract data from API response
      const homeGrid = [];
      const media = [];

      // Loop through response array and extract data
      for (let i = 0; i < response.length; i++) {
        const item = response[i];
        homeGrid.push(item.title);
        media.push({
          poster: item.poster,
          title: item.title,
          description: item.short_description,
          cid: item.cid
        });
      }

      // Display data on page
      $("#homeGrid").text(`homeGrid: ${homeGrid.join(", ")}`);
      $("#poster").html(`<img src="${media[0].thumbnail}" alt="Poster">`);
      $("#title").text(`Title: ${media[0].title}`);

      // Display media items in grid view
      for (let i = 0; i < media.length; i++) {
        const item = media[i];
        const html = `
        <div class="col-md-3 mb-4">
  <div class="card rounded ">
    <img src="https://service-media-library.onrender.com/getImageAsset/?poster=${item.poster}" class="p-3 border border-primary primary-bg-color card-img-top" alt="${item.title}" onError="this.onerror=null;this.src='https://via.placeholder.com/350x200?text=Image+Not+Found';" style="height: 200px; object-fit: contain;">
    <div class="card-body text-center  primary-bg-color2">
      <h5 class="card-title text-center text-light ">${item.title}</h5>
      <p class="card-text">${item.description}</p>
      <a href="categories.php?cid=${item.cid}&title=${item.title}" class="btn btn-primary">View</a>
    </div>
  </div>
</div>
        `;
        $("#grid-view").append(html);
      }
    },
    error: function(xhr, textStatus, errorThrown) {
      console.log("Error:", textStatus);
    }
  });
});

  </script>
</body>
</html>
