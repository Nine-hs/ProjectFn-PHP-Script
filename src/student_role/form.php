<?php
require_once '../../config/database/db.php';

if (isset($_POST['studentid'])) {

    $ST_ID = $_POST['studentid'];
    $ST_NUMBER = $_POST['studentnumber'];
    $Faculty = $_POST['faculty'];
    $FNAME = $_POST['stdyfname'];
    $LNAME = $_POST['stdylname'];
    $Major = $_POST['major'];
    $Program = $_POST['program'];
    $Gen = $_POST['generation'];
    $Advisor = $_POST['advisor'];
    $Grade = $_POST['grade'];
    $date = $_POST['dateregis'];
    $BOD = $_POST['birthdate'];
    $Age = $_POST['age'];
    $Race = $_POST['reace'];
    $Ntnal = $_POST['national'];
    $region = $_POST['religion'];
    $HomeNo = $_POST["home_no"];
    $Allay = $_POST['allay'];
    $Street = $_POST['street'];
    $District = $_POST['district'];
    $Area = $_POST['area'];
    $Province = $_POST['province'];
    $Tell = $_POST['tell'];
    $phone = $_POST['phone_number'];
    $numrealation = $_POST['numrealation'];
    $being = $_POST['being'];
    $staywith = $_POST['stay_with'];
    $F_Dad = $_POST['f_father'];
    $F_career = $_POST['f_career'];
    $F_income = $_POST['f_income'];
    $F_phone  = $_POST['f_phone'];
    $M_Mom  = $_POST['m_mother'];
    $M_career = $_POST['m_career'];
    $M_income = $_POST['m_income'];
    $M_phone = $_POST['m_phone'];
    $cur_HomeNo = $_POST['cur_homeno'];
    $cur_allay = $_POST['cur_allay'];
    $cur_street = $_POST['cur_street'];
    $cur_district = $_POST['cur_district'];
    $cur_Area = $_POST['cur_area'];
    $cur_province = $_POST['cur_province'];
    $P_name = $_POST['p_name'];
    $P_career = $_POST['p_career'];
    $P_income = $_POST['p_income'];
    $P_phone = $_POST['p_phone'];
    $P_relation = $_POST['p_relation'];
    $facebook = $_POST['facebook'];
    $statusfamily = $_POST['status_family'];
    $borrow = $_POST['borrow'];
    $scholar = $_POST['scholar'];
    $work = $_POST['work'];
    $pt_ar = $_POST['tp_at'];
    $pt_cate = $_POST['tp_cate'];
    $pt_timepr = $_POST['tp_timeperriod'];
    $pt_income = $_POST['tp_income'];
    $ft_at = $_POST['ft_at'];
    $ft_cate = $_POST['ft_cate'];
    $ft_timepr = $_POST['ft_timeperiod'];
    $ft_income = $_POST['ft_income'];
    $acty_timepr = $_POST['aty_timeperiod'];
    $acty_hour = $_POST['aty_hour'];
    $acty_describe = $_POST['aty_describe'];
    $stdy_describe = $_POST['stdy_describe'];
    $YOS = $_POST['year_old_scholar'];
    $COS = $_POST['cate_old_scholar'];
    $NOS = $_POST['name_old_scholar'];
    $POS = $_POST['perpty_old_scholar'];
    $VOS = $_POST['value_old_scholar'];



    try {
        $YEAR = date('Y');
        $check = "SELECT * FROM formtb WHERE ST_ID = :ID AND YEAR(DATE_) = :YEARS ";
        $query = $conn->prepare($check);
        $query->bindParam(':ID', $ST_ID, PDO::PARAM_STR);
        $query->bindParam(':YEARS', $YEAR, PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {

            $date = date('Y-m-d');
            $sql = "INSERT INTO formtb(ST_ID,ST_NUMBER,F_NAME,L_NAME,ST_FACULTS, ST_MAJORS, ST_PROGRAMS, AD_ID, ST_GEN,ST_GRADE, DATE_, ST_AGE_, BRITH_YEAR, ST_NAT, ST_RACE, ST_RELIGION, ST_HOME,ST_ALLAY, ST_STREET, ST_SUBDIST, ST_DIST, ST_PROVINCE, ST_TELL, ST_PHONE, FACEBOOK,FAMILY_STATUS, FULLNAME_FATHER, FATHER_CAREER, FATHER_INCOME, FATHER_PHONE, FULLNAME_MOTHER, MOTHER_CAREER, MOTHER_INCOME, MOTHER_PHONE, NUM_RELA, BEING_NUM,STAY_WITH, CURR_HOME, CURR_ALLAY, CURR_STREET, CURR_SUBDIST, CURR_DIST, CURR_PROVINCE,PATR_FULLNAME, PATR_CAREER, PATR_INCOME, RELAT, PATR_PHONE, SCH_BORROW, SCHOLAR, Job, PARTTIME_PLACE, P_DETAIL_CARR, P_TIME_PERIOD, P_INCOME, FULLTIME_PLACE, F_DETAIL_CARR,F_TIME_PERIOD, F_INCOME, ACTI_TIME_PERIOD, ACTI_HOURS, ACTI_DESCRIBE, ST_DESCRIPE) VALUES(:ST_ID, :ST_NUMBER,:F_NAME,:L_NAME,:ST_FACULTS ,:ST_MAJORS ,:ST_PROGRAMS ,:AD_ID ,:ST_GEN ,:ST_GRADE ,:DATE_ ,:ST_AGE_ ,:BRITH_YEAR ,:ST_NAT ,:ST_RACE ,:ST_RELIGION ,:ST_HOME ,:ST_ALLAY ,:ST_STREET,:ST_SUBDIST,:ST_DIST,:ST_PROVINCE,:ST_TELL,:ST_PHONE,:FACEBOOK,:FAMILY_STATUS,:FULLNAME_FATHER,:FATHER_CAREER,:FATHER_INCOME,:FATHER_PHONE,:FULLNAME_MOTHER,:MOTHER_CAREER,:MOTHER_INCOME,:MOTHER_PHONE,:NUM_RELA,:BEING_NUM,:STAY_WITH,:CURR_HOME,:CURR_ALLAY,:CURR_STREET,:CURR_SUBDIST,:CURR_DIST,:CURR_PROVINCE,:PATR_FULLNAME,:PATR_CAREER,:PATR_INCOME,:RELAT,:PATR_PHONE,:SCH_BORROW,:SCHOLAR,:Job,:PARTTIME_PLACE,:P_DETAIL_CARR,:P_TIME_PERIOD,:P_INCOME,:FULLTIME_PLACE,:F_DETAIL_CARR,:F_TIME_PERIOD,:F_INCOME,:ACTI_TIME_PERIOD,:ACTI_HOURS,:ACTI_DESCRIBE,:ST_DESCRIPE)";
            $query = $conn->prepare($sql);
            $query->bindParam(':ST_ID', $ST_ID, PDO::PARAM_STR);
            $query->bindParam(':ST_NUMBER', $ST_NUMBER, PDO::PARAM_STR);
            $query->bindParam(':F_NAME', $FNAME, PDO::PARAM_STR);
            $query->bindParam(':L_NAME', $LNAME, PDO::PARAM_STR);
            $query->bindParam(':ST_FACULTS', $Faculty, PDO::PARAM_STR);
            $query->bindParam(':ST_MAJORS', $Major, PDO::PARAM_STR);
            $query->bindParam(':ST_PROGRAMS', $Program, PDO::PARAM_STR);
            $query->bindParam(':AD_ID', $Advisor, PDO::PARAM_STR);
            $query->bindParam(':ST_GEN', $Gen, PDO::PARAM_STR);
            $query->bindParam(':ST_GRADE',  $Grade, PDO::PARAM_STR);
            $query->bindParam(':DATE_', $date, PDO::PARAM_STR);
            $query->bindParam(':ST_AGE_', $Age, PDO::PARAM_STR);
            $query->bindParam(':BRITH_YEAR', $BOD, PDO::PARAM_STR);
            $query->bindParam(':ST_NAT', $Ntnal, PDO::PARAM_STR);
            $query->bindParam(':ST_RACE', $Race, PDO::PARAM_STR);
            $query->bindParam(':ST_RELIGION', $region, PDO::PARAM_STR);
            $query->bindParam(':ST_HOME', $HomeNo, PDO::PARAM_STR);
            $query->bindParam(':ST_ALLAY', $Allay, PDO::PARAM_STR);
            $query->bindParam(':ST_STREET', $Street, PDO::PARAM_STR);
            $query->bindParam(':ST_SUBDIST', $District, PDO::PARAM_STR);
            $query->bindParam(':ST_DIST', $Area, PDO::PARAM_STR);
            $query->bindParam(':ST_PROVINCE', $Province, PDO::PARAM_STR);
            $query->bindParam(':ST_TELL', $Tell, PDO::PARAM_STR);
            $query->bindParam(':ST_PHONE', $phone, PDO::PARAM_STR);
            $query->bindParam(':FACEBOOK', $facebook, PDO::PARAM_STR);
            $query->bindParam(':FAMILY_STATUS', $statusfamily, PDO::PARAM_STR);
            $query->bindParam(':FULLNAME_FATHER', $F_Dad, PDO::PARAM_STR);
            $query->bindParam(':FATHER_CAREER', $F_career, PDO::PARAM_STR);
            $query->bindParam(':FATHER_INCOME', $F_income, PDO::PARAM_STR);
            $query->bindParam(':FATHER_PHONE', $F_phone, PDO::PARAM_STR);
            $query->bindParam(':FULLNAME_MOTHER', $M_Mom, PDO::PARAM_STR);
            $query->bindParam(':MOTHER_CAREER', $M_career, PDO::PARAM_STR);
            $query->bindParam(':MOTHER_INCOME', $M_income, PDO::PARAM_STR);
            $query->bindParam(':MOTHER_PHONE', $M_phone, PDO::PARAM_STR);
            $query->bindParam(':NUM_RELA', $numrealation, PDO::PARAM_STR);
            $query->bindParam(':BEING_NUM', $being, PDO::PARAM_STR);
            $query->bindParam(':STAY_WITH', $staywith, PDO::PARAM_STR);
            $query->bindParam(':CURR_HOME', $cur_HomeNo, PDO::PARAM_STR);
            $query->bindParam(':CURR_ALLAY', $cur_allay, PDO::PARAM_STR);
            $query->bindParam(':CURR_STREET', $cur_street, PDO::PARAM_STR);
            $query->bindParam(':CURR_SUBDIST', $cur_district, PDO::PARAM_STR);
            $query->bindParam(':CURR_DIST', $cur_Area, PDO::PARAM_STR);
            $query->bindParam(':CURR_PROVINCE', $cur_province, PDO::PARAM_STR);
            $query->bindParam(':PATR_FULLNAME', $P_name, PDO::PARAM_STR);
            $query->bindParam(':PATR_CAREER', $P_career, PDO::PARAM_STR);
            $query->bindParam(':PATR_INCOME', $P_income, PDO::PARAM_STR);
            $query->bindParam(':RELAT', $P_relation, PDO::PARAM_STR);
            $query->bindParam(':PATR_PHONE', $P_phone, PDO::PARAM_STR);
            $query->bindParam(':SCH_BORROW', $borrow, PDO::PARAM_STR);
            $query->bindParam(':SCHOLAR', $scholar, PDO::PARAM_STR);
            $query->bindParam(':Job', $work, PDO::PARAM_STR);
            $query->bindParam(':PARTTIME_PLACE', $pt_ar, PDO::PARAM_STR);
            $query->bindParam(':P_DETAIL_CARR', $pt_cate, PDO::PARAM_STR);
            $query->bindParam(':P_TIME_PERIOD', $pt_timepr, PDO::PARAM_STR);
            $query->bindParam(':P_INCOME', $pt_income, PDO::PARAM_STR);
            $query->bindParam(':FULLTIME_PLACE', $ft_at, PDO::PARAM_STR);
            $query->bindParam(':F_DETAIL_CARR', $ft_cate, PDO::PARAM_STR);
            $query->bindParam(':F_TIME_PERIOD', $ft_timepr, PDO::PARAM_STR);
            $query->bindParam(':F_INCOME', $ft_income, PDO::PARAM_STR);
            $query->bindParam(':ACTI_TIME_PERIOD', $ft_timepr, PDO::PARAM_STR);
            $query->bindParam(':ACTI_HOURS', $acty_hour, PDO::PARAM_STR);
            $query->bindParam(':ACTI_DESCRIBE', $acty_describe, PDO::PARAM_STR);
            $query->bindParam(':ST_DESCRIPE', $stdy_describe, PDO::PARAM_STR);
            $count = count($YOS);
            if ($query->execute()) {
                echo "ลงทะเบียนสมัครรับทุนฯสำเร็จ";

                if ($YOS[$count - 1] == null) {
                    $count = 0;
                } else {

                    try {
                        $sqll = "INSERT INTO old_scholarship(OLD_FORM, OLD_SCHO, OLDSCHOLA_YEAR, OLDSCHOLA_CATE, PROPERTY, OLDSCHOLA_VALUE)" .
                            " VALUES (:ID,:NAME,:YEAY,:CATE,:PERTY,:VALUE)";
                        $query = $conn->prepare($sqll);
                        for ($i = 0; $i < $count; $i++) {
                            $insert = $query->execute([':ID' => $ST_ID, ':NAME' => $NOS[$i], ':YEAY' => $YOS[$i], ':CATE' => $COS[$i], ':PERTY' => $POS[$i], ':VALUE' => $VOS[$i]]);
                        }
                        if ($insert) {
                            //echo "<script>window.location.href = 'index.php'</script>";
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            } else {
                echo "มีบางอย่างผิดพลาด";
            }
        } else {
            echo "ไม่อนุญาติให้ลงทะเบียนซ้ำ";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
