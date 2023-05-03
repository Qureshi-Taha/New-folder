$(document).ready(function() {
  // Make API call to retrieve home data
  $.ajax({
    url: "https://service-media-library.onrender.com/gethome",
    method: "GET",
    dataType: "json",
    crossDomain: true,
    success: function(response) {
      // Extract data from API response
      const categories = [];
      const media = [];

      // Loop through response array and extract data
      for (let i = 0; i < response.length; i++) {
        const item = response[i];
        categories.push(item.title);
        media.push({
          thumbnail: item.poster,
          title: item.title,
          description: item.short_description
        });
      }

      // Display data on page
      $("#categories").text(`Categories: ${categories.join(", ")}`);
      $("#poster").html(`<img src="${media[0].thumbnail}" alt="Poster">`);
      $("#title").text(`Title: ${media[0].title}`);

      // Display date and time
      const dateTime = new Date().toLocaleString();
      $("#date-time").text(`Date & Time: ${dateTime}`);
    },
    error: function(xhr, textStatus, errorThrown) {
      console.log("Error:", textStatus);
    }
  });
});
  