function setLinkEvents(screenshotRow) {
    var inputSelectScreenshot = screenshotRow.find('.screenshot-file input[type="file"]');
    var inputFakeSelectScreenshot = screenshotRow.find('.screenshot-file input[type="text"]');
    var btnFakeSelectScreenshot = screenshotRow.find('.screenshot-file button');

    inputSelectScreenshot.on('change', function() {
        inputFakeSelectScreenshot.val(inputSelectScreenshot.val());
    });

    btnFakeSelectScreenshot.on('click', function() {
        inputSelectScreenshot.click();
    });

    // Get the "move up" link
    var linkMoveUp = screenshotRow.find('a[data-id="btn-up"]');
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
    var linkMoveDown = screenshotRow.find('a[data-id="btn-down"]');
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
    var linkRemove = screenshotRow.find('a[data-id="btn-remove"]');
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

        // If there are no images in the container, display the "is empty" message
        if (container.children().length === 0) {
            var emptyMessage = container.attr('data-empty');
            container.append(emptyMessage);
        }
    });
}

function addScreenshotRow(screenshotsContainer) {
    // Remove the alerts, if any
    screenshotsContainer.find('.alert').remove();

    // Get the data-prototype
    var prototype = screenshotsContainer.attr('data-prototype');

    // Replace '__name__' with a number based on the number of screenshots
    var screenshotRow = $(prototype.replace(/__name__/g, screenshotsContainer.children().length));

    // Add the screenshot row to the screenshots container
    screenshotsContainer.append(screenshotRow);

    // Set the events
    setLinkEvents(screenshotRow);
}

$(document).ready(function() {
    var screenshotsContainer = $('#screenshots');

    // For each screenshot, set the events
    screenshotsContainer.children('.screenshot').each(function() {
        setLinkEvents($(this));
    });

    // Get the "add screenshot" button, display it and set its event
    var buttonAddScreenshot = $('#btn-add-screenshot');
    buttonAddScreenshot.show();
    buttonAddScreenshot.on('click', function() {
        addScreenshotRow(screenshotsContainer);
    });
});
