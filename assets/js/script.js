jQuery(function( $ ) {
    $('.gs-option').click(function (e) {

        let $target = $(e.target);
        if ($target.prop("tagName") != 'INPUT') return;

        let id = $(this).attr('id');
        let $conditionField = $('[data-field="' + id + '"]');
        if ($conditionField.length) {
            let conditionalValues = $conditionField.attr('data-value');
            let fieldOptions = conditionalValues.split(',');

            if ($.inArray($target.val(), fieldOptions) === -1) {
                $conditionField.hide()
            }
            else {
                $conditionField.show();
            }
        }
    });

    wp.data.subscribe(function () {
        if (wp.data.select( 'core/edit-post' ).isSavingMetaBoxes()) {
            $('.gs-options').addClass('disabled');
        }
        else {
            $('.gs-options').removeClass('disabled');
        }
    });

});