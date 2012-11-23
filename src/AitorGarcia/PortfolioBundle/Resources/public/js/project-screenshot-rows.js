function setLinkEvents(screenshotRow) {
    // Get the "move up" link
    var linkMoveUp = screenshotRow.find('a.button-move-up');
    // On click, move the row up
    linkMoveUp.on('click', function(e) {
        e.preventDefault();
        screenshotRow.prev().before(screenshotRow);

        // Adjust every index
        var weightInputs = screenshotRow.parent().find('input[id$="weight"]');
        weightInputs.each(function(index) {
            $(this).val(index);
        });
    });

    // Get the "move down" link
    var linkMoveDown = screenshotRow.find('a.button-move-down');
    // On click, move the row down
    linkMoveDown.on('click', function(e) {
        e.preventDefault();
        screenshotRow.next().after(screenshotRow);

        // Adjust every index
        var weightInputs = screenshotRow.parent().find('input[id$="weight"]');
        weightInputs.each(function(index) {
            $(this).val(index);
        });
    });

    // Get the "remove" link
    var linkRemove = screenshotRow.find('a.button-remove-image');
    // On click, remove the row
    linkRemove.on('click', function(e) {
        e.preventDefault();
        var container = screenshotRow.parent();
        screenshotRow.detach();

        // Adjust every index
        var weightInputs = container.find('input[id$="weight"]');
        weightInputs.each(function(index) {
            $(this).val(index);
        });
    });
}

function addScreenshotRow(collectionHolder) {
    // Get the data-prototype
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '__name__' with a number based on the current collection's length
    var screenshotRow = $(prototype.replace(/__name__/g, collectionHolder.children().length));

    // Add the screenshot row to the collection holder
    collectionHolder.append(screenshotRow);

    // Display the buttons and set the events
    screenshotRow.find('div.buttons-right').show();
    setLinkEvents(screenshotRow);
}

jQuery(document).ready(function() {
    // Get the div that holds the screenshots collection
    var collectionHolder = $('#screenshots');

    // For each screenshot row, display the buttons and set the events
    collectionHolder.children('div').each(function() {
        $(this).find('div.buttons-right').show();
        setLinkEvents($(this));
    });

    // Get the "add image" button, display it and set its event
    var buttonAddImage = collectionHolder.parent().find('#button-add-image');
    buttonAddImage.show();
    buttonAddImage.on('click', function(e) {
        addScreenshotRow(collectionHolder);
    });
});
