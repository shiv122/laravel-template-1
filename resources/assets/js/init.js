const isRtl = $("html").attr("data-textdirection") === "rtl";

function snb(type, head, text) {
    toastr[type](text, head, {
        closeButton: true,
        tapToDismiss: false,
        showMethod: "slideDown",
        hideMethod: "slideUp",
        timeOut: 2000,
        rtl: isRtl,
        progressBar: true,
    });
}
"use strict";
function initTable({ tableName = '.datatables-basic', sortBy = 0, heading = '' }) {


    var dt_basic_table = $(tableName),

        assetPath = "app-assets/";



    // DataTable with buttons
    // --------------------------------------------------------------------

    if (dt_basic_table.length) {
        var dt_basic = dt_basic_table.DataTable({
            order: [
                [sortBy, "desc"]
            ],
            scrollX: true,
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-right"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                extend: "collection",
                className: "btn btn-outline-secondary dropdown-toggle mr-2",
                text: feather.icons["share"].toSvg({
                    class: "font-small-4 mr-50"
                }) +
                    "Export",
                buttons: [{
                    extend: "csv",
                    text: feather.icons["file-text"].toSvg({
                        class: "font-small-4 mr-50",
                    }) + "Csv",
                    className: "dropdown-item",
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: "excel",
                    text: feather.icons["file"].toSvg({
                        class: "font-small-4 mr-50"
                    }) +
                        "Excel",
                    className: "dropdown-item",
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                {
                    extend: "copy",
                    text: feather.icons["copy"].toSvg({
                        class: "font-small-4 mr-50"
                    }) +
                        "Copy",
                    className: "dropdown-item",
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                },
                ],
                init: function (api, node, config) {
                    $(node).removeClass("btn-secondary");
                    $(node).parent().removeClass("btn-group");
                    setTimeout(function () {
                        $(node)
                            .closest(".dt-buttons")
                            .removeClass("btn-group")
                            .addClass("d-inline-flex");
                    }, 50);
                },
            },],


            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        });
        $("div.head-label").html(
            '<div class="">' + heading + '</div>'
        );
    }

    // Flat Date picker



}

function setTheme(data) {
    const theme = $(data).children().attr('class');
    const type = theme.split(" ");
    const exp = (d => d.setFullYear(d.getFullYear() + 1))(new Date)
    document.cookie = (type[1] === 'feather-moon') ? 'theme=dark; expires=Thu, 01 Jan 2026 00:00:00 UTC' : 'theme=light; expires=Thu, 01 Jan 2026 00:00:00 UTC';
}

function initEditor({ editor = null }) {
    if ($('#' + editor) !== 'null') {
        new Quill('#' + editor + ' .editor', {
            bounds: '#' + editor + ' .editor',
            modules: {
                formula: true,
                syntax: true,
                toolbar: [
                    [
                        {
                            font: []
                        },
                        {
                            size: []
                        }
                    ],
                    ['bold', 'italic', 'underline', 'strike'],
                    [
                        {
                            color: []
                        },
                        {
                            background: []
                        }
                    ],
                    [
                        {
                            script: 'super'
                        },
                        {
                            script: 'sub'
                        }
                    ],
                    [
                        {
                            header: '1'
                        },
                        {
                            header: '2'
                        },
                        'blockquote',
                        'code-block'
                    ],
                    [
                        {
                            list: 'ordered'
                        },
                        {
                            list: 'bullet'
                        },
                        {
                            indent: '-1'
                        },
                        {
                            indent: '+1'
                        }
                    ],
                    [
                        'direction',
                        {
                            align: []
                        }
                    ],
                    ['link', 'image', 'video', 'formula'],
                    ['clean']
                ]
            },
            theme: 'snow'
        })
    }
}

function initYtable({ selector = '.y-datatable', loadingText = 'Loading...', url = null, col = [] }) {

    var columns = [];
    if (!col.length) { alert('No columns defined'); return false; }
    col.forEach(el => {
        columns.push({
            data: el,
            name: el
        });
    });
    if (url == null) {
        alert('url is null');
        return false;
    }
    var table = $(selector).DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        pagingType: $(window).width() < 768 ? "numbers" : "simple_numbers",
        "language": {
            processing: loadingText
        },
        ajax: url,
        columns: columns
    });
}
function rebound({ selector = null, data = null, to = null, refresh = null, redirect = null, block = '#card', status = null, msg = null, method = "POST" }) {
    if (to == null) { return 'Please set the target' } else if (selector == null && data == null) { return 'Please set the selector or data' }
    blockDiv(block);
    loadBtn('#sub-btn');
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });


    if (selector !== null) {
        var form = $(selector)[0];
        var formData = new FormData(form);
    }
    if (data !== null) {
        var formData = data;

    }
    // console.log(formData);
    $.ajax({
        type: method,
        url: to,
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            console.log(response);
            unblockDiv(block);
            initBtn('#sub-btn');
            if (response.msg == 'success' || response.status == 'success') {
                $(".custom-file-label").html('Choose file');
                $(selector).trigger("reset");
                snb('success', (response.header !== null) ? response.header : 'Added', (response.msg !== null) ? response.msg : 'Added Succesfullly');
                (refresh == null) ? '' : setTimeout(function () { location.reload() }, refresh * 1000);
                (redirect == null) ? '' : window.location.href = redirect;
            } else {
                snb('error', 'Error', 'Somthing Went Wrong');
            }

        },
        error: function (response) {
            unblockDiv(block);
            initBtn('#sub-btn');
            snb('error', 'Error', 'Somthing Went Wrong');
            console.log(response.responseText);

        },
    });
}