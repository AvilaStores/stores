var esReport = (function($){
    var tabs = {};

    var tabsLoadFlag = {};

    var currentTabId = '';

    var loadingMask = 0;

    var config = {
        defaultTab: 'report_subscription'
    };

    var init = function() {
        reloadReport(config.defaultTab);
        initEvents();
    };

    var initEvents = function() {
        //on tab click
        $('.tabs li a').click(function(){
            var tabId = $(this).attr('name');
            if (!tabsLoadFlag[tabId]) {
                reloadReport(tabId);
            }
            currentTabId = tabId;
        });
    };

    var addTab = function(tabId, options) {
        tabs[tabId] = options;
    };

    var reloadCurrentReport = function() {
        reloadReport(currentTabId);
        tabsLoadFlag = {};
    };

    var reloadReport = function(tabId) {
        if (tabId == '' || !tabs[tabId]) {
            return;
        }
        currentTabId = tabId;
        tabsLoadFlag[tabId] = 1;

        var reports = tabs[tabId];
        if (reports.chart) {
            for (var i = 0; i < reports.chart.length; ++i) {
                loadChart(
                    reports.chart[i].requestUrl,
                    reports.chart[i].containerId,
                    reports.chart[i].errorContainerId,
                    reports.storeId
                );
            }
        }

        if (reports.table) {
            for (var j = 0; j < reports.table.length; ++j) {
                loadTable(
                    reports.table[j].requestUrl,
                    reports.table[j].containerId,
                    reports.storeId
                );
            }
        }

    };

    var loadChart = function(requestUrl, chartContainerId, errorContainerId, storeId) {
        showLoadingMask();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: requestUrl,
            data: {
                storeId: storeId,
                form_key: window.FORM_KEY,
                dateFrom: $('#'+esReportDate.getConfig('dateFrom')).val(),
                dateTo: $('#'+esReportDate.getConfig('dateTo')).val()
            },
            success: function(data) {

                if (data.ajaxExpired) {
                    goToLoginPage();
                }

                $('#'+chartContainerId+' canvas').remove();
                $('#'+errorContainerId).hide();
                if (!data.error) {
                    $.each(data, function(index, element) {
                        $('#'+chartContainerId).html('<canvas></canvas><div class="legend"></div>').show();
                        var ctx = $('#'+chartContainerId+' canvas').get(0).getContext("2d");
                        ctx.canvas.width = $('#es_report_content').width()-60;
                        ctx.canvas.height = 300;
                        var lineChart = new Chart(ctx).Line(element.chartData, element.chartOptions);
                        var legend = lineChart.generateLegend();
                        $('#'+chartContainerId+' .legend').append(legend);
                    });
                } else {
                    $('#'+chartContainerId).hide();
                    $('#'+errorContainerId).html(data.error).show();
                }
                hideLoadingMask();
            }
        });
    };

    var loadTable = function(requestUrl, containerId, storeId) {
        showLoadingMask();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: requestUrl,
            data: {
                storeId: storeId,
                form_key: window.FORM_KEY,
                dateFrom: $('#'+esReportDate.getConfig('dateFrom')).val(),
                dateTo: $('#'+esReportDate.getConfig('dateTo')).val()
            },
            success: function(data) {
                if (data.ajaxExpired) {
                    goToLoginPage();
                }
                if (data.content) {
                    $('#'+containerId).html(data.content);
                }
                hideLoadingMask();
            }
        });
    };
    goToLoginPage = function(){
        location.reload();
    };

    var showLoadingMask = function() {
        $('#loading-mask').show();
        loadingMask++;
    };

    var hideLoadingMask = function() {
        loadingMask--;
        if (loadingMask == 0) {
            $('#loading-mask').hide();
        }
    };

    return {
        init: init,
        addTab : addTab,
        reloadCurrentReport : reloadCurrentReport
    };
})(jQuery);


