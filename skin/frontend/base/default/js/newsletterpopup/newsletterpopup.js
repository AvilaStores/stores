var newsletterPopupConfig = {};

(function($) {

    var newsletterPopup = function() {

        var config = {};

        var processingFlag = false;

        var buttonText = '';

        var init = function() {
            config = {
                openSelector: '#esnp_button',
                formSelector: '#esns_box_subscribe_form',
                emailFieldSelector: '#esns_email',
                submitButtonSelector: '#esns_submit',
                errorContainerSelector: '#esns_box_subscribe_response_error',
                successContainerSelector: '#esns_box_subscribe_response_success',
                autoStart:  true,
                delayTime:  0,
                cookieLifeTime: 365,
                cookieName: 'es_newssubscriber',
                baseUrl: '',
                autoPosition: true,
                translate: {
                    'wait': 'Wait...'
                },
                layerClose: true
            };
            $.extend(config, newsletterPopupConfig );

            cookie.setLifeTime(config.cookieLifeTime);
            popup.init(config);
            triggerButton.init(config);
            setup();
        };

        var setup = function() {
            setupPopup();
            setupFormSubmit();

            $(config.openSelector).click(function(){
                popup.open();
                cookie.setCookie(config.cookieName, 1);
            });

            //press enter and submit
           $(config.emailFieldSelector).keypress(function (e) {
                if (e.which == 13) {
                    $(config.submitButtonSelector).trigger('click');
                    return false;
                }
            });
        };

        var setupPopup = function() {

            //popup delay
            setTimeout(function() {
                if (cookie.getCookie(config.cookieName) != 1) {
                    cookie.setCookie(config.cookieName, 1);
                    if (config.autoStart) {
                        popup.open();
                    }
                }
            }, config.delayTime);
        };

        var setupFormSubmit = function() {
            var emailField = $(config.emailFieldSelector);
            var submitButton = $(config.submitButtonSelector);

            submitButton.click(function(e){
                if (!startProcess()) {
                    return;
                }
                showLoading();

                var data = {
                    'email': emailField.val()
                };

                $('.esns-additional-field').each(function() {
                    var name = $(this).attr('name');
                    data[name] = $(this).val();
                });

                $.post(config.baseUrl+'newsletter/subscriber/newajax/', data, function(resp) {
                    if (resp.errorMsg) {
                        $(config.errorContainerSelector).html(resp.errorMsg);
                    } else {
                        $(config.errorContainerSelector).html('');
                        $(config.formSelector).css('display','none');
                        $(config.successContainerSelector).html(resp.successMsg).css('display','block');

                        setTimeout(function() {
                            popup.close();
                        }, 5000);
                        setTimeout(function() {
                            triggerButton.hide();
                            cookie.setCookie(config.cookieName + '_button', 1);
                        }, 5000);
                    }
                    hideLoading();
                    endProcess();
                });
            });
        };

        var startProcess = function() {
            if (processingFlag == true)
                return false;
            processingFlag = true;
            return true;
        };

        var endProcess = function() {
            processingFlag = false;
        };

        var showLoading = function() {
            if (buttonText == '') {
                buttonText =  $(config.submitButtonSelector).text();
            }
            $(config.submitButtonSelector).text(config.translate.wait);
        };

        var hideLoading = function() {
            $(config.submitButtonSelector).text(buttonText);
        };

        return {
            init: init
        };
    }();



    var popup = (function() {
        var isOpen = false;

        var bgLayer = null;

        var popupBox = null;

        var lastTopPosition = 0;

        var config = {};

        var init = function(settings) {
            config = {
                openSelector:           '#esnp_button',
                closeSelector:          '#esns_box_close',
                backgroundSelector:     '#esns_background_layer',
                boxSelector:            '#esns_box_layer',
                layerClose:             true,
                autoPosition:           true
            };
            $.extend(config, settings );

            setup();
        };

        var setup = function() {

            bgLayer = $(config.backgroundSelector);
            popupBox = $(config.boxSelector);

            if (config.autoPosition) {
                $(document).scroll(function() {
                    eventScroll();
                });

                $(window).resize(function() {
                    eventResize();
                });
            }

            $(config.closeSelector).click(function(){
                close();
            });

            if (config.layerClose) {
                $(config.backgroundSelector).click(function(e) {
                    if ('#'+e.target.id == config.backgroundSelector) {
                        close();
                    }
                });
            }
        };

        var open = function() {
            if(!isOpen) {
                bgLayer.fadeIn();
                bgLayer.css('height', $(document).height()+'px');
                popupBox.css('margin-top', getTopPosition()+'px');
                isOpen = true;
            }
        };

        var close = function() {
            if (isOpen) {
                bgLayer.fadeOut();
                isOpen = false;
            }
        };

        var getTopPosition = function() {
            var scrollTop = jQuery(document).scrollTop();
            var windowH = jQuery(window).height();
            var boxH = popupBox.height();
            var boxTop = 0;
            if (windowH <= boxH) {
                boxTop = scrollTop;
            } else {
                boxTop = scrollTop + ((windowH - boxH ) /2);
            }
            return boxTop;
        };

        var eventScroll = function()
        {
            var windowH = $(window).height();
            var boxH = popupBox.height();
            var scrollTop = $(document).scrollTop();
            var diff = Math.abs(lastTopPosition - scrollTop);
            if (windowH <= boxH) {
                return;
            }

            if (diff > 150
                || scrollTop == 0
                || scrollTop + $(window).height() == $(document).height()
            ) {
                lastTopPosition = scrollTop;
                popupBox.css('margin-top', getTopPosition()+'px');
            }
        };

        var eventResize = function() {
            var windowH = $(window).height();
            var boxH = popupBox.height();
            if (windowH <= boxH) {
                return;
            }
            popupBox.css('margin-top', getTopPosition()+'px');
        };

        return {
            init:   init,
            open:   open,
            close:  close
        };
    })();

    var triggerButton = (function() {
        var config = {};

        var init = function(settings) {
            config = {
                buttonSelector: '#esnp_button',
                cookieName: 'es_newssubscriber'
            };

            $.extend(config, settings);
        };

        var hide = function() {
            $(config.buttonSelector).hide();
        };

        return {
            init: init,
            hide: hide
        };
    })();

    $(document).ready(function() {
        newsletterPopup.init();
    });

    var cookie = (function() {
        var lifeTime = 0;

        var setLifeTime = function(days) {
            lifeTime = days;
        };

        var setCookie = function(key, value) {
            var date = new Date();
            date.setTime(date.getTime()+(lifeTime*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
            document.cookie = escape(key)+"="+escape(value)+expires+"; path=/";
        };

        var getCookie = function(key) {
            var nameEQ = escape(key) + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length,c.length));
            }
            return null;
        };

        return {
            setLifeTime: setLifeTime,
            getCookie: getCookie,
            setCookie: setCookie
        };

    })();

})(jQuery);
jQuery.noConflict();