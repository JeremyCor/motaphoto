// modal contact
$(document).ready(function() {
    let openModal = $("#menu-item-24");

    openModal.click(function() {
        $('.modal').css("display", "flex");
    });

    $(document).mouseup(function(e) {
        let obj = $('.container');
        if (!obj.is(e.target) && obj.has(e.target).length === 0) {
            $('.modal').css("display", "none");
        }
    });
   

    
    let openModalMobil = $("#menu-menu-principal-1 > li.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-24");
    openModalMobil.click(function() {
        $(".modal").css("display",'flex');
    });
});

//modal des pages de posts
$(document).ready(function() {
    let ref = $('#reference > span > input');
    // let ref_post = $('.ref-post');

    $('.post-contact-button').click(function() {
        $('.modal').css('display', 'flex');
        ref.val($('.ref-post').text());
        $('.ref-post').css('display','none')
    });
});


// modal lightbox
jQuery(document).ready(function($) {
    $('.icone_fullscreen').click(function() {
        $('#modaLightbox').css("display","flex");
        let clickPhoto=(this).getAttribute('data-id');
        console.log(clickPhoto);
        // Accéder aux données depuis la variable JavaScript
            for (var i = 0; i < articlesData.length; i++) {
                var article = articlesData[i];
                // Vérifiez si l'ID correspond à l'ID recherché
                if (article.ID == clickPhoto) {
                    // Sélectionnez l'élément avec la classe 'clickPhotoSuiv'
                    $('.post-image-light').html('')
                    $('.post-image-light').append(article.thumbnail)
                    $('.arrow-suiv').attr('data-id', article.ID);
                    $('.arrow-prec').attr('data-id', article.ID);

                    break; // Arrêtez la boucle
                }
            }
    });
});


jQuery(document).ready(function($) {
    $('.close-lightbox').click(function() {
        $('#modaLightbox').css("display","none");
     });
});

$('.arrow-suiv').click(function() {
    let dataId = parseInt(this.getAttribute('data-id'));
    dataId += 1;
     // Accéder aux données depuis la variable JavaScript
     for (var i = 0; i < articlesData.length; i++) {
        var article = articlesData[i];
       
        // Vérifiez si l'ID correspond à l'ID recherché
        if (article.ID === dataId) {
            // Sélectionnez l'élément avec la classe 'clickPhotoSuiv'
            $('.post-image-light').html('')
            $('.post-image-light').append(article.thumbnail) 

            $('.ref').html('')
            $('.ref').append(article.field.reference[0])

            $('.therme').html('')
            $('.therme').append(article.taxonomy[0].name)

            $('.arrow-suiv').attr('data-id', article.ID);
            $('.arrow-prec').attr('data-id', article.ID);
            break; // Arrêtez la boucle
        }
    }
  
});

$('.arrow-prec').click(function() {
    let dataId = parseInt(this.getAttribute('data-id'));
    dataId -= 1;
    console.log(articlesData);

     // Accéder aux données depuis la variable JavaScript
     for (var i = 0; i < articlesData.length; i++) {
        var article = articlesData[i];
        
        // Vérifiez si l'ID correspond à l'ID recherché
        if (article.ID === dataId) {
            // Sélectionnez l'élément avec la classe 'clickPhotoSuiv'
            console.log(article.taxonomy[0].name);
            console.log(article.field.reference[0]);

            $('.post-image-light').html('')
            $('.post-image-light').append(article.thumbnail)

            $('.ref').html('')
            $('.ref').append(article.field.reference[0])

            $('.therme').html('')
            $('.therme').append(article.taxonomy[0].name)

            $('.arrow-prec').attr('data-id', article.ID);
            $('.arrow-suiv').attr('data-id', article.ID);
            
            break; // Arrêtez la boucle
        }

       
       
    }
});








