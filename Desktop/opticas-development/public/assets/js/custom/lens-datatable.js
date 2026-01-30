function lensDatatable(dt_basic_table)
{
        dt_basic = dt_basic_table.DataTable({
        ajax: {
            url: '/lens',
            dataSrc: ""
        },

        columns: [
            { data: 'id' },
            { data: 'optical_correction' },
            { data: 'material' },
            { data: 'type' },
            { data: 'color' },
            { data: 'correction_type' },
            { data: 'treatment' },
            { data: 'price' },
            { data: '', render: function (data, type, row){
                    let lensJson = JSON.stringify(row);

                    return location.pathname!=='/mostrador'? `
                                    <a href="javascript:void(0);" onclick='openLensModal(${lensJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editLens">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteLens(${lensJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                        <i class='mdi mdi-delete'></i>
                                    </a>
                                `:` 
                                    <a href="javascript:void(0);" data-lens = '${lensJson}' 
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon lens-add-btn'
                                        >
                                        <i class='mdi mdi-cart-arrow-down'></i>
                                    </a>`
                }
            },
        ],
        columnDefs: [
            {
                // For Responsive
                className: 'control',
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return '';
                }
            },
            {
                responsivePriority: 1,
                targets: [1,2,3,4,5,6,7,8],
                orderable: false,

            },
            {
                targets: 7,
                responsivePriority: 1,
                visible: true,
                render: function (data, type, full, meta) {
                    return '$'+data;
                }
            },

        ],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 10,
        lengthMenu: [10, 25, 50, 75, 100],
        buttons: [],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Detalles de la mica ';
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                            ? `
                                        <tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                            <td>${col.title} :</td>
                                            <td>${col.data}</td>
                                        </tr>`
                            : '';
                    }).join('');

                    return data ? $('<table class="table"/><tbody />').append(data) : false;
                }
            }
        },
        initComplete: function () {
            this.api()
                .columns()
                .every(function (catched) {
                    if(this[0][0]===7) {
                       $("table tbody").on("click",".lens-add-btn", addToCart)
                    }
                    if(this[0][0] === 0 || this[0][0] === 7 ){
                        return
                    }
                    var column = this;
                    var title = column.footer().textContent;

                    // Create input element and add event listener
                    $('<input type="text" placeholder="Filtrar ' + title + '" />')
                        .appendTo($(column.header()).empty())
                        .on('keyup change clear', function () {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });

                });
        },
    });
}
function filterColumn( val) {
    dt_basic.search(val, false, true).draw();

    /*if (i == 5) {
        var startDate = startDateEle.val(),
            endDate = endDateEle.val();
        if (startDate !== '' && endDate !== '') {
            $.fn.dataTableExt.afnFiltering.length = 0; // Reset datatable filter
            dt_basic.dataTable().fnDraw(); // Draw table after filter
            filterByDate(i, startDate, endDate); // We call our filter function
        }
        dt_basic.dataTable().fnDraw();
    } else {}*/
}