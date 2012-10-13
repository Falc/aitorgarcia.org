function addScreenshotRowButtons(container) {
    // Create the "move up" link
    var $linkMoveUp = $('<a class="button-img" href="#" title="Mover arriba"><img src="/bundles/portfolio/images/up.png" alt="Arriba" /></a>');
    // On click, move the row up
    $linkMoveUp.on('click', function(e) {
        e.preventDefault();
        var current = $(this).parent().parent();
        current.prev().before(current);
    });

    // Create the "move down" link
    var $linkMoveDown = $('<a class="button-img" href="#" title="Mover abajo"><img src="/bundles/portfolio/images/down.png" alt="Abajo" /></a>');
    // On click, move the row down
    $linkMoveDown.on('click', function(e) {
        e.preventDefault();
        var current = $(this).parent().parent();
        current.next().after(current);
    });

    // Create the "remove" link
    var $linkRemove = $('<a class="button-img" href="#" title="Eliminar imagen"><img src="/bundles/portfolio/images/delete.png" alt="Eliminar" /></a>');
    // On click, remove the row
    $linkRemove.on('click', function(e) {
        e.preventDefault();
        container.remove();
    });

    // Create a div and add the links to it
    var $divButtons = $('<div class="buttons-right"></div>');
    $divButtons.append($linkMoveUp);
    $divButtons.append($linkMoveDown);
    $divButtons.append($linkRemove);

    // Add the div to the container
    container.append($divButtons);
}

function addScreenshotRow(collectionHolder) {
    // Remove the empty row
    $('div.empty-row').remove();

    // Get the data-prototype
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '__name__' with a number based on the current collection's length
    var screenshotRow = $(prototype.replace(/__name__/g, collectionHolder.children().length));

    // Add the screenshot row to the collection holder
    collectionHolder.append(screenshotRow);

    // Add some buttons/links to the new screenshot row
    addScreenshotRowButtons(screenshotRow);
}

jQuery(document).ready(function() {
    // Get the div that holds the collection of screenshots
    var collectionHolder = $('#screenshots');

    // Create an "add" button and add it to the collection holder
    var $btnAdd = $('<button type="button">Añadir imagen</button>');
    var $divBtnAdd = $('<div class="_100 clear"></div>').append($btnAdd);
    collectionHolder.after($divBtnAdd);

    // Add the action links to each screenshot row
    collectionHolder.find('div').each(function() {
        addScreenshotRowButtons($(this));
    });

    // On click, add a new screenshot row
    $btnAdd.on('click', function(e) {
        // Prevent the link from creating a "#" on the URL
        //e.preventDefault();

        addScreenshotRow(collectionHolder);
    });
});
