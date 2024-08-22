import $ from 'jquery';
import 'magnific-popup';
import 'magnific-popup/dist/magnific-popup.css';

$(()=>{

    const galleries = [];

    // Collect and prepare wp-gallery
    $('.wp-block-gallery').each(function(i,v){
        const $gallery = $(v);
        let galleryId;

        if( $gallery.attr('id') ) {
            galleryId = $gallery.attr('id');
        } else {
            galleryId = 'wp-gallery-'+Math.random().toString(32).substring(2);
        }

        $(v).find('a').attr('data-gallery', galleryId);
    });

    // Collect all galleries
    $('a[data-gallery]').each(function(i,v){
        galleries.push($(v).attr('data-gallery'));
    });

    // Setup galleries for each galleries
    $.each(galleries, function(i,v){
        $('a[data-gallery="'+v+'"]').magnificPopup({
            type:'image',
            gallery: {
                enabled: true,
            },
            image: {
                verticalFit: true
            },
        });
    });

    // Setup single image lightboxes
    $("a[href$='.jpg']:not([data-gallery]),a[href$='.jpeg']:not([data-gallery]),a[href$='.png']:not([data-gallery]),a[href$='.gif']:not([data-gallery])").magnificPopup({
        type:'image',
        image: {
            verticalFit: true
        },
    });

    // Setup YouTube lightbox
    $("a[href*='youtube.']").magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});