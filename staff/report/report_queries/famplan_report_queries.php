<?php

include_once('./../../config.php');

// ANAPM = Acceptors New Acceptors Previous Month - BTL QUERY
$combinedANAPMCount = "
    SELECT
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS btlANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS btlANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS btlANAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nsvANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nsvANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nsvANAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS condomANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS condomANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS condomANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillsANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillsANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillsANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillspopANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillspopANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillspopANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillscocANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillscocANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillscocANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS injectablesANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS injectablesANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS injectablesANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS implantANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS implantANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS implantANAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudiANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudiANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudiANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudppANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudppANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudppANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfplamANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfplamANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfplamANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpbbtANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpbbtANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpbbtANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpcmmANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpcmmANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpcmmANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpstmANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpstmANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpstmANAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpsdmANAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpsdmANAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpsdmANAPMCount_20_to_49
        
    FROM 
        fp_consultation
        INNER JOIN 
        patients ON fp_consultation.patient_id = patients.id
        INNER JOIN 
        fp_information ON fp_information.patient_id = patients.id
        WHERE 
        fp_information.client_type = 'New Acceptor'
        AND fp_consultation.checkup_date <> '0000-00-00'
        AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
        AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)
";

try {
    // Prepare and execute the statement
    $combinedANAPM_stmt = $conn->prepare($combinedANAPMCount);
    $combinedANAPM_stmt->bind_param("ss", $fromDate, $toDate);
    $combinedANAPM_stmt->execute();
    $combinedANAPM_stmt->bind_result(
        $btlANAPMCount_count10to14,
        $btlANAPMCount_count15to19,
        $btlANAPMCount_count20to49,
        $nsvANAPMCount_count10to14,
        $nsvANAPMCount_count15to19,
        $nsvANAPMCount_count20to49,
        $condomANAPMCount_count10to14,
        $condomANAPMCount_count15to19,
        $condomANAPMCount_count20to49,
        $pillsANAPMCount_count10to14,
        $pillsANAPMCount_count15to19,
        $pillsANAPMCount_count20to49,
        $pillspopANAPMCount_count10to14,
        $pillspopANAPMCount_count15to19,
        $pillspopANAPMCount_count20to49,
        $pillscocANAPMCount_count10to14,
        $pillscocANAPMCount_count15to19,
        $pillscocANAPMCount_count20to49,
        $injectablesANAPMCount_count10to14,
        $injectablesANAPMCount_count15to19,
        $injectablesANAPMCount_count20to49,
        $implantANAPMCount_count10to14,
        $implantANAPMCount_count15to19,
        $implantANAPMCount_count20to49,
        $iudANAPMCount_count10to14,
        $iudANAPMCount_count15to19,
        $iudANAPMCount_count20to49,
        $iudI_ANAPMCount_count10to14,
        $iudI_ANAPMCount_count15to19,
        $iudI_ANAPMCount_count20to49,
        $iudPP_ANAPMCount_count10to14,
        $iudPP_ANAPMCount_count15to19,
        $iudPP_ANAPMCount_count20to49,
        $nfplamANAPMCount_count10to14,
        $nfplamANAPMCount_count15to19,
        $nfplamANAPMCount_count20to49,
        $nfpbbtANAPMCount_count10to14,
        $nfpbbtANAPMCount_count15to19,
        $nfpbbtANAPMCount_count20to49,
        $nfpcmmANAPMCount_count10to14,
        $nfpcmmANAPMCount_count15to19,
        $nfpcmmANAPMCount_count20to49,
        $nfpstmANAPMCount_count10to14,
        $nfpstmANAPMCount_count15to19,
        $nfpstmANAPMCount_count20to49,
        $nfpsdmANAPMCount_count10to14,
        $nfpsdmANAPMCount_count15to19,
        $nfpsdmANAPMCount_count20to49
    );

    $combinedANAPM_stmt->fetch();
    $combinedANAPM_stmt->close();
} catch (Exception $e) {
    $err =  $e->getMessage();
}


$btlANAPMCount_countTotal = $btlANAPMCount_count10to14 + $btlANAPMCount_count15to19 + $btlANAPMCount_count20to49;
$nsvANAPMCount_countTotal = $nsvANAPMCount_count10to14 + $nsvANAPMCount_count15to19 + $nsvANAPMCount_count20to49;
$condomANAPMCount_countTotal = $condomANAPMCount_count10to14 + $condomANAPMCount_count15to19 + $condomANAPMCount_count20to49;
$pillsANAPMCount_counTotal = $pillsANAPMCount_count10to14 + $pillsANAPMCount_count15to19 + $pillsANAPMCount_count20to49;
$pillspopANAPMCount_counTotal = $pillspopANAPMCount_count10to14 + $pillspopANAPMCount_count15to19 + $pillspopANAPMCount_count20to49;
$pillscocANAPMCount_counTotal = $pillscocANAPMCount_count10to14 + $pillscocANAPMCount_count15to19 + $pillscocANAPMCount_count20to49;
$injectablesANAPMCount_countTotal = $injectablesANAPMCount_count10to14 + $injectablesANAPMCount_count15to19 + $injectablesANAPMCount_count20to49;
$iudANAPMCount_countTotal = $iudANAPMCount_count10to14 + $iudANAPMCount_count15to19 + $iudANAPMCount_count20to49;
$implantANAPMCount_countTotal = $implantANAPMCount_count10to14 + $implantANAPMCount_count15to19 + $implantANAPMCount_count20to49;
$iudI_ANAPMCount_countTotal = $iudI_ANAPMCount_count10to14 + $iudI_ANAPMCount_count15to19 + $iudI_ANAPMCount_count20to49;
$iudPP_ANAPMCount_countTotal = $iudPP_ANAPMCount_count10to14 + $iudPP_ANAPMCount_count15to19 + $iudPP_ANAPMCount_count20to49;
$nfplamANAPMCount_countTotal = $nfplamANAPMCount_count10to14 + $nfplamANAPMCount_count15to19 + $nfplamANAPMCount_count20to49;
$nfpbbtANAPMCount_countTotal = $nfpbbtANAPMCount_count10to14 + $nfpbbtANAPMCount_count15to19 + $nfpbbtANAPMCount_count20to49;
$nfpcmmANAPMCount_countTotal = $nfpcmmANAPMCount_count10to14 + $nfpcmmANAPMCount_count15to19 + $nfpcmmANAPMCount_count20to49;
$nfpstmANAPMCount_countTotal = $nfpstmANAPMCount_count10to14 + $nfpstmANAPMCount_count15to19 + $nfpstmANAPMCount_count20to49;
$nfpsdmANAPMCount_countTotal = $nfpsdmANAPMCount_count10to14 + $nfpsdmANAPMCount_count15to19 + $nfpsdmANAPMCount_count20to49;

//OAPM = Other Acceptor Present Month

