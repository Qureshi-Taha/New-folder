<?php
header("Access-Control-Allow-Origin: *");
$activePage = 'categories';
if ($_GET && $_GET['cid'] && $_GET['title']) {
    $cid = $_GET['cid'];  
    $title = $_GET['title'];  
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
        <h1 class="mb-4">Categories : <?= $title; ?></h1>
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
    url: `https://service-media-library.onrender.com/categories?cat_id=<?= $cid; ?>`,
    method: "GET",
    dataType : 'json',
    crossDomain: true,
    success: function(response) {
      // Extract data from API response
      const categoryGrid = [];
      const media = [];
      console.log(response)

      // Loop through response array and extract data
      for (let i = 0; i < response.length; i++) {
        const item = response[i];
        categoryGrid.push(item.title);
        media.push({
          poster: item.poster,
          title: item.title,
          cid: item.cid,
          parent_cid: item.parent_cid,
          category_order: item.category_order,
          parent_cid: item.parent_cid,
          description: item.description,
          template_id: item.template_id
        });
      }
    //   // Display media items in grid view
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
