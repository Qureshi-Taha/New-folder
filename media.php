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
      console.log(response)

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
                <p class="card-text">${item.description}</p>
                <a href="media.php?cid=${item.cid}" class="btn btn-primary">View</a>
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

  </script>

</body>
</html>