var esReportDate = (function($) {
    var config = {};
    var top = false;
    var toolTipFix = 0;
    var getConfig = function(key) {
        return config[key];
    };

    var init = function(options) {
        config = {
            dateFormat: '',
            datePeriod: 'es_report_date_period',
            dateFrom: 'es_report_date_from',
            dateTo: 'es_report_date_to'
        };
        $.extend(config, options);
        setup();
    };

    var setup = function() {
        $('.content-header-floating .es-report-date-select').html('');
        reloadCalender();
        updateDate();
        dateEvent();
        toolTip();

        $(document).scroll(function() {
            $('.calendar:visible').css('display', 'none');
            toggleFieldPosition();
        });
    };

    var dateEvent = function() {
        $('#'+config.datePeriod).change(function() {
            updateDate();
        });
    };

    var toggleFieldPosition = function() {
        var floatingVisible = $('.content-header-floating').is(':visible');
        if(floatingVisible && !top) {
            top = true;
            var tmpDateFrom = $('#report-head .es-report-date-select #'+config.dateFrom).val();
            var tmpDateTo = $('#report-head .es-report-date-select #'+config.dateTo).val();
            var tmpDatePeriod = $('#report-head .es-report-date-select #'+config.datePeriod).val();
            $('.content-header-floating .es-report-date-select').html($('#report-head .es-report-date-select').html());
            $('.content-header-floating .es-report-date-select #'+config.dateFrom).val(tmpDateFrom);
            $('.content-header-floating .es-report-date-select #'+config.dateTo).val(tmpDateTo);
            $('.content-header-floating .es-report-date-select #'+config.datePeriod).val(tmpDatePeriod);
            $('#report-head .es-report-date-select').html('');
            dateEvent();
            reloadCalender();
        } else if(!floatingVisible && top) {
            top = false;
            var tmpDateFrom = $('.content-header-floating .es-report-date-select #'+config.dateFrom).val();
            var tmpDateTo = $('.content-header-floating .es-report-date-select #'+config.dateTo).val();
            var tmpDatePeriod = $('.content-header-floating .es-report-date-select #'+config.datePeriod).val();
            $('#report-head .es-report-date-select').html($('.content-header-floating .es-report-date-select').html());
            $('#report-head .es-report-date-select #'+config.dateFrom).val(tmpDateFrom);
            $('#report-head .es-report-date-select #'+config.dateTo).val(tmpDateTo);
            $('#report-head .es-report-date-select #'+config.datePeriod).val(tmpDatePeriod);
            $('.content-header-floating .es-report-date-select').html('');
            dateEvent();
            reloadCalender();
        }
    };

    var updateDate = function() {
        var datePeriod = $('#'+config.datePeriod).val();
        if (datePeriod != '') {
            var period = datePeriod.split('|');
            $('#'+config.dateFrom).val(new Date(period[0]).print(config.dateFormat));
            $('#'+config.dateTo).val(new Date(period[1]).print(config.dateFormat));
        }
    };

    var reloadCalender = function() {
        Calendar.setup({
            inputField: config.dateTo,
            ifFormat: config.dateFormat,
            showsTime: false,
            button: "es_report_to_trig",
            align: "Bl",
            singleClick : true
        });

        Calendar.setup({
            inputField: config.dateFrom,
            ifFormat: config.dateFormat,
            showsTime: false,
            button: "es_report_from_trig",
            align: "Bl",
            singleClick : true
        });

        $('.content-header-floating #es_report_to_trig, .content-header-floating #es_report_from_trig').click(function() {
            $('.calendar:visible').css('top', ($(document).scrollTop()+30)+'px');
        });
    };

    var toolTip = function() {
        if ($('.content-header-floating').is(':visible')) {
            toolTipFix = -1;
            toggleFieldPosition();
        } else {
            if (toolTipFix >= 0  && toolTipFix <= 10) {
                setTimeout(function(){
                    esReportDate.toolTip();
                }, 100);
                toolTipFix++;
            }
        }
    };

    return {
        init: init,
        getConfig: getConfig,
        toolTip: toolTip
    };
})(jQuery);

jQuery.noConflict();