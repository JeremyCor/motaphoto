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
    let maxPages = parseInt($("#load-more").data("max-pages"), 10);

    $(document).ready(function() {
      console.log("Document ready");

      // Change event for category filter
      $("#categorie_id").change(function() {
        categorie_id = $(this).val();
        currentPage = 1;
        console.log("Category filter changed: ", categorie_id);
        loadPosts();
      });

      // Change event for format filter
      $("#format_id").change(function() {
        format_id = $(this).val();
        currentPage = 1;
        console.log("Format filter changed: ", format_id);
        loadPosts();
      });

      // Change event for sorting
      $("#date").change(function() {
        order = $(this).val();
        currentPage = 1;
        console.log("Sort order changed: ", order);
        loadPosts();
      });

      // Click event for load more
      $(document).on('click', '#load-more', function(e) {
        e.preventDefault();
        if (currentPage < maxPages) {
          currentPage++;
          console.log("Loading more posts - Page: ", currentPage);
          loadPosts(false); // false indicates it's not a full reload
        }
      });

      function loadPosts(replace = true) {
        console.log("Loading posts with params - Category:", categorie_id, "Format:", format_id, "Order:", order);
        $.ajax({
          url: $('#ajaxurl').val(),
          type: "POST",
          data: {
            action: "motaphoto_load",
            nonce: $('#nonce').val(),
            paged: currentPage,
            categorie_id: categorie_id,
            format_id: format_id,
            order: order,
            orderby: "date",
          },
          success: function(response) {
            //console.log("AJAX Response: ", response); // Log the response for debugging
            if (response) {
              if (replace) {
                $(".container-news").html(response);
              } else {
                $(".container-news").append(response);
              }

              // Check if there are more pages to load
              if (currentPage >= maxPages) {
                $("#load-more").hide();
              }
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
