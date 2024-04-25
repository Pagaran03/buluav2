<?php
// Include your database configuration file
include_once ('../../config.php');


$sql = "SELECT
    NULL as id,
    'All Patients' as name,
    SUM(CASE WHEN gender = 'male' THEN 1 ELSE 0 END) AS male_patients,
    SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) AS female_patients
FROM patients
WHERE gender IN ('male', 'female')
UNION
SELECT
    id,
    first_name as name,
    0 as male_patients,
    SUM(CASE WHEN gender = 'female' THEN 1 ELSE 0 END) AS female_patients
FROM patients
WHERE gender = 'male'
GROUP BY id, first_name";

$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<!-- Add modal structure -->
<div id="maleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Male Patients</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="malePatientsList"></ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-body table-responsive p-0" style="z-index: -99999">
            <table id="tablebod" class="table table-head-fixed text-nowrap table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Male</th>
                        <th>Female</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td class="align-middle">
                                    <?php echo $i++; ?>
                                </td>

                                <td class="align-middle male-count">
                                    <?php echo $row['male_patients']; ?>
                                </td>
                                <td class="align-middle">
                                    <?php echo $row['female_patients']; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="align-middle" colspan="3">No Family Planning Found</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2nd table -->


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function () {



        <?php if ($result->num_rows > 0): ?>
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'male_patients' },
                    { targets: 2, data: 'female_patients' },


                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });

        <?php else: ?>
            // Initialize DataTable without the "Action" column when no rows are found
            var table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'male_patients' },
                    { targets: 2, data: 'female_patients' },
                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });
        <?php endif; ?>


        $('#addButton').click(function () {

            table.destroy(); // Destroy the existing DataTable
            table = $('#tablebod').DataTable({
                columnDefs: [
                    { targets: 0, data: 'id' },
                    { targets: 1, data: 'male_patients' },
                    { targets: 2, data: 'female_patients' },

                ],
                // Set the default ordering to 'id' column in descending order
                order: [[0, 'desc']]
            });


            // Get data from the form




        });



        $(document).ready(function () {
            // Show modal with male patient names when male count cell is clicked
            $('.male-count').click(function () {
                var malePatients = []; // Array to store male patient names
                // Loop through each row and extract male patient names and count
                $('#tablebod tbody tr').each(function () {
                    var maleCount = $(this).find('.male-count').text();
                    var patientName = $(this).find('.male-patient-name').text();
                    // Push male patient names to the array based on the count
                    for (var i = 0; i < parseInt(maleCount); i++) {
                        malePatients.push(patientName);
                    }
                });
                // Display male patient names in the modal
                $('#malePatientsList').html('');
                malePatients.forEach(function (name) {
                    $('#malePatientsList').append('<li>' + name + '</li>');
                });
                // Show the modal
                $('#maleModal').modal('show');
            });
        });

    });


</script>