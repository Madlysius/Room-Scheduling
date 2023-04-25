<?php

/**
 *Validates form fields and redirects if necessary.
 *@param array $fields An associative array of form fields and their values.
 *@param string $redirect The URL to redirect to if validation fails.
 *@return null boolean Returns true if validation passes, false otherwise.
 */
function form_validation($fields, $redirect)
{
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $status = "error";
            header("Location: $redirect?status=$status&message=Please Fill Up All Fields");
            exit();
        }
    }
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
        $status = "error";
        header("Location: $redirect?status=$status&message=Form%20already%20submitted");
        exit();
    }
    $_SESSION['form_submitted'] = true;
}
/**
 * Validates the given dropdown value against a list of valid values.
 *
 * @param string $dropdown_value The value to validate.
 * @param array $valid_values An array of valid values for the dropdown.
 * @param string $redirect_url The URL to redirect to if the value is invalid.
 * @return void
 */
function validateDropdownValues($selected_value, $valid_values, $error_message, $redirect_url)
{
    if (!in_array($selected_value, $valid_values)) {
        $status = "error";
        header("Location: $redirect_url?status=$status&message=$error_message");
        exit();
    }
}
