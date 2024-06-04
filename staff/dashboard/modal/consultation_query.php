<?php
include('../../../config.php');
header('Content-Type: application/json');

$selectOption = isset($_GET['consultSelect']) ? $_GET['consultSelect'] : $_GET['selectOption'];

$frmDatefp = isset($_GET['frmDatefp']) ? $_GET['frmDatefp'] : null;
$toDatefp = isset($_GET['toDatefp']) ? $_GET['toDatefp'] : null;

$zone = isset($_GET['zone']) ? $_GET['zone'] : null;

$normalChecked = isset($_GET['normalChecked']) ? $_GET['normalChecked'] : null;
$paleChecked = isset($_GET['paleChecked']) ? $_GET['paleChecked'] : null;
$yellowishChecked = isset($_GET['yellowishChecked']) ? $_GET['yellowishChecked'] : null;
$hematomaChecked = isset($_GET['hematomaChecked']) ? $_GET['hematomaChecked'] : null;
$cnormalChecked = isset($_GET['cnormalChecked']) ? $_GET['cnormalChecked'] : null;
$cpaleChecked = isset($_GET['cpaleChecked']) ? $_GET['cpaleChecked'] : null;
$cyellowishChecked = isset($_GET['cyellowishChecked']) ? $_GET['cyellowishChecked'] : null;
$exnormalChecked = isset($_GET['exnormalChecked']) ? $_GET['exnormalChecked'] : null;
$edemaChecked = isset($_GET['edemaChecked']) ? $_GET['edemaChecked'] : null;
$varicositiesChecked = isset($_GET['varicositiesChecked']) ? $_GET['varicositiesChecked'] : null;
$neck_normalChecked = isset($_GET['neck_normalChecked']) ? $_GET['neck_normalChecked'] : null;
$enlarge_lymphChecked = isset($_GET['enlarge_lymphChecked']) ? $_GET['enlarge_lymphChecked'] : null;


$data = [];

if ($selectOption === "All") {
    $zones = range(1, 12);
    $fp_consultation = [];
    $prenatal_consultation = [];
    $consultations = [];
    $immunization = [];

    foreach ($zones as $zone) {
        $fp_query = "SELECT COUNT(*) as count FROM fp_consultation INNER JOIN patients ON fp_consultation.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
        $fp_result = $conn->query($fp_query);
        $fp_row = $fp_result->fetch_assoc();
        $fp_consultation[] = $fp_row['count'];

        $prenatal_query = "SELECT COUNT(*) as count FROM prenatal_consultation INNER JOIN patients ON prenatal_consultation.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
        $prenatal_result = $conn->query($prenatal_query);
        $prenatal_row = $prenatal_result->fetch_assoc();
        $prenatal_consultation[] = $prenatal_row['count'];

        $consultations_query = "SELECT COUNT(*) as count FROM consultations INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
        $consultations_result = $conn->query($consultations_query);
        $consultations_row = $consultations_result->fetch_assoc();
        $consultations[] = $consultations_row['count'];

        $immunization_query = "SELECT COUNT(*) as count FROM immunization INNER JOIN patients ON immunization.patient_id = patients.id WHERE patients.address = 'Zone $zone'";
        $immunization_result = $conn->query($immunization_query);
        $immunization_row = $immunization_result->fetch_assoc();
        $immunization[] = $immunization_row['count'];
    }

    $data = [
        'zones' => $zones,
        'fp_consultation' => $fp_consultation,
        'prenatal_consultation' => $prenatal_consultation,
        'consultations' => $consultations,
        'immunization' => $immunization
    ];

    echo json_encode($data);
}
if ($selectOption === "ZonalReport") {
    $data = [];

    if ($normalChecked) {
        $normalSkinQuery = "SELECT COUNT(skin) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.skin = 'Normal'";
        $result = $conn->query($normalSkinQuery);
        $row = $result->fetch_assoc();
        $data['normalSkinCount'] = $row['count'];
    }
    if ($paleChecked) {
        $paleSkinQuery = "SELECT COUNT(skin) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.skin = 'Pale'";
        $result = $conn->query($paleSkinQuery);
        $row = $result->fetch_assoc();
        $data['paleSkinCount'] = $row['count'];
    }
    if ($yellowishChecked) {
        $yellowishSkinQuery = "SELECT COUNT(skin) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.skin = 'Yellowish'";
        $result = $conn->query($yellowishSkinQuery);
        $row = $result->fetch_assoc();
        $data['yellowishSkinCount'] = $row['count'];
    }
    if ($hematomaChecked) {
        $hematomaSkinQuery = "SELECT COUNT(skin) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.skin = 'Hematoma'";
        $result = $conn->query($hematomaSkinQuery);
        $row = $result->fetch_assoc();
        $data['hematomaCount'] = $row['count'];
    }
    if ($cnormalChecked) {
        $cnormalQuery = "SELECT COUNT(conjunctiva) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.conjunctiva = 'Normal'";
        $result = $conn->query($cnormalQuery);
        $row = $result->fetch_assoc();
        $data['cnormalCount'] = $row['count'];
    }
    if ($cpaleChecked) {
        $cpaleQuery = "SELECT COUNT(conjunctiva) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.conjunctiva = 'Pale'";
        $result = $conn->query($cpaleQuery);
        $row = $result->fetch_assoc();
        $data['cpaleCount'] = $row['count'];
    }
    if ($cyellowishChecked) {
        $cyellowishQuery = "SELECT COUNT(conjunctiva) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.conjunctiva = 'Yellowish'";
        $result = $conn->query($cyellowishQuery);
        $row = $result->fetch_assoc();
        $data['cyellowishCount'] = $row['count'];
    }
    if ($exnormalChecked) {
        $exnormalQuery = "SELECT COUNT(extremities) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.extremities = 'Normal'";
        $result = $conn->query($exnormalQuery);
        $row = $result->fetch_assoc();
        $data['exnormalCount'] = $row['count'];
    }
    if ($edemaChecked) {
        $edemaQuery = "SELECT COUNT(extremities) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.extremities = 'Edema'";
        $result = $conn->query($edemaQuery);
        $row = $result->fetch_assoc();
        $data['edemaCount'] = $row['count'];
    }
    if ($varicositiesChecked) {
        $varicositiesQuery = "SELECT COUNT(extremities) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.extremities = 'Varicosities'";
        $result = $conn->query($varicositiesQuery);
        $row = $result->fetch_assoc();
        $data['varicositiesCount'] = $row['count'];
    }
    if ($neck_normalChecked) {
        $neckNormalQuery = "SELECT COUNT(neck) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.neck = 'Normal'";
        $result = $conn->query($neckNormalQuery);
        $row = $result->fetch_assoc();
        $data['neck_normalCount'] = $row['count'];
    }
    if ($enlarge_lymphChecked) {
        $enlargeLymphQuery = "SELECT COUNT(neck) as count FROM fp_physical_examination INNER JOIN consultations ON fp_physical_examination.consultation_id = consultations.id INNER JOIN patients ON consultations.patient_id = patients.id WHERE patients.address = '$zone' AND fp_physical_examination.neck = 'EnlargeLymphNodes'";
        $result = $conn->query($enlargeLymphQuery);
        $row = $result->fetch_assoc();
        $data['enlarge_lymphCount'] = $row['count'];
    }

    echo json_encode($data);
}
exit();
