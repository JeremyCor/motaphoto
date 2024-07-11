// Script pour gérer les filtres d'affichage en page d'accueil (front-page)
console.log("Script filtres en ajax lancé !!!");

document.addEventListener("DOMContentLoaded", function() {
  console.log("DOMContentLoaded event triggered");
  (function($) {
    console.log("jQuery function executed");

    let categorie_id = "";
    let format_id = "";
    let order = "DESC";
    let currentPage = 1;

    $(document).ready(function() {
      console.log("Document ready");

      // Click event for category filter
      $("#categorie_id").change(function() {
        categorie_id = $(this).val();
        currentPage = 1;
        console.log("Category filter clicked: ", categorie_id);
        loadPosts();
      });

      // Click event for format filter
      $("#format_id").change(function() {
        format_id = $(this).val();
        currentPage = 1;
        console.log("Format filter clicked: ", format_id);
        loadPosts();
      });

      // Click event for sorting
      $("#date").change(function() {
        order = $(this).val();
        currentPage = 1;
        console.log("Sort order clicked: ", order);
        loadPosts();
      });

      function loadPosts() {
        console.log("Loading posts with params - Category:", categorie_id, "Format:", format_id, "Order:", order);
        $.ajax({
          url: motaphoto_params.ajaxurl,
          type: "POST",
          data: {
            action: "motaphoto_load",
            nonce: motaphoto_params.nonce,
            paged: currentPage,
            categorie_id: categorie_id,
            format_id: format_id,
            order: order,
            orderby: "date",
          },
          success: function(response) {
            console.log("AJAX Response: ", response); // Log the response for debugging
            if (response) {
              $(".container-news").html(response);
            }
          },
          error: function(xhr, status, error) {
            console.log("AJAX Error: ", status, error);
          },
        });
      }

      // Initial call to load posts
      loadPosts();
    });
  })(jQuery);
});
