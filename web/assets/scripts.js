$(document).ready(function() {

    console.log('Scripts successfully loaded.');

    var article_fieldValues = $('#article_fieldValues').parent();
    var article_subFamily = $('#article_subFamily');

    var initialValue_article_subFamily = article_subFamily.val()
    
    article_subFamily.change(function(event) {
        if ($(this).val() == initialValue_article_subFamily) {
            article_fieldValues.show();
        } else {
            article_fieldValues.hide();
        }
    });

    $('.remove').live('click', function(event) {
        $(this).parent().slideUp('medium', function() {
            $(this).remove();
        });
        event.preventDefault();
    });

    $('.delete_confirm').click(function(event) {
        if (!confirm("Are you sure you want to delete this item ?")) {
            event.preventDefault();
        }
    });

    $('.trigger_print').click(function(event) {
        print();
        event.preventDefault();
    });

    if ($('.auto_print').size()) {
        print();
    }

});