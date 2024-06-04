<?php
include('../../../config.php');

$selectOption = isset($_GET['selectOptionFamplan']) ? $_GET['selectOptionFamplan'] : 'Date';

$frmDate = isset($_GET['frmDatefp']) ? $_GET['frmDatefp'] : null;
$toDate = isset($_GET['toDatefp']) ? $_GET['toDatefp'] : null;
$zone = isset($_GET['zone']) ? $_GET['zone'] : 'Zone 1';
$newacceptor = isset($_GET['newacceptor']) ? $_GET['newacceptor'] : null;
$changemethod = isset($_GET['changemethod']) ? $_GET['changemethod'] : null;
$changeclinic = isset($_GET['changeclinic']) ? $_GET['changeclinic'] : null;
$dropout = isset($_GET['dropout']) ? $_GET['dropout'] : null;

$rstm1 = isset($_GET['rstm1']) ? $_GET['rstm1'] : null;
$rstm2 = isset($_GET['rstm2']) ? $_GET['rstm2'] : null;
$rstm3 = isset($_GET['rstm3']) ? $_GET['rstm3'] : null;
$rstm4 = isset($_GET['rstm4']) ? $_GET['rstm4'] : null;
$rstm5 = isset($_GET['rstm5']) ? $_GET['rstm5'] : null;

$vawc1 =  isset($_GET['vawc1']) ? $_GET['vawc1'] : null;
$vawc2 =  isset($_GET['vawc2']) ? $_GET['vawc2'] : null;
$vawc3 =  isset($_GET['vawc3']) ? $_GET['vawc3'] : null;

if ($selectOption === "All") {
    $countssss = array();

    $methodsToCount = ['BTL', 'NSV', 'condom', 'Pills-POP', 'Pills', 'Pills-COC', 'Injectables (DMPA/POI)', 'Implant', 'Hormonal IUD', 'IUD', 'IUD-I', 'IUD-PP', 'NFP-LAM', 'NFP-BBT', 'NFP-CMM', 'NFP-STM', 'NFP-SDM'];

    foreach ($methodsToCount as $methodToCount) {
        $sql = "SELECT COUNT(*) AS count FROM fp_consultation WHERE method = '$methodToCount'";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        $count = $row['count'];

        $countssss[ucwords($methodToCount)] = $count;
    }

    header('Content-Type: application/json');
    echo json_encode($countssss);
}

