<?php
header("Access-Control-Allow-Origin: *");
$activePage = 'media';
if ($_GET && $_GET['cid']) {
    $cid = $_GET['cid'];  
}else{
    header("Location: index.php");
}
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
        <h1 class="mb-4">Media</h1>
      </div>
    </div>
    <div class="row" id="grid-view">
    </div>
  </div>

 <?php include 'footer.php';?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-fluid" id="modal-poster">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 id="modal-title"></h3>
                            <p id="modal-duration"></p>
                            <p id="modal-genre"></p>
                            <p id="modal-rating"></p>
                        </div>
                        <div class="col-md-12">
                            <h5>Cast:</h5>
                            <p id="modal-cast"></p>
                        </div>
                        <div class="col-md-12">
                            <h5>Description:</h5>
                            <p id="modal-description"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

  <script>
    $(document).ready(function() {
  // Make API call to retrieve home data
  
  $.ajax({
    url: `https://service-media-library.onrender.com/medialist/?cat_id=<?= $cid; ?>`,
    method: "GET",
    dataType : 'json',
    crossDomain: true,
    success: function(response) {
      // Extract data from API response
      const mediaGrid = [];
      const media = [];
    //   console.log(response)

      // Loop through response array and extract data
      for (let i = 0; i < response.length; i++) {
        const item = response[i];
        mediaGrid.push(item.title);
        media.push({
          poster: item[1].poster,
          title: item[1].title,
          mid: item[1].mid,
          contenttype: item[0].contenttype,
          cid: item[0].cid,
          cast_list: item[1].cast_list,
          description: item[1].description,
        });
      }
   // Display media items in grid view
    if (media.length > 0) {
        for (let i = 0; i < media.length; i++) {
        const item = media[i];
        const html = `
        <div class="col-md-3 mb-4">
            <div class="card rounded ">
                <img src="https://service-media-library.onrender.com/getImageAsset/?poster=${item.poster}" class="border border-primary primary-bg-color card-img-top" alt="${item.title}" onError="this.onerror=null;this.src='https://via.placeholder.com/350x200?text=Image+Not+Found';" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center  primary-bg-color2">
                <h5 class="card-title text-center text-light ">${item.title}</h5>
                <p class="card-text text-light text-left">${item.description}</p>
                <a href="#" class="btn btn-primary view-modal" data-toggle="modal" data-target="#myModal" onClick="showModal(${item.mid})" data-media-id="${item.mid}">View</a>
                </div>
            </div>
            </div>
        `;
        $("#grid-view").append(html);
        
      }
    } else {
        const html = `
        <div class="col-md-3 mb-4">
            <div class="text-danger rounded ">
                <h4>! No Data found</h4>
                <a href="index.php" class="btn btn-primary">< back to home</a>
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

function showModal(media_id){
        $.ajax({
            url: 'https://service-media-library.onrender.com/mediadata/?media_id=' + media_id,
            type: 'GET',
            success: function(response) {
                $('#modal-title').text(response[0].title);
                $('#modal-duration').text('Duration: ' + response[0].duration);
                $('#modal-genre').text('Genre: ' + response[0].genre);
                $('#modal-rating').text('Rating: ' + response[0].rating);
                $('#modal-cast').text(response[0].cast_list);
                $('#modal-description').text(response[0].description);
                $('#modal-poster').attr('src', 'https://service-media-library.onrender.com/getImageAsset/?poster=' + response[0].poster);
                $('#modal-poster').attr('onError', 'this.onerror=null;this.src="https://via.placeholder.com/350x200?text=Image+Not+Found"');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


  </script>

</body>
</html>
