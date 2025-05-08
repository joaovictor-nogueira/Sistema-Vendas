new DataTable('#clienteTable', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/pt-BR.json',
        paginate: {
            first: '&laquo;',
            last: '&raquo;',
            previous: '&lsaquo;',
            next: '&rsaquo;'
        },

    },

    responsive: true,
    order: [[1, 'asc']],
    pageLength: 10,
    ordering: true,
    fixedHeader: true,
    columnDefs: [
        {
            orderable: false, targets: [5]
        },

    ]

});

new DataTable('#produtoTable', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/pt-BR.json',
        paginate: {
            first: '&laquo;',
            last: '&raquo;',
            previous: '&lsaquo;',
            next: '&rsaquo;'
        },

    },

    responsive: true,
    order: [[1, 'asc']],
    pageLength: 10,
    ordering: true,
    fixedHeader: true,
    columnDefs: [
        {
            orderable: false, targets: [3]
        },

    ]

});
new DataTable('#vendaTable', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/pt-BR.json',
        paginate: {
            first: '&laquo;',
            last: '&raquo;',
            previous: '&lsaquo;',
            next: '&rsaquo;'
        },

    },

    responsive: true,
    order: [[1, 'asc']],
    pageLength: 10,
    ordering: true,
    fixedHeader: true,
    columnDefs: [
        {
            orderable: false, targets: [7]
        },

    ]

});