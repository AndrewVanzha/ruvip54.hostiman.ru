/* MODAL */
var modal = ({
    closeAllModals: function closeAllModals() {
        // console.log('close them all');
        document.querySelectorAll('[class*="js-v21-modal"], .js-v21-overlay').forEach(function (item) {
            item.classList.remove('is-active');
            document.documentElement.style.overflow = 'unset';
        });
    },

    toggleModal: function toggleModal(id) {
        var modal = document.getElementById(id);
        if (!modal) return;
        var isActive = modal.classList.contains('is-active');
        this.closeAllModals();
        if (!isActive) {
            document.querySelectorAll(".js-v21-modal-toggle[href=\"#".concat(id, "\"]")).forEach(function (toggle) {
                toggle.classList.add('is-active');
            });
            modal.classList.add('is-active');
            var overlay = document.getElementById(modal.dataset.overlay);
            if (modal.dataset.overlay && overlay) {
                overlay.classList.add('is-active');
                document.documentElement.style.overflow = 'hidden';
            }
        }
    },

    init: function init() {

        var _this = this;
        document.querySelectorAll('.js-v21-modal-toggle').forEach(function (toggle) {
            console.log('toggle');
            console.log(toggle);
            toggle.addEventListener('click', function (e) {

                e.preventDefault();
                console.log("toggle.getAttribute('href')");
                console.log(toggle.getAttribute('href'));
                console.log(toggle.getAttribute('href').substr(1));

                //console.log(toggle);
                //console.log(toggle.parentElement);
                //console.log(toggle.parentElement.parentElement);
                //console.log(toggle.parentElement.parentElement.classList);
                //toggle.parentElement.parentElement.classList.remove('.is-active');
                _this.toggleModal(toggle.getAttribute('href').substr(1));
            });
        });
        document.addEventListener('click', function (e) {
            if (!e.target.closest('[class*="js-v21-modal-"], [class*="qs"]')) {
                _this.closeAllModals();
            }
        });
        window.addEventListener('keyup', function (e) {
            if (e.key === 'Escape') _this.closeAllModals();
        });

        console.log('modal.init');

    }
});

/* DROPDOWN */
var dropdown = ({
    slideDown: function slideDown(item, duration, callback) {
        var target = document.querySelector(item);
        if (!target) return;
        target.style.display = 'block';
        target.style.height = 'auto';
        var targetHeight = target.offsetHeight;
        target.style.height = 0;
        target.style.overflow = 'hidden';
        gsap["a"].to(target, {
            duration: duration,
            height: "".concat(targetHeight, "px"),
            onComplete: function onComplete() {
                target.style.height = 'auto';
                target.style.overflow = '';
                if (callback) {
                    callback();
                }
            }
        });
    },

    slideUp: function slideUp(item, duration, callback) {
        var target = document.querySelector(item);
        if (!target) return;
        target.style.overflow = 'hidden';
        gsap["a"].to(target, {
            duration: duration,
            height: 0,
            onComplete: function onComplete() {
                target.style.display = 'none';
                target.style.height = 'auto';
                target.style.overflow = '';
                if (callback) {
                    callback();
                }
            }
        });
    },

    init: function init() {
        var _this = this;
        document.querySelectorAll('.js-v21-dropdown-toggle').forEach(function (toggle) {
            var duration = 0.36;
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                var active = toggle.classList.contains('is-active');
                var href = toggle.getAttribute('href');
                var target = document.querySelector(href);
                if (!target) return;
                if (toggle.dataset.dropdownGroup) {
                    document.querySelectorAll("[data-dropdown-group=\"".concat(toggle.dataset.dropdownGroup, "\"]")).forEach(function (item) {
                        if (item !== toggle) {
                            var newTarget = document.querySelector(item.getAttribute('href'));
                            if (newTarget) {
                                _this.slideUp(item.getAttribute('href'), duration);
                                newTarget.classList.remove('is-active');
                            }
                            item.classList.remove('is-active');
                        }
                    });
                }
                if (active) {
                    _this.slideUp(toggle.getAttribute('href'), duration);
                    target.classList.remove('is-active');
                } else {
                    _this.slideDown(toggle.getAttribute('href'), duration);
                    target.classList.add('is-active');
                }
                if (toggle.dataset.scrollAnchor) {
                    var offset = toggle.closest(toggle.dataset.scrollAnchor).getBoundingClientRect().top + window.scrollY - document.querySelector('.js-v21-header').offsetHeight + 1;
                    gsap["a"].to(window, {
                        duration: 0.3,
                        scrollTo: offset
                    });
                }
                document.querySelectorAll(".js-v21-dropdown-toggle[href='".concat(href, "']")).forEach(function (item) {
                    if (active) {
                        item.classList.remove('is-active');
                    } else {
                        item.classList.add('is-active');
                    }
                });
            });
        });
        console.log('dropdown.init');
    }
});

