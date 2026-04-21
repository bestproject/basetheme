jQuery(()=>{

    window.dataLayer = window.dataLayer || [];

    const elements = document.querySelectorAll('.wpcf7');

    elements.forEach(function (element) {
        element.addEventListener('wpcf7mailsent', function (event) {
            dataLayer.push({'event': 'wpcf7mailsent'});
        }, false);
        element.addEventListener('wpcf7mailfailed', function (event) {
            dataLayer.push({'event': 'wpcf7mailfailed'});
        }, false);
        element.addEventListener('wpcf7spam', function (event) {
            dataLayer.push({'event': 'wpcf7spam'});
        }, false);
    });
})
