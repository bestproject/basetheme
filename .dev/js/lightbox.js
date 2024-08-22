import $ from 'jquery';
import 'magnific-popup';
import 'magnific-popup/dist/magnific-popup.css';

$(()=>{

    const galleries = [];

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

    $('a[data-gallery]').each(function(i,v){
        galleries.push($(v).attr('data-gallery'));

        $(v).attr('gallery-setup-up','true');
    });

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

    $("a[href$='.jpg']:not([data-gallery]),a[href$='.jpeg']:not([data-gallery]),a[href$='.png']:not([data-gallery]),a[href$='.gif']:not([data-gallery])").magnificPopup({
        type:'image',
        image: {
            verticalFit: true
        },
    });

    $("a[href*='youtube.']").magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});