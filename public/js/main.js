

$(document).ready(function () {
    var windowW;
    var searchBoxOnTop = false;
    var lastScrollTop = 0;
    var detectMobResult = detectMob();
    var header = $('.header');
    var vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    $(window).resize(function () {
        windowW = $(window).width();
        vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        if (windowW >= 992) {
            $('#js-menu-btn').removeClass('open');
            $('#js-menu').removeAttr('style');
            $('.rating-dropdown').removeAttr('style');
            if ($('#review-form-wrapper').length > 0) {
                $('#review-form-wrapper').addClass('in').attr('aria-expanded', true);
            }
        } else {
            if ($('#review-form-wrapper').length > 0) {
                $('#review-form-wrapper').removeClass('in').attr('aria-expanded', false);
            }
        }
        if (windowW >= 481) {
            if ($('#details-list-wrapper').length > 0) {
                $('#details-list-wrapper').addClass('in').attr('aria-expanded', true);
            }
        } else {
            if ($('#details-list-wrapper').length > 0) {
                $('#details-list-wrapper').removeClass('in').attr('aria-expanded', false);
            }
        }
        if (windowW < 576) {
            const roomAttributes = $('.room-card-attributes');
            roomAttributes.each(function () {
                const roomType = $(this).closest('.room-card-content').find('.room-card-type').text();
                if (!roomType) {
                    $(this).closest('.room-card-content').find('.room-card-header').hide();
                    $(this).addClass('mr');
                }
            })
        } else {
            $('.room-card-header').show()
            $('.room-card-attributes').removeClass('mr');
        }
        if(windowW > 520) {
            $('.js-search-collapse').removeAttr('style')
        }

    });
    $(window).trigger('resize');
    if (detectMobResult) {
        $('.form-control-time').removeClass('js-time').attr('type', 'time');
    }
    //scroll search
    if ($('#js-search').length > 0) {
        var search = $('#js-search');
        var searchWrapper = $('#js-search-wrapper');
        var searchTop = header.height() + 4;
        var searchHeight = search.height();
        if (!detectMobResult) {
            $(window).resize(function () {
                searchTop = header.height() + 4;
                searchHeight = search.height();
            });
            $(window).trigger('resize');
        } else {
            $(window).on('orientationchange', function () {
                searchTop = header.height() + 4;
                searchHeight = search.height();
            });
        }
        $(window).scroll(function () {
            fixSearch(search);
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                search.removeClass('bottom');
            } else {
                if (!searchBoxOnTop) {
                    search.addClass('bottom');
                }
            }
            lastScrollTop = st;
        });
    }

    function fixSearch(search) {
        if ($(window).scrollTop() >= searchTop + searchHeight) {
            searchWrapper.css('padding-top', searchHeight);
            search.removeClass('prefixed');
            search.addClass('fixed');
            if (windowW <= 991) {
                search.addClass('show-advanced-btn');
            }
            searchBoxOnTop = false;
        } else if ($(window).scrollTop() >= searchTop && $(window).scrollTop() < searchTop + searchHeight) {
            search.addClass('prefixed');
        } else if ($(window).scrollTop() <= searchTop) {
            searchWrapper.css('padding-top', 0);
            search.removeClass('prefixed');
            search.removeClass('fixed');
            search.removeClass('bottom');
            search.removeClass('show-advanced-btn');
            searchBoxOnTop = true;
        }
    }

    //advanced-search
    $('#js-advanced-search-open-btn').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var isSearchOnTop = $('#js-search').hasClass('bottom') || $('#js-search').hasClass('show-advanced-btn') || $('#js-search').hasClass('prefixed');
        if (isSearchOnTop) {
            $('#js-advanced-search').addClass('fixed');
        } else {
            $('#js-advanced-search').removeClass('fixed');
        }
        $('#js-advanced-search').slideDown();
        $('#js-advanced-search-in').scrollTop(0);
        $('body').addClass('noscroll');
    });
    $('#js-advanced-search-close-btn').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('#js-advanced-search').slideUp();
        setTimeout(function () {
            $('#js-advanced-search').removeClass('fixed');
        }, 800)
        $('body').removeClass('noscroll');
    });

    const queryData = () => {
        const url = decodeURI(window.location.href);
        let urlArr = [];
        let query = [];
        let q = [];
        if(url.includes('?')) {
            urlArr = url.split('?');
            query = urlArr[1].split('&');
            query.shift();
            q = query.map(t => {
                const item = t.split('=');
                let obj = {};
                obj.name = item[0];
                obj.value = item[1];
                return obj;
            });
        }
        return {query:q, urlArray:urlArr};
    }

    let flagCost = true;
    function selectPricesColumns(elem) {

        let qArr = queryData().query;

        if (typeof elem !== 'boolean') {
            $(elem).removeClass('disabled');
            elem.querySelectorAll('input').forEach(input => {
                $(input).attr("disabled", false);
            });
        }
        advancedSearchPrices.forEach(item => {
            if (item !== elem) {
                $(item).addClass('disabled');
                item.querySelectorAll('input').forEach(input => {
                    $(input).attr('previousValue', false).prop('checked',false).attr("disabled", true);
                });
            } else {
                if(qArr.length > 0 && flagCost == true) {
                    for(const item of qArr) {
                        if(item['name'] === 'cost') {
                            const value = item['value']
                            $(item).find(`input[value="${value}"]`).attr('previousValue', true).prop('checked',true);
                            flagCost = false
                            continue;
                        }
                    }
                } else {
                    $(item).find('input').eq(0).attr('previousValue', true).prop('checked',true);
                }

            }
        });
    }

    const advancedSearchPrices = document.querySelectorAll('.advanced-search-prices-in-item');
    if (advancedSearchPrices.length > 0) {
        const advancedSearchPricesInputs = document.querySelectorAll('.advanced-search-prices-in-item input');
        const controls = document.querySelectorAll('.advanced-search-prices-control .advanced-search-prices-item');

        advancedSearchPrices.forEach((item, index) => {
            item.setAttribute('data-index', index)
        })

        controls.forEach((control, index) => {
            console.log(control)
            $(control).click(function () {
                if ($(control).find('input').is(":checked")) {
                    index = (index === 3) ? 2 : index;
                    selectPricesColumns(advancedSearchPrices[index]);
                } else {
                    selectPricesColumns(false);
                }

            });
        });
        advancedSearchPricesInputs.forEach(function (item) {
            $(item).click(function () {
                const name = $(this).attr('name');
                $("input[name=" + name + "]:radio").attr('previousValue', false);
                $(this).attr('previousValue', 'checked');
            });
        });
        const check = function (radio) {
            let index = 0
            radio.forEach(item => {
                if (item.checked === true) {
                    index = item.closest('.advanced-search-prices-in-item').getAttribute('data-index')
                    return index
                }
            })
            return index
        }

        const indexCol = check(advancedSearchPricesInputs) || false;

        if (indexCol === false) {
            selectPricesColumns(false);
        } else {
            $(controls[indexCol].querySelector('input')).attr('checked', true);
            selectPricesColumns(advancedSearchPrices[indexCol]);
        }

    }

    const collapse = function(e) {
        e.preventDefault()
        const btn = $(this)
        const item = btn.closest('.advanced-search-title').siblings('.js-search-collapse')
        btn.toggleClass('active')
        item.slideToggle('400')
    }

    $('.js-search-btn-collapse').on('click', collapse)

    //mobile menu
    $('#js-menu-btn').click(function (e) {
        e.preventDefault();
        $(this).toggleClass('open');
        $('#js-menu').slideToggle();
    });
    //sliders
    if ($('.js-hotel-card-slider').length > 0) {
        js_hotel_card_slider_init();
    }
    if ($('.product-slider-big').length > 0) {
        var galleryThumbs = new Swiper('.product-slider-small', {
            spaceBetween: 10,
            slidesPerView: 2,
            centeredSlides: false,
            loop: $('.product-slide-small').length > 4,
            roundLengths: true,
            watchOverflow: true,
            lazy: {
                loadPrevNext: false,
            },
            navigation: {
                nextEl: '.swiper-button.swiper-button-next.product-slider-small-button-next',
                prevEl: '.swiper-button.swiper-button-prev.product-slider-small-button-prev'
            },
            breakpoints: {
                361: {
                    spaceBetween: 10,
                    slidesPerView: 3
                },
                481: {
                    spaceBetween: 25,
                    slidesPerView: 4
                }
            }
        });
        $('.product-slide-small').click(function (e) {
            e.stopPropagation();

            let full = $(this).attr("data-full");

            $(".product-slide-big.swiper-slide-active").find("img").attr("src", full);

            if ($('.product-slide-small').length > 4) {
                const activeIndex = galleryThumbs.activeIndex;
                if ($(this).hasClass('swiper-slide-active')) {
                    galleryThumbs.slidePrev();
                }
                if (activeIndex + 3 === galleryThumbs.clickedIndex) {
                    galleryThumbs.slideNext();
                }
                galleryThumbs.update();
            }
        });
        var galleryTop = new Swiper('.product-slider-big', {
            loop: $('.product-slide-small').length > 4,
            roundLengths: true,
            lazy: true,
            allowSlideNext: false,
            allowSlidePrev: false,
            // thumbs: {
            //     swiper: galleryThumbs
            // }
        });
    }
    if($('.product-slider-big-mobile').length > 0) {
        const galleryTopMobile = new Swiper('.product-slider-big-mobile', {
            loop: true,
            lazy: true,
        });

        $('#details-list-wrapper-m').on('shown.bs.collapse', function () {
            galleryTopMobile.update()
        });
    }

    //changing name of more-btn
    if ($('.content-more').length > 0) {
        $('.content-more ').on('show.bs.collapse', function () {
            $(this).next('.content-more-btn').children('span').text('Свернуть');
        });
        $('.content-more ').on('hide.bs.collapse', function () {
            $(this).next('.content-more-btn').children('span').text('Развернуть');
        });
    }
    //masked input
    $('input[type="tel"]').mask('+7 (999) 999 99 99');
    $('.js-time').mask('99:99');

    //tables
    if ($('.text-section table').length > 0) {
        var tables = $('.text-section').find('table');
        tables.each(function () {
            $(this).wrapAll('<div class="table-wrapper">');
        });
    }
    //show tel number
    $('.js-show-tel-btn').click(function () {
        $(this).hide();
        $(this).next('.js-tel-link').addClass('visible');
    });
    //formstyler
    if ($('select').length > 0) {
        $('select').styler();
    }
    //rating
    $('.rating-title').click(function () {
        if (windowW <= 991) {
            $(this).next('.rating-dropdown').slideToggle();
        }
    });
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $('a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
        var top = $(e.target.hash).offset().top - 120;
        $('.nav-tabs li').removeClass('active');
        $('.nav-tabs a[href="' + e.target.hash + '"').closest('li').addClass('active');
        $('html, body').animate({scrollTop: top}, 300);
    });
    $('.js-room-address-link').click(function (e) {
        e.preventDefault();
        $('.nav-tabs a[href="#route"]').tab('show');
    })

    $('#search-load-more').click(async function (e) {
        await loadMore(e, '/public/render/search');
    });

    $('#map-load-more').click(async function (e) {
        await loadMore(e, '/public/render/search_map');
    });

    let hotelPageNumber = 1;
    $('#hotel-page-load-more').click(async function (e) {
        const hotelId = window.location.pathname.split('/')[2];
        hotelPageNumber++
        await loadMore(e, `/public/render/hotels/${hotelId}?page=${hotelPageNumber}`);
    });

    let roomPageCount = 1;
    $('#rooms-load-more').click(async function (e) {
        roomPageCount++
        await loadMore(e, `/public/render/rooms?page=${roomPageCount}`);
    });


    let hotelPageCount = 1;
    $('#hotels-load-more').click(async function (e) {
        hotelPageCount++
        await loadMore(e, `/public/render/hotels?page=${hotelPageCount}`);
    });


    $('#room-page-load-more').click(async function (e) {
        const roomId = 1;
        await loadMore(e, `/public/render/room/${roomId}`);
    });

    $('#review-show-more').click(async function (e) {
        const hotelId = 1;
        await loadMore(e, `/public/render/review/${hotelId}`);
    });

    function detectMob() {
        const toMatch = [
            /Android/i,
            /webOS/i,
            /iPhone/i,
            /iPad/i,
            /iPod/i,
            /BlackBerry/i,
            /Windows Phone/i
        ];
        return toMatch.some((toMatchItem) => {
            return navigator.userAgent.match(toMatchItem);
        });
    }

    //room-card-more
    $('.room-card-more').click(function () {
        const hotelName = $(this).closest('.room-card-content').find('.room-card-name');
        const hotelAddress = $(this).closest('.room-card-content').find('.room-card-address');
        const hotelMetro = $(this).closest('.room-card-content').find('.room-card-metro');
        $(this).hide();
        $(hotelName).show();
        $(hotelAddress).show();
        $(hotelMetro).addClass('open');
    });
    //datalist
    $('.flexdatalist').flexdatalist({
        noResultsText: '',
        minLength: 0
    })


});