$combinedOAPMCount = "
SELECT 
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS btlOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS btlOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS btlOAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nsvOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nsvOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nsvOAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS condomOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS condomOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS condomOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillsOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillsOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillsOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillspopOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillspopOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillspopOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillscocOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillscocOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillscocOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS injectablesOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS injectablesOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS injectablesOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS implantOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS implantOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS implantOAPMCount_20_to_49,
    
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudiOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudiOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudiOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudppOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudppOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudppOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfplamOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfplamOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfplamOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpbbtOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpbbtOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpbbtOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpcmmOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpcmmOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpcmmOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpstmOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpstmOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpstmOAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpsdmOAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpsdmOAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpsdmOAPMCount_20_to_49
FROM 
    fp_consultation
INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
INNER JOIN 
    fp_information ON fp_information.patient_id = patients.id
WHERE 
(fp_information.client_type = 'ChangingMethod' 
OR fp_information.client_type = 'ChangingClinic')
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND fp_consultation.checkup_date BETWEEN ? AND ?";


try {
    // Prepare and execute the statement
    $combinedOAPM_stmt = $conn->prepare($combinedOAPMCount);
    $combinedOAPM_stmt->bind_param("ss", $fromDate, $toDate);
    $combinedOAPM_stmt->execute();
    $combinedOAPM_stmt->bind_result(
        $btlOAPMCount_count10to14,
        $btlOAPMCount_count15to19,
        $btlOAPMCount_count20to49,
        $nsvOAPMCount_count10to14,
        $nsvOAPMCount_count15to19,
        $nsvOAPMCount_count20to49,
        $condomOAPMCount_count10to14,
        $condomOAPMCount_count15to19,
        $condomOAPMCount_count20to49,
        $pillsOAPMCount_count10to14,
        $pillsOAPMCount_count15to19,
        $pillsOAPMCount_count20to49,
        $pillspopOAPMCount_count10to14,
        $pillspopOAPMCount_count15to19,
        $pillspopOAPMCount_count20to49,
        $pillscocOAPMCount_count10to14,
        $pillscocOAPMCount_count15to19,
        $pillscocOAPMCount_count20to49,
        $injectablesOAPMCount_count10to14,
        $injectablesOAPMCount_count15to19,
        $injectablesOAPMCount_count20to49,
        $implantOAPMCount_count10to14,
        $implantOAPMCount_count15to19,
        $implantOAPMCount_count20to49,
        $iudOAPMCount_count10to14,
        $iudOAPMCount_count15to19,
        $iudOAPMCount_count20to49,
        $iudiOAPMCount_count10to14,
        $iudiOAPMCount_count15to19,
        $iudiOAPMCount_count20to49,
        $iudppOAPMCount_count10to14,
        $iudppOAPMCount_count15to19,
        $iudppOAPMCount_count20to49,
        $nfplamOAPMCount_count10to14,
        $nfplamOAPMCount_count15to19,
        $nfplamOAPMCount_count20to49,
        $nfpbbtOAPMCount_count10to14,
        $nfpbbtOAPMCount_count15to19,
        $nfpbbtOAPMCount_count20to49,
        $nfpcmmOAPMCount_count10to14,
        $nfpcmmOAPMCount_count15to19,
        $nfpcmmOAPMCount_count20to49,
        $nfpstmOAPMCount_count10to14,
        $nfpstmOAPMCount_count15to19,
        $nfpstmOAPMCount_count20to49,
        $nfpsdmOAPMCount_count10to14,
        $nfpsdmOAPMCount_count15to19,
        $nfpsdmOAPMCount_count20to49
    );

    $combinedOAPM_stmt->fetch();
    $combinedOAPM_stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


$btlOAPMCount_totalCount = $btlOAPMCount_count10to14 + $btlOAPMCount_count15to19 + $btlOAPMCount_count20to49;
$nsvOAPMCount_totalCount = $nsvOAPMCount_count10to14 + $nsvOAPMCount_count15to19 + $nsvOAPMCount_count20to49;
$condomOAPMCount_totalCount = $condomOAPMCount_count10to14 + $condomOAPMCount_count15to19 + $condomOAPMCount_count20to49;
$pillsOAPMCount_totalCount = $pillsOAPMCount_count10to14 + $pillsOAPMCount_count15to19 + $pillsOAPMCount_count20to49;
$pillspopOAPMCount_totalCount =  $pillspopOAPMCount_count10to14 + $pillspopOAPMCount_count15to19 + $pillspopOAPMCount_count20to49;
$pillscocOAPMCount_totalCount =  $pillscocOAPMCount_count10to14 + $pillscocOAPMCount_count15to19 + $pillscocOAPMCount_count20to49;
$injectablesOAPMCount_totalCount = $injectablesOAPMCount_count10to14 + $injectablesOAPMCount_count15to19 + $injectablesOAPMCount_count20to49;
$implantOAPMCount_totalCount = $implantOAPMCount_count10to14 + $implantOAPMCount_count15to19 + $implantOAPMCount_count20to49;
$iudOAPMCount_totalCount = $iudOAPMCount_count10to14 + $iudOAPMCount_count15to19 + $iudOAPMCount_count20to49;
$iudiOAPMCount_totalCount = $iudiOAPMCount_count10to14 + $iudiOAPMCount_count15to19 + $iudiOAPMCount_count20to49;
$iudppOAPMCount_totalCount = $iudppOAPMCount_count10to14 + $iudppOAPMCount_count15to19 + $iudppOAPMCount_count20to49;
$nfplamOAPMCount_totalCount = $nfplamOAPMCount_count10to14 + $nfplamOAPMCount_count15to19 + $nfplamOAPMCount_count20to49;
$nfpbbtOAPMCount_totalCount = $nfpbbtOAPMCount_count10to14 + $nfpbbtOAPMCount_count15to19 + $nfpbbtOAPMCount_count20to49;
$nfpcmmOAPMCount_totalCount = $nfpcmmOAPMCount_count10to14 + $nfpcmmOAPMCount_count15to19 + $nfpcmmOAPMCount_count20to49;
$nfpstmOAPMCount_totalCount = $nfpstmOAPMCount_count10to14 + $nfpstmOAPMCount_count15to19 + $nfpstmOAPMCount_count20to49;
$nfpsdmOAPMCount_totalCount = $nfpsdmOAPMCount_count10to14 + $nfpsdmOAPMCount_count15to19 + $nfpsdmOAPMCount_count20to49;


// DOPM - Drop Out Present Month
// SHERD AWATA LANG NI SHERD I COPY ANG KANANG GIKAN LANG SA SUM KANANG SA 10 TO 49,
$combinedDOPMCount = "
SELECT 
COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS btlDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS btlDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS btlDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nsvDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nsvDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nsvDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS condomDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS condomDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS condomDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillsDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillsDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillsDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillspopDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillspopDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillspopDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillscocDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillscocDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillscocDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS injectablesDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS injectablesDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS injectablesDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS implantDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS implantDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS implantDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudiDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudiDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudiDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudppDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudppDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudppDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfplamDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfplamDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfplamDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpbbtDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpbbtDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpbbtDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpcmmDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpcmmDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpcmmDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpstmDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpstmDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpstmDOPMCount_20_to_49,

COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpsdmDOPMCount_10_to_14,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpsdmDOPMCount_15_to_19,
COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpsdmDOPMCount_20_to_49

       
FROM 
fp_consultation
INNER JOIN 
patients ON fp_consultation.patient_id = patients.id
INNER JOIN 
fp_information ON fp_information.patient_id = patients.id
WHERE 
fp_information.client_type = 'DropoutRestart'
AND fp_consultation.checkup_date <> '0000-00-00'
AND fp_consultation.checkup_date BETWEEN ? AND ?";

// TAPOS DIRI FOLLOW LANG SA AKONG NAMING CONVENTION SHERD, LIKE nsvDOPM, DOPM meaning ana Drop Out Present Month
// AND THEN AYAW PUD KALIMOT SA TOTAL2X TAN AWA LANG ANG SA IBABAW GAW
try {
    // Prepare and execute the statement
    $combinedDOPM_stmt = $conn->prepare($combinedDOPMCount);
    $combinedDOPM_stmt->bind_param("ss", $fromDate, $toDate);
    $combinedDOPM_stmt->execute();
    $combinedDOPM_stmt->bind_result(
        $btlDOPMCount_count10to14,
        $btlDOPMCount_count15to19,
        $btlDOPMCount_count20to49,
        $nsvDOPMCount_count10to14,
        $nsvDOPMCount_count15to19,
        $nsvDOPMCount_count20to49,
        $condomDOPMCount_count10to14,
        $condomDOPMCount_count15to19,
        $condomDOPMCount_count20to49,
        $pillsDOPMCount_count10to14,
        $pillsDOPMCount_count15to19,
        $pillsDOPMCount_count20to49,
        $pillspopDOPMCount_count10to14,
        $pillspopDOPMCount_count15to19,
        $pillspopDOPMCount_count20to49,
        $pillscocDOPMCount_count10to14,
        $pillscocDOPMCount_count15to19,
        $pillscocDOPMCount_count20to49,
        $injectablesDOPMCount_count10to14,
        $injectablesDOPMCount_count15to19,
        $injectablesDOPMCount_count20to49,
        $implantDOPMCount_count10to14,
        $implantDOPMCount_count15to19,
        $implantDOPMCount_count20to49,
        $iudDOPMCount_count10to14,
        $iudDOPMCount_count15to19,
        $iudDOPMCount_count20to49,
        $iudiDOPMCount_count10to14,
        $iudiDOPMCount_count15to19,
        $iudiDOPMCount_count20to49,
        $iudppDOPMCount_count10to14,
        $iudppDOPMCount_count15to19,
        $iudppDOPMCount_count20to49,
        $nfplamDOPMCount_count10to14,
        $nfplamDOPMCount_count15to19,
        $nfplamDOPMCount_count20to49,
        $nfpbbtDOPMCount_count10to14,
        $nfpbbtDOPMCount_count15to19,
        $nfpbbtDOPMCount_count20to49,
        $nfpcmmDOPMCount_count10to14,
        $nfpcmmDOPMCount_count15to19,
        $nfpcmmDOPMCount_count20to49,
        $nfpstmDOPMCount_count10to14,
        $nfpstmDOPMCount_count15to19,
        $nfpstmDOPMCount_count20to49,
        $nfpsdmDOPMCount_count10to14,
        $nfpsdmDOPMCount_count15to19,
        $nfpsdmDOPMCount_count20to49
    );

    $combinedDOPM_stmt->fetch();
    $combinedDOPM_stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$btlDOPMCount_totalCount = $btlDOPMCount_count10to14 + $btlDOPMCount_count15to19 + $btlDOPMCount_count20to49;
$nsvDOPMCount_totalCount = $nsvDOPMCount_count10to14 + $nsvDOPMCount_count15to19 + $nsvDOPMCount_count20to49;
$condomDOPMCount_totalCount = $condomDOPMCount_count10to14 + $condomDOPMCount_count15to19 + $condomDOPMCount_count20to49;
$pillsDOPMCount_totalCount = $pillsDOPMCount_count10to14 + $pillsDOPMCount_count15to19 + $pillsDOPMCount_count20to49;
$pillspopDOPMCount_totalCount =  $pillspopDOPMCount_count10to14 + $pillspopDOPMCount_count15to19 + $pillspopDOPMCount_count20to49;
$pillscocDOPMCount_totalCount =  $pillscocDOPMCount_count10to14 + $pillscocDOPMCount_count15to19 + $pillscocDOPMCount_count20to49;
$injectablesDOPMCount_totalCount = $injectablesDOPMCount_count10to14 + $injectablesDOPMCount_count15to19 + $injectablesDOPMCount_count20to49;
$implantDOPMCount_totalCount = $implantDOPMCount_count10to14 + $implantDOPMCount_count15to19 + $implantDoPMCount_count20to49;
$iudDOPMCount_totalCount = $iudDOPMCount_count10to14 + $iudDOPMCount_count15to19 + $iudDOPMCount_count20to49;
$iudiDOPMCount_totalCount = $iudiDOPMCount_count10to14 + $iudiDOPMCount_count15to19 + $iudiDOPMCount_count20to49;
$iudppDOPMCount_totalCount = $iudppDOPMCount_count10to14 + $iudppDOPMCount_count15to19 + $iudppDOPMCount_count20to49;
$nfplamDOPMCount_totalCount = $nfplamDOPMCount_count10to14 + $nfplamDOPMCount_count15to19 + $nfplamDOPMCount_count20to49;
$nfpbbtDOPMCount_totalCount = $nfpbbtDOPMCount_count10to14 + $nfpbbtDOPMCount_count15to19 + $nfpbbtDOPMCount_count20to49;
$nfpcmmDOPMCount_totalCount = $nfpcmmDOPMCount_count10to14 + $nfpcmmDOPMCount_count15to19 + $nfpcmmDOPMCount_count20to49;
$nfpstmDOPMCount_totalCount = $nfpstmDOPMCount_count10to14 + $nfpstmDOPMCount_count15to19 + $nfpstmDOPMCount_count20to49;
$nfpsdmDOPMCount_totalCount = $nfpsdmDOPMCount_count10to14 + $nfpsdmDOPMCount_count15to19 + $nfpsdmDOPMCount_count20to49;

// CUEOM = Current User End Of Month

$btlCUEOMTotal10to14 = max(0, $btlANAPMCount_count10to14 + $btlOAPMCount_count10to14 - $btlDOPMCount_count10to14);
$btlCUEOMTotal15to19 = max(0, $btlANAPMCount_count15to19 + $btlOAPMCount_count15to19 - $btlDOPMCount_count15to19);
$btlCUEOMTotal20to49 = max(0, $btlANAPMCount_count20to49 + $btlOAPMCount_count20to49 - $btlDOPMCount_count20to49);
$btlCUEOMTotal = $btlCUEOMTotal10to14 + $btlCUEOMTotal15to19 + $btlCUEOMTotal20to49;

$nsvCUEOMTotal10to14 = max(0, $nsvANAPMCount_count10to14 + $nsvOAPMCount_count10to14 - $nsvDOPMCount_count10to14);
$nsvCUEOMTotal15to19 = max(0, $nsvANAPMCount_count15to19 + $nsvOAPMCount_count15to19 - $nsvDOPMCount_count15to19);
$nsvCUEOMTotal20to49 = max(0, $nsvANAPMCount_count20to49 + $nsvOAPMCount_count20to49 - $nsvDOPMCount_count20to49);
$nsvCUEOMTotal = $nsvCUEOMTotal10to14 + $nsvCUEOMTotal15to19 + $nsvCUEOMTotal20to49;

$condomCUEOMTotal10to14 = max(0, $condomANAPMCount_count10to14 + $condomOAPMCount_count10to14 - $condomDOPMCount_count10to14);
$condomCUEOMTotal15to19 = max(0, $condomANAPMCount_count15to19 + $condomOAPMCount_count15to19 - $condomDOPMCount_count15to19);
$condomCUEOMTotal20to49 = max(0, $condomANAPMCount_count20to49 + $condomOAPMCount_count20to49 - $condomDOPMCount_count20to49);
$condomCUEOMTotal = $condomCUEOMTotal10to14 + $condomCUEOMTotal15to19 + $condomCUEOMTotal20to49;

$pillsCUEOMTotal10to14 = max(0, $pillsANAPMCount_count10to14 + $pillsOAPMCount_count10to14 - $pillsDOPMCount_count10to14);
$pillsCUEOMTotal15to19 = max(0, $pillsANAPMCount_count15to19 + $pillsOAPMCount_count15to19 - $pillsDOPMCount_count15to19);
$pillsCUEOMTotal20to49 = max(0, $pillsANAPMCount_count20to49 + $pillsOAPMCount_count20to49 - $pillsDOPMCount_count20to49);
$pillsCUEOMTotal = $pillsCUEOMTotal10to14 + $pillsCUEOMTotal15to19 + $pillsCUEOMTotal20to49;

$pillspopCUEOMTotal10to14 = max(0, $pillspopANAPMCount_count10to14 + $pillspopOAPMCount_count10to14 - $pillspopDOPMCount_count10to14);
$pillspopCUEOMTotal15to19 = max(0, $pillspopANAPMCount_count15to19 + $pillspopOAPMCount_count15to19 - $pillspopDOPMCount_count15to19);
$pillspopCUEOMTotal20to49 = max(0, $pillspopANAPMCount_count20to49 + $pillspopOAPMCount_count20to49 - $pillspopDOPMCount_count20to49);
$pillspopCUEOMTotal = $pillspopCUEOMTotal10to14 + $pillspopCUEOMTotal15to19 + $pillspopCUEOMTotal20to49;

$pillscocCUEOMTotal10to14 = max(0, $pillscocANAPMCount_count10to14 + $pillscocOAPMCount_count10to14 - $pillscocDOPMCount_count10to14);
$pillscocCUEOMTotal15to19 = max(0, $pillscocANAPMCount_count15to19 + $pillscocOAPMCount_count15to19 - $pillscocDOPMCount_count15to19);
$pillscocCUEOMTotal20to49 = max(0, $pillscocANAPMCount_count20to49 + $pillscocOAPMCount_count20to49 - $pillscocDOPMCount_count20to49);
$pillscocCUEOMTotal = $pillscocCUEOMTotal10to14 + $pillscocCUEOMTotal15to19 + $pillscocCUEOMTotal20to49;

$injectablesCUEOMTotal10to14 = max(0, $injectablesANAPMCount_count10to14 + $injectablesOAPMCount_count10to14 - $injectablesDOPMCount_count10to14);
$injectablesCUEOMTotal15to19 = max(0, $injectablesANAPMCount_count15to19 + $injectablesOAPMCount_count15to19 - $injectablesDOPMCount_count15to19);
$injectablesCUEOMTotal20to49 = max(0, $injectablesANAPMCount_count20to49 + $injectablesOAPMCount_count20to49 - $injectablesDOPMCount_count20to49);
$injectablesCUEOMTotal = $injectablesCUEOMTotal10to14 + $injectablesCUEOMTotal15to19 + $injectablesCUEOMTotal20to49;

$implantCUEOMTotal10to14 = max(0, $implantANAPMCount_count10to14 + $implantOAPMCount_count10to14 - $implantDOPMCount_count10to14);
$implantCUEOMTotal15to19 = max(0, $implantANAPMCount_count15to19 + $implantOAPMCount_count15to19 - $implantDOPMCount_count15to19);
$implantCUEOMTotal20to49 = max(0, $implantANAPMCount_count20to49 + $implantOAPMCount_count20to49 - $implantDOPMCount_count20to49);
$implantCUEOMTotal = $implantCUEOMTotal10to14 + $implantCUEOMTotal15to19 + $implantCUEOMTotal20to49;

$iudCUEOMTotal10to14 = max(0, $iudANAPMCount_count10to14 + $iudOAPMCount_count10to14 - $iudDOPMCount_count10to14);
$iudCUEOMTotal15to19 = max(0, $iudANAPMCount_count15to19 + $iudOAPMCount_count15to19 - $iudDOPMCount_count15to19);
$iudCUEOMTotal20to49 = max(0, $iudANAPMCount_count20to49 + $iudOAPMCount_count20to49 - $iudDOPMCount_count20to49);
$iudCUEOMTotal = $iudCUEOMTotal10to14 + $iudCUEOMTotal15to19 + $iudCUEOMTotal20to49;

$iudiCUEOMTotal10to14 = max(0, $iudI_ANAPMCount_count10to14 + $iudiOAPMCount_count10to14 - $iudiDOPMCount_count10to14);
$iudiCUEOMTotal15to19 = max(0, $iudI_ANAPMCount_count15to19 + $iudiOAPMCount_count15to19 - $iudiDOPMCount_count15to19);
$iudiCUEOMTotal20to49 = max(0, $iudI_ANAPMCount_count20to49 + $iudiOAPMCount_count20to49 - $iudiDOPMCount_count20to49);
$iudiCUEOMTotal = $iudiCUEOMTotal10to14 + $iudiCUEOMTotal15to19 + $iudiCUEOMTotal20to49;

$iudppCUEOMTotal10to14 = max(0, $iudPP_ANAPMCount_count10to14 + $iudppOAPMCount_count10to14 - $iudppDOPMCount_count10to14);
$iudppCUEOMTotal15to19 = max(0, $iudPP_ANAPMCount_count15to19 + $iudppOAPMCount_count15to19 - $iudppDOPMCount_count15to19);
$iudppCUEOMTotal20to49 = max(0, $iudPP_ANAPMCount_count20to49 + $iudppOAPMCount_count20to49 - $iudppDOPMCount_count20to49);
$iudppCUEOMTotal = $iudppCUEOMTotal10to14 + $iudppCUEOMTotal15to19 + $iudppCUEOMTotal20to49;

$nfplamCUEOMTotal10to14 = max(0, $nfplamANAPMCount_count10to14 + $nfplamOAPMCount_count10to14 - $nfplamDOPMCount_count10to14);
$nfplamCUEOMTotal15to19 = max(0, $nfplamANAPMCount_count15to19 + $nfplamOAPMCount_count15to19 - $nfplamDOPMCount_count15to19);
$nfplamCUEOMTotal20to49 = max(0, $nfplamANAPMCount_count20to49 + $nfplamOAPMCount_count20to49 - $nfplamDOPMCount_count20to49);
$nfplamCUEOMTotal = $nfplamCUEOMTotal10to14 + $nfplamCUEOMTotal15to19 + $nfplamCUEOMTotal20to49;

$nfpbbtCUEOMTotal10to14 = max(0, $nfpbbtANAPMCount_count10to14 + $nfpbbtOAPMCount_count10to14 - $nfpbbtDOPMCount_count10to14);
$nfpbbtCUEOMTotal15to19 = max(0, $nfpbbtANAPMCount_count15to19 + $nfpbbtOAPMCount_count15to19 - $nfpbbtDOPMCount_count15to19);
$nfpbbtCUEOMTotal20to49 = max(0, $nfpbbtANAPMCount_count20to49 + $nfpbbtOAPMCount_count20to49 - $nfpbbtDOPMCount_count20to49);
$nfpbbtCUEOMTotal = $nfpbbtCUEOMTotal10to14 + $nfpbbtCUEOMTotal15to19 + $nfpbbtCUEOMTotal20to49;

$nfpcmmCUEOMTotal10to14 = max(0, $nfpcmmANAPMCount_count10to14 + $nfpcmmOAPMCount_count10to14 - $nfpcmmDOPMCount_count10to14);
$nfpcmmCUEOMTotal15to19 = max(0, $nfpcmmANAPMCount_count15to19 + $nfpcmmOAPMCount_count15to19 - $nfpcmmDOPMCount_count15to19);
$nfpcmmCUEOMTotal20to49 = max(0, $nfpcmmANAPMCount_count20to49 + $nfpcmmOAPMCount_count20to49 - $nfpcmmDOPMCount_count20to49);
$nfpcmmCUEOMTotal = $nfpcmmCUEOMTotal10to14 + $nfpcmmCUEOMTotal15to19 + $nfpcmmCUEOMTotal20to49;

$nfpstmCUEOMTotal10to14 = max(0, $nfpstmANAPMCount_count10to14 + $nfpstmOAPMCount_count10to14 - $nfpstmDOPMCount_count10to14);
$nfpstmCUEOMTotal15to19 = max(0, $nfpstmANAPMCount_count15to19 + $nfpstmOAPMCount_count15to19 - $nfpstmDOPMCount_count15to19);
$nfpstmCUEOMTotal20to49 = max(0, $nfpstmANAPMCount_count20to49 + $nfpstmOAPMCount_count20to49 - $nfpstmDOPMCount_count20to49);
$nfpstmCUEOMTotal = $nfpstmCUEOMTotal10to14 + $nfpstmCUEOMTotal15to19 + $nfpstmCUEOMTotal20to49;

$nfpsdmCUEOMTotal10to14 = max(0, $nfpsdmANAPMCount_count10to14 + $nfpsdmOAPMCount_count10to14 - $nfpsdmDOPMCount_count10to14);
$nfpsdmCUEOMTotal15to19 = max(0, $nfpsdmANAPMCount_count15to19 + $nfpsdmOAPMCount_count15to19 - $nfpsdmDOPMCount_count15to19);
$nfpsdmCUEOMTotal20to49 = max(0, $nfpsdmANAPMCount_count20to49 + $nfpsdmOAPMCount_count20to49 - $nfpsdmDOPMCount_count20to49);
$nfpsdmCUEOMTotal = $nfpsdmCUEOMTotal10to14 + $nfpsdmCUEOMTotal15to19 + $nfpsdmCUEOMTotal20to49;



// NAPM = New Acceptors Present Month
$combinedNAPMCount = "
    SELECT 
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS btlNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS btlNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS btlNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nsvNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nsvNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nsvNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS condomNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS condomNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS condomNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillsNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillsNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillsNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillspopNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillspopNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillspopNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillscocNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillscocNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillscocNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS injectablesNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS injectablesNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS injectablesNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS implantNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS implantNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS implantNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudiNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudiNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudiNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudppNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudppNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudppNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfplamNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfplamNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfplamNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpbbtNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpbbtNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpbbtNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpcmmNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpcmmNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpcmmNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpstmNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpstmNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpstmNAPMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpsdmNAPMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpsdmNAPMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpsdmNAPMCount_20_to_49


    FROM 
        fp_consultation
    INNER JOIN 
        patients ON fp_consultation.patient_id = patients.id
    INNER JOIN 
        fp_information ON fp_information.patient_id = patients.id
    WHERE 
        fp_information.client_type = 'New Acceptor'
        AND fp_consultation.checkup_date <> '0000-00-00'
        AND fp_consultation.checkup_date BETWEEN ? AND ?";

try {
    // Prepare and execute the statement
    $combinedNAPM_stmt = $conn->prepare($combinedNAPMCount);
    if (!$combinedNAPM_stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $combinedNAPM_stmt->bind_param("ss", $fromDate, $toDate);
    if (!$combinedNAPM_stmt->execute()) {
        throw new Exception("Execute failed: " . $combinedNAPM_stmt->error);
    }

    $combinedNAPM_stmt->bind_result(
        $btlNAPMCount_count10to14,
        $btlNAPMCount_count15to19,
        $btlNAPMCount_count20to49,
        $nsvNAPMCount_count10to14,
        $nsvNAPMCount_count15to19,
        $nsvNAPMCount_count20to49,
        $condomNAPMCount_count10to14,
        $condomNAPMCount_count15to19,
        $condomNAPMCount_count20to49,
        $pillsNAPMCount_count10to14,
        $pillsNAPMCount_count15to19,
        $pillsNAPMCount_count20to49,
        $pillspopNAPMCount_count10to14,
        $pillspopNAPMCount_count15to19,
        $pillspopNAPMCount_count20to49,
        $pillscocNAPMCount_count10to14,
        $pillscocNAPMCount_count15to19,
        $pillscocNAPMCount_count20to49,
        $injectablesNAPMCount_count10to14,
        $injectablesNAPMCount_count15to19,
        $injectablesNAPMCount_count20to49,
        $implantNAPMCount_count10to14,
        $implantNAPMCount_count15to19,
        $implantNAPMCount_count20to49,
        $iudNAPMCount_count10to14,
        $iudNAPMCount_count15to19,
        $iudNAPMCount_count20to49,
        $iudiNAPMCount_count10to14,
        $iudiNAPMCount_count15to19,
        $iudiNAPMCount_count20to49,
        $iudppNAPMCount_count10to14,
        $iudppNAPMCount_count15to19,
        $iudppNAPMCount_count20to49,
        $nfplamNAPMCount_count10to14,
        $nfplamNAPMCount_count15to19,
        $nfplamNAPMCount_count20to49,
        $nfpbbtNAPMCount_count10to14,
        $nfpbbtNAPMCount_count15to19,
        $nfpbbtNAPMCount_count20to49,
        $nfpcmmNAPMCount_count10to14,
        $nfpcmmNAPMCount_count15to19,
        $nfpcmmNAPMCount_count20to49,
        $nfpstmNAPMCount_count10to14,
        $nfpstmNAPMCount_count15to19,
        $nfpstmNAPMCount_count20to49,
        $nfpsdmNAPMCount_count10to14,
        $nfpsdmNAPMCount_count15to19,
        $nfpsdmNAPMCount_count20to49
    );

    if (!$combinedNAPM_stmt->fetch()) {
        echo "<script>alert('No data found for the given date range.')</script>";
    }
    $combinedNAPM_stmt->close();
} catch (Exception $e) {
    $err =  $e->getMessage();
}

// CUMB = Current User Month Beninging

$btlCUMBTotal10to14 = $btlCUEOMTotal10to14;
$btlCUMBTotal15to19 = $btlCUEOMTotal15to19;
$btlCUMBTotal20to49 = $btlCUEOMTotal20to49;
$btlCUMBTotal = $btlCUMBTotal10to14 + $btlCUMBTotal15to19 + $btlCUMBTotal20to49;

$nsvCUMBTotal10to14 = $nsvCUEOMTotal10to14;
$nsvCUMBTotal15to19 = $nsvCUEOMTotal15to19;
$nsvCUMBTotal20to49 = $nsvCUEOMTotal20to49;
$nsvCUMBTotal = $nsvCUMBTotal10to14 +
    $nsvCUMBTotal15to19 +
    $nsvCUMBTotal20to49;

$condomCUMBTotal15to19 = $condomCUEOMTotal10to14;
$condomCUMBTotal10to14 = $condomCUEOMTotal10to14;
$condomCUMBTotal20to49 = $condomCUEOMTotal20to49;
$condomCUMBTotal = $condomCUMBTotal15to19 +
    $condomCUMBTotal10to14 +
    $condomCUMBTotal20to49;

$pillsCUMBTotal10to14 = $pillsCUEOMTotal10to14;
$pillsCUMBTotal15to19 = $pillsCUEOMTotal15to19;
$pillsCUMBTotal20to49 = $pillsCUEOMTotal20to49;
$pillsCUMBTotal = $pillsCUMBTotal10to14 +
    $pillsCUMBTotal15to19 +
    $pillsCUMBTotal20to49;

$pillspopCUMBTotal10to14 = $pillspopCUEOMTotal10to14;
$pillspopCUMBTotal15to19 = $pillspopCUEOMTotal15to19;
$pillspopCUMBTotal20to49 = $pillspopCUEOMTotal20to49;
$pillspopCUMBTotal = $pillspopCUMBTotal10to14 +
    $pillspopCUMBTotal15to19 +
    $pillspopCUMBTotal20to49;

$pillscocCUMBTotal10to14 = $pillscocCUEOMTotal10to14;
$pillscocCUMBTotal15to19 = $pillscocCUEOMTotal15to19;
$pillscocCUMBTotal20to49 = $pillscocCUEOMTotal20to49;
$pillscocCUMBTotal = $pillscocCUMBTotal10to14 + $pillscocCUMBTotal15to19 + $pillscocCUMBTotal20to49;

$injectablesCUMBTotal10to14 = $injectablesCUEOMTotal10to14;
$injectablesCUMBTotal15to19 = $injectablesCUEOMTotal15to19;
$injectablesCUMBTotal20to49 = $injectablesCUEOMTotal20to49;
$injectablesCUMBTotal = $injectablesCUMBTotal10to14 + $injectablesCUMBTotal15to19 + $injectablesCUMBTotal20to49;

$implantCUMBTotal10to14 = $implantCUEOMTotal10to14;
$implantCUMBTotal15to19 = $implantCUEOMTotal15to19;
$implantCUMBTotal20to49 = $implantCUEOMTotal20to49;
$implantCUMBTotal = $implantCUMBTotal10to14 + $implantCUMBTotal15to19 + $implantCUMBTotal20to49;

$iudCUMBTotal10to14 = $iudCUEOMTotal10to14;
$iudCUMBTotal15to19 = $iudCUEOMTotal15to19;
$iudCUMBTotal20to49 = $iudCUEOMTotal20to49;
$iudCUMBTotal = $iudCUMBTotal10to14 + $iudCUMBTotal15to19 + $iudCUMBTotal20to49;

$iudiCUMBTotal10to14 = $iudiCUEOMTotal10to14;
$iudiCUMBTotal15to19 = $iudiCUEOMTotal15to19;
$iudiCUMBTotal20to49 = $iudiCUEOMTotal20to49;
$iudiCUMBTotal = $iudiCUMBTotal10to14 + $iudiCUMBTotal15to19 + $iudiCUMBTotal20to49;

$iudppCUMBTotal10to14 = $iudppCUEOMTotal10to14;
$iudppCUMBTotal15to19 = $iudppCUEOMTotal15to19;
$iudppCUMBTotal20to49 = $iudppCUEOMTotal20to49;
$iudppCUMBTotal = $iudppCUMBTotal10to14 + $iudppCUMBTotal15to19 + $iudppCUMBTotal20to49;

$nfplamCUMBTotal10to14 = $nfplamCUEOMTotal10to14;
$nfplamCUMBTotal15to19 = $nfplamCUEOMTotal15to19;
$nfplamCUMBTotal20to49 = $nfplamCUEOMTotal20to49;
$nfplamCUMBTotal = $nfplamCUMBTotal10to14 + $nfplamCUMBTotal15to19 + $nfplamCUMBTotal20to49;

$nfpbbtCUMBTotal10to14 = $nfpbbtCUEOMTotal10to14;
$nfpbbtCUMBTotal15to19 = $nfpbbtCUEOMTotal15to19;
$nfpbbtCUMBTotal20to49 = $nfpbbtCUEOMTotal20to49;
$nfpbbtCUMBTotal = $nfpbbtCUMBTotal10to14 + $nfpbbtCUMBTotal15to19 + $nfpbbtCUMBTotal20to49;

$nfpcmmCUMBTotal10to14 = $nfpcmmCUEOMTotal10to14;
$nfpcmmCUMBTotal15to19 = $nfpcmmCUEOMTotal15to19;
$nfpcmmCUMBTotal20to49 = $nfpcmmCUEOMTotal20to49;
$nfpcmmCUMBTotal = $nfpcmmCUMBTotal10to14 + $nfpcmmCUMBTotal15to19 + $nfpcmmCUMBTotal20to49;

$nfpstmCUMBTotal10to14 = $nfpstmCUEOMTotal10to14;
$nfpstmCUMBTotal15to19 = $nfpstmCUEOMTotal15to19;
$nfpstmCUMBTotal20to49 = $nfpstmCUEOMTotal20to49;
$nfpstmCUMBTotal = $nfpstmCUMBTotal10to14 + $nfpstmCUMBTotal15to19 + $nfpstmCUMBTotal20to49;

$nfpsdmCUMBTotal10to14 = $nfpsdmCUEOMTotal10to14;
$nfpsdmCUMBTotal15to19 = $nfpsdmCUEOMTotal15to19;
$nfpsdmCUMBTotal20to49 = $nfpsdmCUEOMTotal20to49;
$nfpsdmCUMBTotal = $nfpsdmCUMBTotal10to14 + $nfpsdmCUMBTotal15to19 + $nfpsdmCUMBTotal20to49;

// NEW ACCEPTOR TOTAL
$btlNAPMCount_totalCount = $btlNAPMCount_count10to14 + $btlNAPMCount_count15to19 + $btlNAPMCount_count20to49;
$nsvNAPMCount_totalCount = $nsvNAPMCount_count10to14 + $nsvNAPMCount_count15to19 + $nsvNAPMCount_count20to49;
$condomNAPMCount_totalCount = $condomNAPMCount_count10to14 + $condomNAPMCount_count15to19 + $condomNAPMCount_count20to49;
$pillsNAPMCount_totalCount = $pillsNAPMCount_count10to14 + $pillsNAPMCount_count15to19 + $pillsNAPMCount_count20to49;
$pillspopNAPMCount_totalCount =  $pillspopNAPMCount_count10to14 + $pillspopNAPMCount_count15to19 + $pillspopNAPMCount_count20to49;
$pillscocNAPMCount_totalCount =  $pillscocNAPMCount_count10to14 + $pillscocNAPMCount_count15to19 + $pillscocNAPMCount_count20to49;
$injectablesNAPMCount_totalCount = $injectablesNAPMCount_count10to14 + $injectablesNAPMCount_count15to19 + $injectablesNAPMCount_count20to49;
$implantNAPMCount_totalCount = $implantNAPMCount_count10to14 + $implantNAPMCount_count15to19 + $implantNAPMCount_count20to49;
$iudNAPMCount_totalCount = $iudNAPMCount_count10to14 + $iudNAPMCount_count15to19 + $iudNAPMCount_count20to49;
$iudiNAPMCount_totalCount = $iudiNAPMCount_count10to14 + $iudiNAPMCount_count15to19 + $iudiNAPMCount_count20to49;
$iudppNAPMCount_totalCount = $iudppNAPMCount_count10to14 + $iudppNAPMCount_count15to19 + $iudppNAPMCount_count20to49;
$nfplamNAPMCount_totalCount = $nfplamNAPMCount_count10to14 + $nfplamNAPMCount_count15to19 + $nfplamNAPMCount_count20to49;
$nfpbbtNAPMCount_totalCount = $nfpbbtNAPMCount_count10to14 + $nfpbbtNAPMCount_count15to19 + $nfpbbtNAPMCount_count20to49;
$nfpcmmNAPMCount_totalCount = $nfpcmmNAPMCount_count10to14 + $nfpcmmNAPMCount_count15to19 + $nfpcmmNAPMCount_count20to49;
$nfpstmNAPMCount_totalCount = $nfpstmNAPMCount_count10to14 + $nfpstmNAPMCount_count15to19 + $nfpstmNAPMCount_count20to49;
$nfpsdmNAPMCount_totalCount = $nfpsdmNAPMCount_count10to14 + $nfpsdmNAPMCount_count15to19 + $nfpsdmNAPMCount_count20to49;




// CUBM = New Acceptors Present Month
$cubmCount = "
    SELECT 
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS btlCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS btlCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'BTL' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS btlCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nsvCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nsvCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NSV' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nsvCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS condomCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS condomCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Condom' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS condomCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillsCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillsCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillsCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillspopCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillspopCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-POP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillspopCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS pillscocCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS pillscocCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Pills-COC' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS pillscocCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS injectablesCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS injectablesCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Injectables (DMPA/POI)' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS injectablesCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS implantCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS implantCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'Implant' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS implantCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudiCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudiCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-I' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudiCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS iudppCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS iudppCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'IUD-PP' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS iudppCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfplamCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfplamCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-LAM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfplamCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpbbtCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpbbtCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-BBT' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpbbtCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpcmmCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpcmmCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-CMM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpcmmCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpstmCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpstmCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-STM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpstmCUBMCount_20_to_49,

    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END), 0) AS nfpsdmCUBMCount_10_to_14,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END), 0) AS nfpsdmCUBMCount_15_to_19,
    COALESCE(SUM(CASE WHEN fp_consultation.method = 'NFP-SDM' AND patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END), 0) AS nfpsdmCUBMCount_20_to_49

    FROM 
        fp_consultation
    INNER JOIN 
        patients ON fp_consultation.patient_id = patients.id
    INNER JOIN 
        fp_information ON fp_information.patient_id = patients.id
    WHERE  fp_consultation.checkup_date <> '0000-00-00'
        AND DAY(fp_consultation.checkup_date) BETWEEN 1 AND 14
        AND fp_consultation.checkup_date BETWEEN ? AND ?";

