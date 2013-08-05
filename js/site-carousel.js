jQuery(function($) {
    $('#carousel').carouFredSel({
        width: '100%',
        items: {
            visible: 3
        },
        auto: {
            play: false
        },
        scroll: {
            items: 1,
            duration: 1000,
            timeoutDuration: 3000
        }
    },{
        onWindowResize: 'throttle'
    });

    $('#pager-carousel').carouFredSel({
        width: '100%',
        synchronise: '#carousel',
        //synchronise: ['#carousel', true, true, 0],
        /*items: {
            visible: $('#pager-carousel img').size() - 1
        },*/
        auto: {
            play: false
        },
        scroll: {
            items: 1,
            duration: 1000,
            timeoutDuration: 3000
        },
        prev: '.mini-carousel .prev',
        next: '.mini-carousel .next'
    },{
        onWindowResize: 'throttle'
    });
});