if ($selectOption === "zonals") {
    $data = array();

    if ($newacceptor) {
        $naQuery = "SELECT COUNT(client_type) AS newAcceptorCount FROM fp_information INNER JOIN patients on fp_information.patient_id = patients.id WHERE client_type = 'New Acceptor' OR  client_type = 'NewAcceptor' AND patients.address = '$zone'";
        $result = $conn->query($naQuery);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['New Acceptor'] = $row['newAcceptorCount'];
        }
    }

    if ($changemethod) {
        $cmQuery = "SELECT COUNT(client_type) AS changeMethodCount FROM fp_information INNER JOIN patients on fp_information.patient_id = patients.id WHERE client_type = 'Changing Method' AND patients.address = '$zone'";
        $result = $conn->query($cmQuery);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Changing Method'] = $row['changeMethodCount'];
        }
    }

    if ($changeclinic) {
        $ccQuery = "SELECT COUNT(client_type) AS changeClinicCount FROM fp_information INNER JOIN patients on fp_information.patient_id = patients.id WHERE client_type = 'Change Clinic' AND patients.address = '$zone'";
        $result = $conn->query($ccQuery);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Change Clinic'] = $row['changeClinicCount'];
        }
    }

    if ($dropout) {
        $doQuery = "SELECT COUNT(client_type) AS dropoutCount FROM fp_information INNER JOIN patients on fp_information.patient_id = patients.id WHERE client_type = 'Dropout/Restart' AND patients.address = '$zone'";
        $result = $conn->query($doQuery);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Dropout/Restart'] = $row['dropoutCount'];
        }
    }

    if ($rstm1) {
        $rstm1Query = "SELECT COUNT(abnormal_discharge) as abnormal_discharge_count FROM fp_risk_for_sexuality 
        INNER JOIN fp_information on fp_risk_for_sexuality.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_sexuality.abnormal_discharge = 'Yes'";

        $result = $conn->query($rstm1Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Abnormal Discharge'] = $row['abnormal_discharge_count'];
        }
    }

    if ($rstm2) {
        $rstm2Query = "SELECT COUNT(genital_sores_ulcers) as genital_sores_ulcers_count FROM fp_risk_for_sexuality 
        INNER JOIN fp_information on fp_risk_for_sexuality.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_sexuality.genital_sores_ulcers = 'Yes'";

        $result = $conn->query($rstm2Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Genital Ulcer'] = $row['genital_sores_ulcers_count'];
        }
    }

    if ($rstm3) {
        $rstm3Query = "SELECT COUNT(genital_pain_burning_sensation) as genital_pain_burning_sensation_count FROM fp_risk_for_sexuality 
        INNER JOIN fp_information on fp_risk_for_sexuality.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_sexuality.genital_pain_burning_sensation = 'Yes'";

        $result = $conn->query($rstm3Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Genital Pain Burning Sensation Count'] = $row['genital_pain_burning_sensation_count'];
        }
    }

    if ($rstm4) {
        $rstm4Query = "SELECT COUNT(treatment_for_sti) as treatment_for_sti_count FROM fp_risk_for_sexuality 
        INNER JOIN fp_information on fp_risk_for_sexuality.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_sexuality.treatment_for_sti = 'Yes'";

        $result = $conn->query($rstm4Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['History of treatment for sexually transmitted disease'] = $row['treatment_for_sti_count'];
        }
    }

    if ($rstm5) {
        $rstm5Query = "SELECT COUNT(hiv_aids_pid) as hiv_aids_pid_count FROM fp_risk_for_sexuality 
        INNER JOIN fp_information on fp_risk_for_sexuality.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_sexuality.hiv_aids_pid = 'Yes'";

        $result = $conn->query($rstm5Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['HIV/AIDS/Pelvic Inflammatory Disease'] = $row['hiv_aids_pid_count'];
        }
    }

    if ($vawc1) {
        $vawc1Query = "SELECT COUNT(unpleasant_relationship) AS unpleasant_count FROM fp_risk_for_violence_against_women
        INNER JOIN fp_information on fp_risk_for_violence_against_women.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_violence_against_women.unpleasant_relationship = 'Yes'";

        $result = $conn->query($vawc1Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Create an unpleasant relationship with partner'] = $row['unpleasant_count'];
        }
    }

    if ($vawc2) {
        $vawc2Query = "SELECT COUNT(partner_does_not_approve) AS partner_does_not_approve_count FROM fp_risk_for_violence_against_women
        INNER JOIN fp_information on fp_risk_for_violence_against_women.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_violence_against_women.partner_does_not_approve = 'Yes'";

        $result = $conn->query($vawc2Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['Partner does not approve'] = $row['partner_does_not_approve_count'];
        }
    }
    if ($vawc3) {
        $vawc3Query = "SELECT COUNT(domestic_violence) AS domestic_violence_count FROM fp_risk_for_violence_against_women
        INNER JOIN fp_information on fp_risk_for_violence_against_women.fp_information_id =  fp_information.id
        INNER JOIN patients ON fp_information.patient_id = patients.id
        WHERE patients.address = '$zone' AND fp_risk_for_violence_against_women.domestic_violence = 'Yes'";

        $result = $conn->query($vawc3Query);
        if ($result !== false) {
            $row = $result->fetch_assoc();
            $data['History of domestic Violence or VAW'] = $row['domestic_violence_count'];
        }
    }


    header('Content-Type: application/json');
    echo json_encode($data);
}
