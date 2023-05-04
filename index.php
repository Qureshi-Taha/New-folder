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
  <?php include 'header.php';?>

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
    <!-- Modal popup -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="errorModalLabel">Error</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="errorModalBody">
          Not available
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  

  <script>
$(document).ready(function() {
  $.ajax({
    url: "https://service-media-library.onrender.com/gethome",
    method: "GET",
    dataType : 'json',
    crossDomain: true,
    success: function(response) {
      const homeGrid = [];
      const media = [];

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
      for (let i = 0; i < media.length; i++) {
        const item = media[i];
        const html = `
          <div class="col-md-3 mb-4">
    <div class="card rounded ">
      <img src="https://service-media-library.onrender.com/getImageAsset/?poster=${item.poster}" class="p-3 border border-primary primary-bg-color card-img-top" alt="${item.title}" onError="this.onerror=null;this.src='https://via.placeholder.com/350x200?text=Image+Not+Found';" style="height: 200px; object-fit: contain;">
      <div class="card-body text-center  primary-bg-color2">
        <h5 class="card-title text-center text-light ">${item.title}</h5>
        <p class="card-text">${item.description}</p>
        <a href="#" class="btn btn-primary view-category" data-cid="${item.cid}" data-title="${item.title}">View</a>
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

  $(document).on("click", ".view-category", function(e) {
    e.preventDefault();
    const cid = $(this).data("cid");
    const title = $(this).data("title");

    $.ajax({
      url: `https://service-media-library.onrender.com/categories?cat_id=${cid}`,
      method: "GET",
      dataType : 'json',
      crossDomain: true,
      success: function(response) {
        if (response.length > 0) {
          window.location.href = `categories.php?cid=${cid}&title=${title}`;
        } else {
          // alert("Category not available.");
          $('#errorModal').modal('show');
        }
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log("Error:", textStatus);
      }
    });
  });
});
  </script>
</body>
</html>
