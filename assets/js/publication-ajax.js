// Gestion de l'affichage des photos supplémentaires en page d'accueil
// en fonction de la valeur des filtres

/**
 * Variables récupérées / renvoyées
 *
 * nonce : jeton de sécurité
 * ajaxurl : adresse URL de la fonction Ajax dans WP
 *
 * categorie_id : n° de la catégorie demandée ou vide si on ne filtre pas par catégorie
 * format_id : n° du format demandé ou vide si on ne filtre pas par format
 * order : ordre de tri Croissant (ASC) ou Décroissant (DEC)
 * orderby : actuellement on trie par la date mais on pourrait éventuellement avoir un autre critère
 * posts_per_page : nombre de photos à afficher en même temps
 * currentPage : page affichée au moment de l'utilisation du script
 * max_pages : page maximum en fonction des filtres
 *
 */

document.addEventListener("DOMContentLoaded", function() {
  (function($) {
      $(document).ready(function() {
          var currentPage = 1;
          var maxPages = parseInt($('#max_pages').val());

          $('#load-more').on('click', function(e) {
              e.preventDefault();
              var button = $(this);
              var data = {
                  action: 'motaphoto_load_more',
                  paged: currentPage + 1,
                  nonce: $('#nonce').val(),
                  categorie_id: $('#categorie_id').val() || '',
                  format_id: $('#format_id').val() || '',
                  order: $('#order').val(),
                  orderby: $('#orderby').val(),
              }; 

              console.log("Loading more posts - Page: ", currentPage + 1);

              $.ajax({
                  url: $('#ajaxurl').val(),
                  type: 'POST',
                  data: data,
                  success: function(response) {
                      if(response) {
                          $('.container-news').append(response);
                          currentPage++;
                          if (currentPage >= maxPages) {
                              button.hide();
                          }
                      } else {
                          console.log('No more posts to load.');
                          button.hide();
                      }
                  },
                  error: function(xhr, status, error) {
                      console.log("AJAX Error: ", status, error);
                  }
              });
          });
      });
  })(jQuery);
});