function js_hotel_card_slider_init(){
    $('.js-hotel-card-slider').each(function () {
        var hotelCardSwiper = new Swiper(this, {
            navigation: {
                nextEl: this.querySelector('.swiper-button.swiper-button-next'),
                prevEl: this.querySelector('.swiper-button.swiper-button-prev')
            },
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            lazy: true,
            speed: 600,
            roundLengths: true,
            effect: 'fade'
        });
    });
}

let loading = false;

async function loadMore(e, url, callback = null) {
    if (loading) {
        return;
    }
    loading = true;
    const parent = e.target.closest('.show-more');
    const spinner = parent ? createSpinner(parent) : null;
    const result = await request(url, 'GET', spinner);
    if (result) {
        const html = await result.text();
        $('.items-container').append(html);
        updateCounter(html);
    }
    loading = false;
    js_hotel_card_slider_init()

}

function updateCounter(html) {
    const counter = $('.show-more-counter');
    const countTotal = Number(counter.html().match(/\((.*)\)/).pop())
    if (!counter) return;
    const requestCount = +getRequestItemsCount(html);
    const currCount = +counter.html().match(/(\d+)/i)[0].trim();
    const currNum = Number(currCount + requestCount)

    $(counter).text(counter.html().replace(/(\d+)/i, currCount + requestCount));

    if (currNum >= countTotal) {
        counter.closest('.show-more').find('.show-more-btn').remove()
    }
}


