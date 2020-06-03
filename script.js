// GA Event for form submissions
jQuery(document).on('nfFormReady', function () {
    nfRadio.channel('forms').on('submit:response', function (form) {
        gtag('event', 'Submit', {
            'event_category': 'Form',
            'event_label': form.data.settings.title
        });
        console.log(form.data.settings.title + ' successfully submitted');
    });
});

// GA Event for WhatsApp button click
jQuery('.wa-container a').click(function () {
    gtag('event', 'Click', {
        'event_category': 'Button',
        'event_label': 'WhatsApp'
    });
});

// GA Event for "Llamar" button click
jQuery('.cta a').click(function () {
    gtag('event', 'Click', {
        'event_category': 'Button',
        'event_label': 'Llamar'
    });
});

// GA Event for "Conozca nuestros proyectos" on home page
jQuery('#proyectos-home').click(function () {
    gtag('event', 'Click', {
        'event_category': 'Button',
        'event_label': 'Conozca nuestros proyectos'
    })
});



if ( document.referrer.indexOf(window.location.host) !== -1 ) {
    jQuery('#volver').click(function (event) {
        event.preventDefault();
        history.back();
    });
} else {
    jQuery('#volver').hide();
}