/* TABS */
/*----------------------------------------*/
var js_tabs = ({
    showTab: function showTab(tabId) {
        console.log('tab');
        console.log("[data-tab-id='".concat(tabId, "']"));
        var tab = document.querySelector("[data-tab-id='".concat(tabId, "']"));
        console.log(tab);
        var tabs = tab.closest('.js-v21-tabs');
        if (!tab || !tabs) return;
        tabs.querySelectorAll('[data-tab-id]').forEach(function (item) {
            if (item.dataset.tabId.indexOf(tabId) + 1) {
                item.classList.add('is-active');
            } else {
                item.classList.remove('is-active');
            }
        });
        if (tabs.dataset.tabAnchor) {
            var offset = tabs.getBoundingClientRect().top + window.scrollY - document.querySelector('.js-v21-header').offsetHeight + 1;
            gsap["a"].to(window, {
                duration: 0.3,
                scrollTo: offset
            });
        }
    },

    showComboTab: function showComboTab(tabId, tabGroup) {
        var tab = document.querySelector("[data-tab-id='".concat(tabId, "']"));
        var tabs = tab.closest('.js-v21-tabs');
        if (!tab || !tabs) return;
        var tabQuery = [];
        tabs.querySelectorAll(".js-v21-tabs-toggle[data-tab-group='".concat(tabGroup, "']")).forEach(function (toggle) {
            if (toggle.dataset.tabId === tabId) {
                toggle.classList.add('is-active');
            } else {
                toggle.classList.remove('is-active');
            }
        });
        tabs.querySelectorAll('.js-v21-tabs-toggle.is-active').forEach(function (toggle) {
            tabQuery.push(toggle.dataset.tabId);
        });
        tabQuery = tabQuery.sort().join(' ');
        tabs.querySelectorAll('.js-v21-tabs-content').forEach(function (item) {
            if (item.dataset.tabId.split(' ').sort().join(' ') === tabQuery) {
                item.classList.add('is-active');
            } else {
                item.classList.remove('is-active');
            }
        });
    },

    init: function init() {
        var _this = this;
        document.querySelectorAll('.js-v21-tabs').forEach(function (tabs) {
            tabs.querySelectorAll('.js-v21-tabs-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (toggle.dataset.tabGroup) {
                        _this.showComboTab(toggle.dataset.tabId, toggle.dataset.tabGroup);
                    } else {
                        _this.showTab(toggle.dataset.tabId);
                    }
                });
            });
            tabs.querySelectorAll('.js-v21-tabs-selector').forEach(function (selector) {
                selector.addEventListener('change', function () {
                    _this.showTab(selector.value);
                });
            });
        });

        //var iii = document.querySelectorAll('#v21_plasticOrder2 ');
        //var iii = document.querySelectorAll('.js-v21-tabs ');
        //console.log(iii);
        document.querySelectorAll('.v21-grid__item .v21-input-group').forEach(function (done) {
            //console.log('done');
            //console.log(done);
        });
        console.log('js_tabs.init');
    }
});

/*----------------------------------------*/
/* CALC INIT */
/*----------------------------------------*/
var calcElement = document.querySelector('#v21_exCalc');
console.log('CALC INIT');
console.log(calcElement);
var calcUrl = calcElement ? calcElement.dataset.url : false;
//console.log(calcUrl);
if (calcElement) {
    console.log('monetaryRate');
    console.log(monetaryRate);
    exchangeCalcInit(calcElement, monetaryRate);
    calcElement.classList.add('is-active');
}

// EXTERNAL MODULE: ./node_modules/tiny-slider/src/tiny-slider.js + 41 modules
//var src_tiny_slider = __webpack_require__(3);

// EXTERNAL MODULE: ./node_modules/inputmask/dist/inputmask.js
//var inputmask = __webpack_require__(4);
//var inputmask_default = /*#__PURE__*/__webpack_require__.n(inputmask);

// EXTERNAL MODULE: ./node_modules/js-datepicker/dist/datepicker.min.js
//var dist_datepicker_min = __webpack_require__(5);
//var dist_datepicker_min_default = /*#__PURE__*/__webpack_require__.n(dist_datepicker_min);

// EXTERNAL MODULE: ./node_modules/choices.js/public/assets/scripts/choices.js
//var scripts_choices = __webpack_require__(1);
//var choices_default = /*#__PURE__*/__webpack_require__.n(scripts_choices);

// EXTERNAL MODULE: ./node_modules/nouislider/dist/nouislider.js
//var dist_nouislider = __webpack_require__(6);
//var dist_nouislider_default = /*#__PURE__*/__webpack_require__.n(dist_nouislider);

// EXTERNAL MODULE: ./node_modules/wnumb/wNumb.js
//var wNumb = __webpack_require__(2);
//var wNumb_default = /*#__PURE__*/__webpack_require__.n(wNumb);

// inits
window.onload = function() {
    modal.init();
    dropdown.init();
    js_tabs.init();
};

// exports
var tsb21 = {
    //tns: src_tiny_slider["a"],
    //inputmask: inputmask_default.a,
    //datepicker: dist_datepicker_min_default.a,
    //choices: choices_default.a,
    cardchoice: '',
    cardname: '',
    //noUiSlider: dist_nouislider_default.a,
    //wNumb: wNumb_default.a,
    modal: modal,
    dropdown: dropdown,
    tabs: js_tabs
};