try {
    // Prepare and execute the statement
    $combinedCUBM_stmt = $conn->prepare($cubmCount);
    if (!$combinedCUBM_stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $combinedCUBM_stmt->bind_param("ss", $fromDate, $toDate);
    if (!$combinedCUBM_stmt->execute()) {
        throw new Exception("Execute failed: " . $combinedCUBM_stmt->error);
    }

    $combinedCUBM_stmt->bind_result(
        $btlCUBMCount_count10to14,
        $btlCUBMCount_count15to19,
        $btlCUBMCount_count20to49,
        $nsvCUBMCount_count10to14,
        $nsvCUBMCount_count15to19,
        $nsvCUBMCount_count20to49,
        $condomCUBMCount_count10to14,
        $condomCUBMCount_count15to19,
        $condomCUBMCount_count20to49,
        $pillsCUBMCount_count10to14,
        $pillsCUBMCount_count15to19,
        $pillsCUBMCount_count20to49,
        $pillspopCUBMCount_count10to14,
        $pillspopCUBMCount_count15to19,
        $pillspopCUBMCount_count20to49,
        $pillscocCUBMCount_count10to14,
        $pillscocCUBMCount_count15to19,
        $pillscocCUBMCount_count20to49,
        $injectablesCUBMCount_count10to14,
        $injectablesCUBMCount_count15to19,
        $injectablesCUBMCount_count20to49,
        $implantCUBMCount_count10to14,
        $implantCUBMCount_count15to19,
        $implantCUBMCount_count20to49,
        $iudCUBMCount_count10to14,
        $iudCUBMCount_count15to19,
        $iudCUBMCount_count20to49,
        $iudiCUBMCount_count10to14,
        $iudiCUBMCount_count15to19,
        $iudiCUBMCount_count20to49,
        $iudppCUBMCount_count10to14,
        $iudppCUBMCount_count15to19,
        $iudppCUBMCount_count20to49,
        $nfplamCUBMCount_count10to14,
        $nfplamCUBMCount_count15to19,
        $nfplamCUBMCount_count20to49,
        $nfpbbtCUBMCount_count10to14,
        $nfpbbtCUBMCount_count15to19,
        $nfpbbtCUBMCount_count20to49,
        $nfpcmmCUBMCount_count10to14,
        $nfpcmmCUBMCount_count15to19,
        $nfpcmmCUBMCount_count20to49,
        $nfpstmCUBMCount_count10to14,
        $nfpstmCUBMCount_count15to19,
        $nfpstmCUBMCount_count20to49,
        $nfpsdmCUBMCount_count10to14,
        $nfpsdmCUBMCount_count15to19,
        $nfpsdmCUBMCount_count20to49
    );

    if (!$combinedCUBM_stmt->fetch()) {
        echo "<script>console.log('No data found for the given date range.')</script>";
    }
    $combinedCUBM_stmt->close();
} catch (Exception $e) {
    $err =  $e->getMessage();
}

$currentUserBTL10to14 =  $btlCUBMCount_count10to14 + $btlANAPMCount_count10to14 + $btlOAPMCount_count10to14 - $btlDOPMCount_count10to14;
$currentUserBTL15to19 =  $btlCUBMCount_count15to19 + $btlANAPMCount_count15to19 + $btlOAPMCount_count15to19 - $btlDOPMCount_count15to19;
$currentUserBTL20to49 =  $btlCUBMCount_count20to49 + $btlANAPMCount_count20to49 + $btlOAPMCount_count20to49 - $btlDOPMCount_count20to49;

$currentUserBTLTotal =
    $currentUserBTL10to14 +
    $currentUserBTL15to19 +
    $currentUserBTL20to49;

$currentUserNVSTotal10to14 = $nsvCUBMCount_count10to14 + $nsvCUBMCount_count10to14 + $nsvOAPMCount_count10to14 - $nsvDOPMCount_count10to14;
$currentUserNVSTotal15to19 = $nsvCUBMCount_count15to19 + $nsvCUBMCount_count15to19 + $nsvOAPMCount_count10to14 - $nsvDOPMCount_count15to19;
$currentUserNVSTotal20to49 = $nsvCUBMCount_count20to49 + $nsvCUBMCount_count20to49 + $nsvOAPMCount_count20to49 - $nsvDOPMCount_count20to49;

$currentUserNSVTotal =
    $currentUserNVSTotal10to14 +
    $currentUserNVSTotal15to19 +
    $currentUserNVSTotal20to49;

$currentUserCondom10to14 = $condomCUBMCount_count10to14 + $condomANAPMCount_count10to14 + $condomOAPMCount_count10to14 - $condomDOPMCount_count10to14;
$currentUserCondom15to19 = $condomCUBMCount_count15to19 + $condomANAPMCount_count15to19 + $condomOAPMCount_count15to19 - $condomDOPMCount_count15to19;
$currentUserCondom20to49 = $condomCUBMCount_count20to49 + $condomANAPMCount_count20to49 + $condomOAPMCount_count20to49 - $condomDOPMCount_count20to49;

$currentUserCondomTotal =
    $currentUserCondom10to14 +
    $currentUserCondom15to19 +
    $currentUserCondom20to49;

$currentUserPillsTotal10to14 = $pillsCUBMCount_count10to14 + $pillsANAPMCount_count10to14 + $pillsOAPMCount_count10to14 - $pillsDOPMCount_count10to14;
$currentUserPillsTotal15to19 =  $pillsCUBMCount_count15to19 + $pillsANAPMCount_count15to19 + $pillsOAPMCount_count15to19 - $pillsDOPMCount_count15to19;
$currentUserPillsTotal20to49 =  $pillsCUBMCount_count20to49 + $pillsANAPMCount_count20to49 + $pillsOAPMCount_count20to49 - $pillsDOPMCount_count20to49;

$currentUserPillsTotal =
    $currentUserPillsTotal10to14 +
    $currentUserPillsTotal15to19 +
    $currentUserPillsTotal20to49;


$currentUserPillsPopTotal10to14 = $pillspopCUBMCount_count10to14 + $pillspopANAPMCount_count10to14 + $pillspopOAPMCount_count10to14 - $pillspopDOPMCount_count10to14;
$currentUserPillsPopTotal15to19 =  $pillspopCUBMCount_count15to19 + $pillspopANAPMCount_count15to19 + $pillspopOAPMCount_count15to19 - $pillspopDOPMCount_count15to19;
$currentUserPillsPopTotal20to49 =  $pillspopCUBMCount_count20to49 + $pillspopANAPMCount_count20to49 + $pillspopOAPMCount_count20to49 - $pillspopDOPMCount_count20to49;

$currentUserPillsPopTotal =
    $currentUserPillsPopTotal10to14 +
    $currentUserPillsPopTotal15to19 +
    $currentUserPillsPopTotal20to49;


$currentUserPillsCocTotal10to14 = $pillscocCUBMCount_count10to14 + $pillscocANAPMCount_count10to14 + $pillscocOAPMCount_count10to14 - $pillscocDOPMCount_count10to14;
$currentUserPillsCocTotal15to19 =  $pillscocCUBMCount_count15to19 + $pillscocANAPMCount_count15to19 + $pillscocOAPMCount_count15to19 - $pillscocDOPMCount_count15to19;
$currentUserPillsCocTotal20to49 =  $pillscocCUBMCount_count20to49 + $pillscocANAPMCount_count20to49 + $pillscocOAPMCount_count20to49 - $pillscocDOPMCount_count20to49;

$currentUserPillsCocTotal =
    $currentUserPillsCocTotal10to14 +
    $currentUserPillsCocTotal15to19 +
    $currentUserPillsCocTotal20to49;
    
    
$currentUserInjectablesTotal10to14 =  $injectablesCUBMCount_count10to14 + $injectablesANAPMCount_count10to14 + $injectablesOAPMCount_count10to14 - $injectablesDOPMCount_count10to14;
$currentUserInjectablesTotal10to14 =  $injectablesCUBMCount_count10to14 + $injectablesANAPMCount_count10to14 + $injectablesOAPMCount_count10to14 - $injectablesDOPMCount_count10to14;