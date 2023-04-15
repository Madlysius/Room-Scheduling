<?php

class display
{
    /**
     * Display options from a database table as HTML <option> elements.
     *
     * @param string $table The name of the database table to query.
     * @param string $id The name of the column in the database table to use as the option value.
     * @param string $name The name of the column in the database table to use as the option label.
     * @param string $condition Optional. The SQL WHERE clause to use to filter the results. Defaults to null.
     *
     * @return void Echoes the HTML <option> elements to the output.
     */
    function displayOption($table, $id, $name, $condition = null)
    {
        require_once('./php/require/DBConfig.php');
        if ($condition !== null) {
            // $stmt = $mysqli->prepare("SELECT * FROM $table WHERE $condition");
            $stmt =  DB::query("SELECT * FROM $table WHERE $condition");
        } else {
            // $stmt = $mysqli->prepare("SELECT * FROM $table");
            $stmt = DB::query("SELECT * FROM $table");
        }
        // $stmt = $mysqli->prepare("SELECT * FROM $table");
        foreach ($stmt as $row) {
            echo '<option value="' . $row[$id] . '">' . $row[$name] . '</option>';
        }
    }

    /**
     * Display time
     * @param string $start_time (ex "08:00")
     * @param string $end_time (ex "17:00")
     * @param string $step (default 30 minutes, ex "+30 minutes")
     */
    function displayTime($start_time, $end_time, $step)
    {
        while (strtotime($start_time) <= strtotime($end_time)) {
            echo '<option value="' . $start_time . '">' . $start_time . '</option>';
            $start_time = date("H:i", strtotime($step, strtotime($start_time)));
        }
    }
    /**
     * Display time with selected value
     * @param string $start_time (ex "08:00")
     * @param string $end_time (ex "17:00")
     * @param string $step (default 30 minutes, ex "+30 minutes")
     * @param string $selected (the value to mark as selected)
     */
    function displayTimeSelected($start_time, $end_time, $step, $selected)
    {
        while (strtotime($start_time) <= strtotime($end_time)) {
            echo '<option value="' . $start_time . '"';
            if ($start_time == $selected) {
                echo ' selected="selected"';
            }
            echo '>' . $start_time . '</option>';
            $start_time = date("H:i", strtotime($step, strtotime($start_time)));
        }
    }
    /**
     *Displays status messages based on the value of the 'status' parameter in the GET request. example: ?status=success&message=Room+added+successfully
     *@return void
     */
    function displayStatus()
    {
        if (!isset($_GET['status'])) return;
        switch ($_GET['status']) {
            case 'success':
                echo '<div class="alert alert-success" role="alert" style="margin-top:15px;">';
                echo $_GET['message'];
                echo '</div>';
                break;
            case 'error':
                echo '<div class="alert alert-danger" role="alert" style="margin-top:15px;">';
                echo $_GET['message'];
                echo '</div>';
                break;
            case 'empty':
                echo '<div class="alert alert-danger" role="alert" style="margin-top:15px;">
                Please fill out all fields!
                </div>';
                break;
            case 'invalid':
                echo '<div class="alert alert-danger" role="alert" style="margin-top:15px;">
                Invalid input!';
                echo $_GET['message'];
                echo '</div>';
                break;
            case 'edit-failed':
                echo '<div class="alert alert-danger" role="alert" style="margin-top:15px;">
                Edit failed!';
                echo $_GET['message'];
                echo '</div>';
                break;
            default:
                echo '<div class="alert alert-danger" role="alert" style="margin-top:15px;">
                Unknown error!';
                echo $_GET['message'];
                echo '</div>';
                break;
        }
    }
    function displayDay()
    {
        $days = DB::query("SELECT * FROM day");
        //th
        foreach ($days as $day) {
            echo '<td>' . $day['day'] . '</td>';
        }
    }
    /**
     * Display data from a database query in a table with edit and delete actions.
     *
     * @param array $data The data to display in the table.
     * @param string $idField The name of the field in the data array that contains the unique ID for each row.
     * @param string $editPage The name of the page to redirect to for editing a row.
     * @param string $deleteRequest The name of the request to send to the server for deleting a row.
     * @return void
     */
    function displayData($data, $idField, $editPage, $deleteRequest)
    {
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $field) {
                echo "<td>" . $field . "</td>";
            }
            echo '<td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton-' . $row[$idField] . '" data-bs-toggle="dropdown" aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' . $row[$idField] . '">
                    <li><a class="dropdown-item" href="' . $editPage . '?edit=' . $idField . '&amp;' . $idField . '=' . $row[$idField] . '">Edit</a></li>
                    <li><a class="dropdown-item" href="./php/DBRequest.php?' . $deleteRequest . '=' . $idField . '&amp;' . $idField . '=' . $row[$idField] . '">Delete</a></li>
                </ul>
            </div>
        </td>';
            echo '</tr>';
        }
    }
}
