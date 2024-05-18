<?php
include_once('./../../config.php');

// ANAPM = Acceptors New Acceptors Previous Month - BTL QUERY
$btlANAPMCount = "
    SELECT
        SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS btlANAPMCount_10_to_14,
        SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS btlANAPMCount_15_to_19,
        SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS btlANAPMCount_20_to_49
    FROM 
        fp_consultation
    INNER JOIN 
        patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
        SELECT 
            patient_id
        FROM 
            fp_information
        WHERE 
            client_type = 'New Acceptor'
        GROUP BY 
            patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
        fp_consultation.method = 'BTL'
        AND fp_consultation.checkup_date <> '0000-00-00'
        AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
        AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)
    ";
    $stmt = $conn->prepare($btlANAPMCount);
    $stmt->bind_param("ss", $toDate, $toDate);
    $stmt->execute();
    $stmt->bind_result($btlANAPMCount_count10to14, $btlANAPMCount_count15to19, $btlANAPMCount_count20to49);
    $stmt->fetch();
    $stmt->close();



// ANAPM = Acceptors New Acceptors Previous Month - NSV QUERY
$nsvANAPMCount = "
        SELECT
        SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nsvANAPMCount_10_to_14,
        SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nsvANAPMCount_15_to_19,
        SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nsvANAPMCount_20_to_49
        FROM 
        fp_consultation
        INNER JOIN 
        patients ON fp_consultation.patient_id = patients.id
        INNER JOIN (
        SELECT 
            patient_id
        FROM 
            fp_information
        WHERE 
            client_type = 'New Acceptor'
        GROUP BY 
            patient_id
        ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
        WHERE 
        fp_consultation.method = 'NSV'
        AND fp_consultation.checkup_date <> '0000-00-00'
        AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
        AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nsv_stmt = $conn->prepare($nsvANAPMCount);
    $nsv_stmt->bind_param("ss", $fromDate, $toDate);
    $nsv_stmt->execute();
    $nsv_stmt->bind_result($nsvANAPMCount_count10to14, $nsvANAPMCount_count15to19, $nsvANAPMCount_count20to49);
    $nsv_stmt->fetch();
    $nsv_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - CONDOM QUERY
$condomANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS condomANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS condomANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS condomANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Condom'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $condom_stmt = $conn->prepare($condomANAPMCount);
    $condom_stmt->bind_param("ss", $fromDate, $toDate);
    $condom_stmt->execute();
    $condom_stmt->bind_result($condomANAPMCount_count10to14, $condomANAPMCount_count15to19, $condomANAPMCount_count20to49);
    $condom_stmt->fetch();
    $condom_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - PILLS QUERY
$pillsANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS pillsANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS pillsANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS pillsANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Pills'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $pills_stmt = $conn->prepare($pillsANAPMCount);
    $pills_stmt->bind_param("ss", $fromDate, $toDate);
    $pills_stmt->execute();
    $pills_stmt->bind_result($pillsANAPMCount_count10to14, $pillsANAPMCount_count15to19, $pillsANAPMCount_count20to49);
    $pills_stmt->fetch();
    $pills_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - PILLS POP QUERY
$pillspopANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS ppopANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS ppopANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS ppopANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Pills-POP'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $pillspop_stmt = $conn->prepare($pillspopANAPMCount);
    $pillspop_stmt->bind_param("ss", $fromDate, $toDate);
    $pillspop_stmt->execute();
    $pillspop_stmt->bind_result($pillspopANAPMCount_count10to14, $pillspopANAPMCount_count15to19, $pillspopANAPMCount_count20to49);
    $pillspop_stmt->fetch();
    $pillspop_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - PILLS COC QUERY
$pillscocANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS pcocANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS pcocANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS pcocANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Pills-COC'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $pillscoc_stmt = $conn->prepare($pillscocANAPMCount);
    $pillscoc_stmt->bind_param("ss", $fromDate, $toDate);
    $pillscoc_stmt->execute();
    $pillscoc_stmt->bind_result($pillscocANAPMCount_count10to14, $pillscocANAPMCount_count15to19, $pillscocANAPMCount_count20to49);
    $pillscoc_stmt->fetch();
    $pillscoc_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - INJECTABLES(DMPA/POI) QUERY
$injectablesANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS injectablesANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS injectablesANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS injectablesANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Injectables (DMPA/POI)'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $injectables_stmt = $conn->prepare($injectablesANAPMCount);
    $injectables_stmt->bind_param("ss", $fromDate, $toDate);
    $injectables_stmt->execute();
    $injectables_stmt->bind_result($injectablesANAPMCount_count10to14, $injectablesANAPMCount_count15to19, $injectablesANAPMCount_count20to49);
    $injectables_stmt->fetch();
    $injectables_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - IUD QUERY
$iudANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS iudANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS iudANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS iudANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'IUD'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $iud_stmt = $conn->prepare($iudANAPMCount);
    $iud_stmt->bind_param("ss", $fromDate, $toDate);
    $iud_stmt->execute();
    $iud_stmt->bind_result($iudANAPMCount_count10to14, $iudANAPMCount_count15to19, $iudANAPMCount_count20to49);
    $iud_stmt->fetch();
    $iud_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - IUD-I QUERY
$iudI_ANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS iudiANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS iudiANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS iudiANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'IUD-I'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $iudI_stmt = $conn->prepare($iudI_ANAPMCount);
    $iudI_stmt->bind_param("ss", $fromDate, $toDate);
    $iudI_stmt->execute();
    $iudI_stmt->bind_result($iudI_ANAPMCount_count10to14, $iudI_ANAPMCount_count15to19, $iudI_ANAPMCount_count20to49);
    $iudI_stmt->fetch();
    $iudI_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - IUD-PP QUERY
$iudPP_ANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS iudppANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS injectablesANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS iudppANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'IUD-PP'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $iudPP_stmt = $conn->prepare($iudPP_ANAPMCount);
    $iudPP_stmt->bind_param("ss", $fromDate, $toDate);
    $iudPP_stmt->execute();
    $iudPP_stmt->bind_result($iudPP_ANAPMCount_count10to14, $iudPP_ANAPMCount_count15to19, $iudPP_ANAPMCount_count20to49);
    $iudPP_stmt->fetch();
    $iudPP_stmt->close();


// // ANAPM = Acceptors New Acceptors Previous Month - NFP-LAM QUERY
// $nfpLAM_ANAPMCount = "
//     SELECT
//     SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfplamANAPMCount_10_to_14,
//     SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfplamANAPMCount_15_to_19,
//     SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfplamANAPMCount_20_to_49
//     FROM 
//     fp_consultation
//     INNER JOIN 
//     patients ON fp_consultation.patient_id = patients.id
//     INNER JOIN (
//     SELECT 
//         patient_id
//     FROM 
//         fp_information
//     WHERE 
//         client_type = 'New Acceptor'
//     GROUP BY 
//         patient_id
//     ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
//     WHERE 
//     fp_consultation.method = 'NFP-LAM'
//     AND fp_consultation.checkup_date <> '0000-00-00'
//     AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
//     AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

//     $nfpLAM_stmt = $conn->prepare($nfpLAM_ANAPMCount);
//     $nfpLAM_stmt->bind_param("ss", $fromDate, $toDate);
//     $nfpLAM_stmt->execute();
//     $nfpLAM_stmt->bind_result($nfpLAM_ANAPMCount_count10to14, $nfpLAM_ANAPMCount_count15to19, $nfpLAM_ANAPMCount_count20to49);
//     $nfpLAM_stmt->fetch();
//     $nfpLAM_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - IMPLANT QUERY
$implantANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS implantANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS implantANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS implantANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'Implant'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $implant_stmt = $conn->prepare($implantANAPMCount);
    $implant_stmt->bind_param("ss", $fromDate, $toDate);
    $implant_stmt->execute();
    $implant_stmt->bind_result($implantANAPMCount_count10to14, $implantANAPMCount_count15to19, $implantANAPMCount_count20to49);
    $implant_stmt->fetch();
    $implant_stmt->close();


// ANAPM = Acceptors New Acceptors Previous Month - NFP-LAM QUERY
$nfplamANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfplamANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfplamANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfplamANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'NFP-LAM'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nfplam_stmt = $conn->prepare($nfplamANAPMCount);
    $nfplam_stmt->bind_param("ss", $fromDate, $toDate);
    $nfplam_stmt->execute();
    $nfplam_stmt->bind_result($nfplamANAPMCount_count10to14, $nfplamANAPMCount_count15to19, $nfplamANAPMCount_count20to49);
    $nfplam_stmt->fetch();
    $nfplam_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - NFP-BBT QUERY
$nfpbbtANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfpbbtANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfpbbtANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfpbbtANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'NFP-BBT'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nfpbbt_stmt = $conn->prepare($nfpbbtANAPMCount);
    $nfpbbt_stmt->bind_param("ss", $fromDate, $toDate);
    $nfpbbt_stmt->execute();
    $nfpbbt_stmt->bind_result($nfpbbtANAPMCount_count10to14, $nfpbbtANAPMCount_count15to19, $nfpbbtANAPMCount_count20to49);
    $nfpbbt_stmt->fetch();
    $nfpbbt_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - NFP-CMM QUERY
$nfpcmmANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfpcmmANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfpcmmANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfpcmmANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'NFP-CMM'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nfpcmm_stmt = $conn->prepare($nfpcmmANAPMCount);
    $nfpcmm_stmt->bind_param("ss", $fromDate, $toDate);
    $nfpcmm_stmt->execute();
    $nfpcmm_stmt->bind_result($nfpcmmANAPMCount_count10to14, $nfpcmmANAPMCount_count15to19, $nfpcmmANAPMCount_count20to49);
    $nfpcmm_stmt->fetch();
    $nfpcmm_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - NFP-STM QUERY
$nfpstmANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfpstmANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfpstmANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfpstmANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'NFP-STM'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nfpstm_stmt = $conn->prepare($nfpstmANAPMCount);
    $nfpstm_stmt->bind_param("ss", $fromDate, $toDate);
    $nfpstm_stmt->execute();
    $nfpstm_stmt->bind_result($nfpstmANAPMCount_count10to14, $nfpstmANAPMCount_count15to19, $nfpstmANAPMCount_count20to49);
    $nfpstm_stmt->fetch();
    $nfpstm_stmt->close();

// ANAPM = Acceptors New Acceptors Previous Month - NFP-SDM QUERY
$nfpsdmANAPMCount = "
    SELECT
    SUM(CASE WHEN patients.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS nfpsdmANAPMCount_10_to_14,
    SUM(CASE WHEN patients.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS nfpsdmANAPMCount_15_to_19,
    SUM(CASE WHEN patients.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS nfpsdmANAPMCount_20_to_49
    FROM 
    fp_consultation
    INNER JOIN 
    patients ON fp_consultation.patient_id = patients.id
    INNER JOIN (
    SELECT 
        patient_id
    FROM 
        fp_information
    WHERE 
        client_type = 'New Acceptor'
    GROUP BY 
        patient_id
    ) AS fp_info ON fp_consultation.patient_id = fp_info.patient_id
    WHERE 
    fp_consultation.method = 'NFP-SDM'
    AND fp_consultation.checkup_date <> '0000-00-00'
    AND MONTH(fp_consultation.checkup_date) = MONTH(? - INTERVAL 1 MONTH)
    AND YEAR(fp_consultation.checkup_date) = YEAR(? - INTERVAL 1 MONTH)";

    $nfpsdm_stmt = $conn->prepare($nfpsdmANAPMCount);
    $nfpsdm_stmt->bind_param("ss", $fromDate, $toDate);
    $nfpsdm_stmt->execute();
    $nfpsdm_stmt->bind_result($nfpsdmANAPMCount_count10to14, $nfpsdmANAPMCount_count15to19, $nfpsdmANAPMCount_count20to49);
    $nfpsdm_stmt->fetch();
    $nfpsdm_stmt->close();


$btlANAPMCount_countTotal = $btlANAPMCount_count10to14 + $btlANAPMCount_count15to19 + $btlANAPMCount_count20to49;
$nsvANAPMCount_countTotal = $nsvANAPMCount_count10to14 + $nsvANAPMCount_count15to19 + $nsvANAPMCount_count20to49;
$condomANAPMCount_countTotal = $condomANAPMCount_count10to14 + $condomANAPMCount_count15to19 + $condomANAPMCount_count20to49;
$pillsANAPMCount_counTotal = $pillsANAPMCount_count10to14 + $pillsANAPMCount_count15to19 + $pillsANAPMCount_count20to49;
$pillspopANAPMCount_counTotal = $pillspopANAPMCount_count10to14 + $pillspopANAPMCount_count15to19 + $pillspopANAPMCount_count20to49;
$pillscocANAPMCount_counTotal = $pillscocANAPMCount_count10to14 + $pillscocANAPMCount_count15to19 + $pillscocANAPMCount_count20to49;
$injectablesANAPMCount_countTotal = $injectablesANAPMCount_count10to14 + $injectablesANAPMCount_count15to19 + $injectablesANAPMCount_count20to49;
$iudANAPMCount_countTotal = $iudANAPMCount_count10to14 + $iudANAPMCount_count15to19 + $iudANAPMCount_count20to49;
$iudI_ANAPMCount_countTotal = $iudI_ANAPMCount_count10to14 + $iudI_ANAPMCount_count15to19 + $iudI_ANAPMCount_count20to49;
$iudPP_ANAPMCount_countTotal = $iudPP_ANAPMCount_count10to14 + $iudPP_ANAPMCount_count15to19 + $iudPP_ANAPMCount_count20to49;
$implantANAPMCount_countTotal = $implantANAPMCount_count10to14 + $implantANAPMCount_count15to19 + $implantANAPMCount_count20to49;
$iudI_ANAPMCount_countTotal = $iudI_ANAPMCount_count10to14 + $iudI_ANAPMCount_count15to19 + $iudI_ANAPMCount_count20to49;
$iudPP_ANAPMCount_countTotal = $iudPP_ANAPMCount_count10to14 + $iudPP_ANAPMCount_count15to19 + $iudPP_ANAPMCount_count20to49;
$nfplamANAPMCount_countTotal = $nfplamANAPMCount_count10to14 + $nfplamANAPMCount_count15to19 + $nfplamANAPMCount_count20to49;
$nfpbbtANAPMCount_countTotal = $nfpbbtANAPMCount_count10to14 + $nfpbbtANAPMCount_count15to19 + $nfpbbtANAPMCount_count20to49;
$nfpcmmANAPMCount_countTotal = $nfpcmmANAPMCount_count10to14 + $nfpcmmANAPMCount_count15to19 + $nfpcmmANAPMCount_count20to49;
$nfpstmANAPMCount_countTotal = $nfpstmANAPMCount_count10to14 + $nfpstmANAPMCount_count15to19 + $nfpstmANAPMCount_count20to49;
$nfpsdmANAPMCount_countTotal = $nfpsdmANAPMCount_count10to14 + $nfpsdmANAPMCount_count15to19 + $nfpsdmANAPMCount_count20to49;




?>