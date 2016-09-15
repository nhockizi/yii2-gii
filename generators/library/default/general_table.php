'use strict';
var generalIndex = {
    view: function viewUpdate(modelId, url) {
        location.href = url + '/' + modelId;
    },
    delete: function _delete(modelId, url, modalDel) {
        blockUI();
        return $.ajax({
            url: url,
            data: { id: modelId },
            type: "POST",
            success: function success() {
                modalDel.modal("hide");
                $.unblockUI();
            }
        });
    },
    modal: function modal(modelId, url, modalDel,message) {
        blockUI();
        $.ajax({
            url: url,
            data: { id: modelId,message:message },
            type: "POST",
            success: function success(result) {
                modalDel.find(".modal-content").html(result);
                modalDel.modal();
                $.unblockUI();
            }
        });
    }
};
$.fn.dataTable.pipeline = function (opts) {
    var conf = $.extend({
        pages: 5,
        url: '',
        data: null,
        table_id: null,
        method: 'POST'
    }, opts);
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
    var table_id = conf.table_id+'_wrapper';
    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;

        if (settings.clearCache) {
            ajax = true;
            settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            ajax = true;
        } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) || JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) || JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)) {
            ajax = true;
        }
        cacheLastRequest = $.extend(true, {}, request);

        if (ajax) {
            if (requestStart < cacheLower) {
                requestStart = requestStart - requestLength * (conf.pages - 1);

                if (requestStart < 0) {
                    requestStart = 0;
                }
            }

            cacheLower = requestStart;
            cacheUpper = requestStart + requestLength * conf.pages;

            request.start = requestStart;
            request.length = requestLength * conf.pages;

            request.data = $(table_id+" #data_search_table").val();
            if ($.isFunction(conf.data)) {
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            } else if ($.isPlainObject(conf.data)) {
                $.extend(request, conf.data);
            }

            settings.jqXHR = $.ajax({
                "type": conf.method,
                "url": conf.url,
                "data": request,
                "dataType": "json",
                "cache": false,
                "success": function success(json) {
                    cacheLastJson = $.extend(true, {}, json);

                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            });
        } else {
            var json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw;
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);

            drawCallback(json);
        }
    };
};
$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});