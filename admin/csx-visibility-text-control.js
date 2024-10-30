/**
 * Script run inside a Customizer control sidebar
 */
(function($) {
    wp.customize.bind('ready', function() {
        showVisibilityFields();
    });

    var showVisibilityFields = function() {

        var targetElems = $('li[id*="customize-control-csx_textcontent"]'),
        labelspan = $('.label .visibility'),
        icon = $('.visibility i');

        labelspan.each(function() {

            // Find next 'show_x' hidden checkbox
            var hiddenField = $(this).parent().parent().next().find('input.visibility-tb');

            // if already visible
            if ( hiddenField.val() == '1' ) {
                // Change class
                $(this).removeClass('disabled');
            } else {
                // Change class
                $(this).addClass('disabled');
            }

        });

        targetElems.each(function() {

            labelspan.on('click', function() {

                // Find next 'show_x' hidden checkbox
                var hiddenField = $(this).parent().parent().next().find('input.visibility-tb');

                // if already visible
                if ( hiddenField.val() == '1' ) {

                    // Change class
                    $(this).addClass('disabled');

                    // Set to 0 so value is not null
                    hiddenField.val("0");

                    // Trigger field change
                    hiddenField.trigger('change');

                } else {

                    // Change class
                    $(this).removeClass('disabled');

                    // Set to 1
                    hiddenField.val("1");

                    // Trigger field change
                    hiddenField.trigger('change');

                }

            });

        });
    };

})(jQuery);