function getRequestItemsCount(html) {
    const data = document.createElement('div');
    $(data).append(html);
    const length = data.children.length;
    data.remove();
    return length;
}

function createSpinner(parent) {
    const spinnerWrapper = document.createElement('div');
    const spinner = document.createElement('div');
    spinnerWrapper.classList.add('spinner-wrapper');
    spinner.classList.add('spinner-border');
    spinnerWrapper.appendChild(spinner);
    parent.prepend(spinnerWrapper);
    return spinnerWrapper;
}

async function request(url, method, spinner) {
    try {
        const response = await fetch(url, {method});
        if (response.status !== 200) {
            throw new Error('Ошибка сервера');
        }
        return response;
    } catch (err) {
        
        return false;
    } finally {
        spinner ? spinner.remove() : null;
    }
}

function changeForm() {
    const element = document.getElementById('js-advanced-search');
    if ("createEvent" in document) {
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("change", false, true);
        element.dispatchEvent(evt);
    } else {
        element.fireEvent("onchange");
    }
}

function search_reset() {
    $("#js-advanced-search textarea, #js-advanced-search input[type='text']").val("");
    $("#js-advanced-search input, #js-advanced-search textarea").trigger("refresh");

    $(".advanced-search-details input[type='checkbox']").prop("checked", false);
    // $(".advanced-search-prices input[type='checkbox']").trigger("refresh");

    // Сброс данных цены
    let first_inputs = $('.advanced-search-prices-list').first()
    let checkedPeriod = $(first_inputs).find('input[type="checkbox"]:checked').first()
    let advanced_search = $(checkedPeriod).parent('.advanced-search-prices-item').get()
    $(advanced_search).find('label').click()
    $(advanced_search).click()

    $("#js-advanced-search select").prop("selectedIndex", 0);
    $("#js-advanced-search select").trigger("refresh");

    let form = document.getElementById('js-advanced-search');
    form.querySelectorAll('button[type=submit]')[0].innerText = 'Показать'

    // $("label[for='advanced-search-prices-1']").trigger("click");
}