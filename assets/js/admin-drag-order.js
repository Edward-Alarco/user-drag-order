jQuery(function ($) {

    const tableBody = $('.wp-list-table.users tbody');

    if (!tableBody.length) return;

    tableBody.sortable({
        items: 'tr',
        cursor: 'move',
        axis: 'y',
        containment: 'parent',
        helper: function (e, ui) {
            ui.children().each(function () {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function () {

            let order = [];

            tableBody.find('tr').each(function () {
                const id = $(this).attr('id');
                if (id && id.startsWith('user-')) {
                    order.push(id.replace('user-', ''));
                }
            });

            $.post(UserDragOrder.ajax, {
                action: 'save_users_order',
                order: order,
                _ajax_nonce: UserDragOrder.nonce
            });
        }
    });

});