$(document).ready(function () {
    //Allow only alpha numeric characters
    $(".alphaNumericChar").on("keyup", function () {
        var inputValue = $(this).val();
        // Remove non-alphanumeric characters
        var sanitizedValue = inputValue.replace(/[^a-zA-Z0-9]/g, '');
        $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    //Allow uppercase only
    $(".uppercaseChar").on("keyup", function () {
        var inputValue = $(this).val();
        var blockLetters = inputValue.toUpperCase(); // Convert input to uppercase
        $(this).val(blockLetters); // Update input field with block letters
    });

    //Mobile number validate
    $(".mobileNumber").on("keyup", function () {
        var inputValue = $(this).val();
        var sanitizedValue = inputValue.replace(/\D/g, '');
        // Limit the length to a maximum of 10 characters
        sanitizedValue = sanitizedValue.substring(0, 10);
        $(this).val(sanitizedValue);
    });

    //Allow only numeric value
    $(".onlyNumber").on("keyup", function () {
        var inputValue = $(this).val();
        // Remove non-alphanumeric characters
        var sanitizedValue = inputValue.replace(/[^0-9]/g, '');
        $(this).val(sanitizedValue); // Update input field with sanitized value
    });

    //Mobile number validate
    $(".phoneNumber").on("keyup", function () {
        var inputValue = $(this).val();
        var sanitizedValue = inputValue.replace(/\D/g, '');
        // Limit the length to a maximum of 10 characters
        sanitizedValue = sanitizedValue.substring(0, 11);
        $(this).val(sanitizedValue);
    });

    $(".numberwithOneDot").on("keyup", function () {
        var inputValue = $(this).val();
        // Remove non-numeric characters except dot
        var sanitizedValue = inputValue.replace(/[^\d.]/g, '');
        // Split the value by dot
        var parts = sanitizedValue.split('.');
        // If there are more than two parts, keep only the first part (before the first dot)
        if (parts.length > 2) {
            parts = [parts[0], parts.slice(1).join('')];
        }
        // Join the parts back with a dot
        sanitizedValue = parts.join('.');
        $(this).val(sanitizedValue);
    });

    $(".gsm_value").on("keyup", function () {
        var inputValue = $(this).val();
        // Remove non-alphanumeric characters
        var sanitizedValue = inputValue.replace(/[^a-zA-Z0-9/]/g, '');
        $(this).val(sanitizedValue); // Update input field with sanitized value
    });

});