<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Gradereport_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        
        //-- Load database for writing
        $this->writedb = $this->load->database('write_db', TRUE);
    }

    public function get($table, $id=null) 
    {
        $this->db->select()->from($table);

        if ($id != null) 
            $this->db->where('id', $id);
            
        $this->db->order_by('id');
        $query = $this->db->get();

        if ($id != null) 
            return $query->row_array();
        else 
            return $query->result_array();
    }

    public function add($table, $data)
    {
        // var_dump($data);die;

        if (isset($data['id'])) {
            $this->writedb->where('id', $data['id']);
            $this->writedb->update($table, $data);
        } else {
            $this->writedb->insert($table, $data);
        }
    }

    public function remove($table, $id)
    {
        $this->writedb->trans_start(); # Starting Transaction
        $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->writedb->where('id', $id);
        $this->writedb->delete($table); 

        // $message   = DELETE_RECORD_CONSTANT . " On ".$table." id " . $id;
        // $action    = "Delete";
        // $record_id = $id;
        // $this->log($message, $record_id, $action);
        //======================Code End==============================
        $this->writedb->trans_complete(); # Completing transaction
        /*Optional*/
        if ($this->writedb->trans_status() === false) {
            # Something went wrong.
            $this->writedb->trans_rollback();
            return false;
        } else {
            //return $return_value;
        }
    }

    function check_data_exists($data, $table, $field) {
        $this->db->where($field, $data[$field]);        
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_class_record($school_year, $quarter, $grade_level, $section) {
        $subject_columns = "";
        $subquery = "";
        $average_column = "";
        $colcount = 0;
        
        $resultdata = $this->get_subject_list($grade_level, $school_year);
        
        foreach($resultdata as $row) {
            if (!empty($subject_columns)) {
                $subject_columns .= ", IFNULL(tbl" . $row->subject_id . ".quarterly_grade, 0) AS '" .$row->subject. "'" ;

                if ($row->in_average) {
                    $average_column .= "+IFNULL(tbl" . $row->subject_id . ".quarterly_grade, 0)";
                    $colcount++;
                }                    
            }
            else {
                $subject_columns .= " IFNULL(tbl" . $row->subject_id . ".quarterly_grade, 0) AS '" .$row->subject. "'" ;
                
                if ($row->in_average) {
                    $average_column .= "IFNULL(tbl" . $row->subject_id . ".quarterly_grade, 0)";
                    $colcount++;
                }                    
            }

            if ($row->transmuted)
                $quarterly_grade = "fn_transmuted_grade(ROUND(IFNULL(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 2)) AS quarterly_grade";
                // $quarterly_grade = "IFNULL(fn_transmuted_grade(ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent), 2)), 0) AS quarterly_grade";
            else 
                $quarterly_grade = "CASE
                                    WHEN MOD(SUM(((total_scores/tot_highest_score)*100) * wspercent), 1) = 0.5
                                      THEN ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent) + 0.1)
                                      ELSE ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent))
                                    END AS quarterly_grade";
                //$quarterly_grade = "IFNULL(ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 0) AS quarterly_grade";

            $subquery .= " LEFT JOIN ( 
                             SELECT school_year, quarter, student_id, grade_level, section_id, subject_id, ".$quarterly_grade."                            
                             FROM 
                             (
                               SELECT school_year, quarter, student_id, grade AS grade_level, section_id, subject_id, SUM(score) AS total_scores, 
                               SUM(highest_score) AS tot_highest_score, criteria_id, label AS criteria_label, (ws/100) AS wspercent 
                               FROM vw_class_record 
                               GROUP BY student_id, criteria_id, label 
                             ) tbl 
                             WHERE subject_id = ".$row->subject_id." 
                             AND section_id  = ".$section." 
                             AND grade_level  = ".$grade_level." 
                             AND school_year = ".$school_year." 
                             AND quarter = ".$quarter." 
                             GROUP BY school_year, quarter, student_id 
                           ) tbl".$row->subject_id." ON tbl".$row->subject_id.".student_id = students.id";            
        }

        // $average_column = " AVG(".$average_column.") AS average";
        $average_column = " ((".$average_column.")/".$colcount.") AS average";

        $sql = "SELECT CONCAT(UPPER(lastname), ', ', UPPER(firstname), ' ', UPPER(middlename)) AS student_name, UPPER(gender) as gender, ".$subject_columns.", ".$average_column." 
                FROM students 
                LEFT JOIN student_session ON student_session.student_id = students.id 
                ".$subquery." 
                WHERE student_session.class_id = ".$grade_level." 
                AND student_session.section_id = ".$section." 
                AND student_session.session_id = ".$school_year." 
                ORDER BY gender DESC, student_name ASC";

        // return $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_subject_list($gradelevel, $schoolyear)
    {
        //-- Get subject list
        $sql = "SELECT classes.id AS grade_level_id, subjects.name AS subject, subject_group_subjects.subject_id, subjects.in_average, subjects.transmuted, subjects.code
                FROM subject_groups
                JOIN subject_group_subjects ON subject_group_subjects.subject_group_id = subject_groups.id
                JOIN subjects ON subjects.id = subject_group_subjects.subject_id
                JOIN subject_group_class_sections ON subject_group_class_sections.subject_group_id = subject_groups.id
                JOIN class_sections ON class_sections.id = subject_group_class_sections.class_section_id
                JOIN classes ON classes.id = class_sections.class_id
                WHERE classes.id = ".$gradelevel." 
                AND subjects.graded = TRUE 
                AND subject_groups.session_id = ".$schoolyear." 
                GROUP BY classes.id, subjects.name
                ORDER BY subject_groups.name, subjects.name ASC";
        // print_r($sql);die();
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_student_class_record($school_year, $student_id, $grade_level, $section) {        
        $subquery = "";
        $quarter_columns = "";
        $average_columns = "";
        $average_column = "";
        $colcount = 0;
        
        $dataresult = $this->get_quarter_list();        

        foreach($dataresult as $row) {
            if (!empty($quarter_columns)) {
                $quarter_columns .= ", IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".str_replace(" ", "_", $row->name)."'";
                $average_column .= "+IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }
            else {
                $quarter_columns .= " IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".str_replace(" ", "_", $row->name)."'";
                $average_column .= "IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }

            //-- IFNULL(ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 0) 
            $subquery .= " LEFT JOIN 
                         (
                            SELECT school_year, quarter, tbl.student_id, grade_level, tbl.section_id, subject_id, 
                            CASE 
                            WHEN grading_allowed_students.view_allowed = 1 
                              THEN 
                                CASE 
                                  WHEN subjects.transmuted = 1 
                                    THEN fn_transmuted_grade(ROUND(IFNULL(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 2)) 
                                    ELSE CASE
                                         WHEN MOD(SUM(((total_scores/tot_highest_score)*100) * wspercent), 1) = 0.5
                                           THEN ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent) + 0.1)
                                           ELSE ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent))
                                         END
                                END
                              ELSE 0 
                            END AS quarterly_grade 
                            FROM
                            (
                              SELECT school_year, quarter, student_id, grade AS grade_level, section_id, subject_id, SUM(score) AS total_scores, 
                              SUM(highest_score) AS tot_highest_score, criteria_id, label AS criteria_label, (ws/100) AS wspercent
                              FROM vw_class_record
                              WHERE section_id  = ".$section." 
                              AND grade  = ".$grade_level." 
                              AND school_year = ".$school_year." 
                              AND quarter = ".$row->id." 
                              AND student_id = ".$student_id." 
                              GROUP BY student_id, criteria_id, label
                            ) tbl
                            LEFT JOIN grading_allowed_students ON grading_allowed_students.student_id = tbl.student_id AND grading_allowed_students.session_id = tbl.school_year AND grading_allowed_students.quarter_id = quarter 
                            LEFT JOIN subjects ON subjects.id = tbl.subject_id
                            GROUP BY school_year, quarter, student_id, subject_id
                         ) tbl".$row->id." ON tbl".$row->id.".subject_id = tblsubjects.subject_id";

            $colcount++;
        }

        $average_columns = " ((".$average_column.")/".$colcount.") AS average";

        $sql = "SELECT subject AS Subjects, $quarter_columns, $average_columns, ROUND((".$average_column.")/".$colcount.") AS final_grade 
                FROM 
                (
                    SELECT classes.id AS grade_level_id, subjects.name AS subject, subject_group_subjects.subject_id
                    FROM subject_groups
                    JOIN subject_group_subjects ON subject_group_subjects.subject_group_id = subject_groups.id
                    JOIN subjects ON subjects.id = subject_group_subjects.subject_id
                    JOIN subject_group_class_sections ON subject_group_class_sections.subject_group_id = subject_groups.id
                    JOIN class_sections ON class_sections.id = subject_group_class_sections.class_section_id
                    JOIN classes ON classes.id = class_sections.class_id
                    WHERE classes.id = ".$grade_level." 
                    AND subjects.graded = TRUE 
                    AND subject_groups.session_id = ".$school_year." 
                    GROUP BY classes.id, subjects.name
                    ORDER BY subject_groups.name, subjects.name ASC
                ) tblsubjects
                ".$subquery;
        
        // return($sql);
        $query = $this->db->query($sql);
        // print_r(json_encode($query->result()));die();
        return $query->result();
    }

    public function get_student_class_record_unrestricted($school_year, $student_id, $grade_level, $section) {        
        $subquery = "";
        $quarter_columns = "";
        $average_columns = "";
        $average_column = "";
        $colcount = 0;
        
        $dataresult = $this->get_quarter_list();        

        foreach($dataresult as $row) {
            if (!empty($quarter_columns)) {
                $quarter_columns .= ", IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".str_replace(" ", "_", $row->name)."'";
                $average_column .= "+IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }
            else {
                $quarter_columns .= " IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".str_replace(" ", "_", $row->name)."'";
                $average_column .= "IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }

            $subquery .= " LEFT JOIN 
                         (
                            SELECT school_year, quarter, tbl.student_id, grade_level, tbl.section_id, subject_id, 
                            CASE 
                              WHEN subjects.transmuted = 1 
                                THEN fn_transmuted_grade(ROUND(IFNULL(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 2)) 
                                ELSE CASE
                                     WHEN MOD(SUM(((total_scores/tot_highest_score)*100) * wspercent), 1) = 0.5
                                       THEN ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent) + 0.1)
                                       ELSE ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent))
                                     END
                            END AS quarterly_grade 
                            FROM
                            (
                              SELECT school_year, quarter, student_id, grade AS grade_level, section_id, subject_id, SUM(score) AS total_scores, 
                              SUM(highest_score) AS tot_highest_score, criteria_id, label AS criteria_label, (ws/100) AS wspercent
                              FROM vw_class_record
                              WHERE section_id  = ".$section." 
                              AND grade  = ".$grade_level." 
                              AND school_year = ".$school_year." 
                              AND quarter = ".$row->id." 
                              AND student_id = ".$student_id." 
                              GROUP BY student_id, criteria_id, label
                            ) tbl
                            LEFT JOIN subjects ON subjects.id = tbl.subject_id
                            GROUP BY school_year, quarter, student_id, subject_id
                         ) tbl".$row->id." ON tbl".$row->id.".subject_id = tblsubjects.subject_id";

            $colcount++;
        }

        $average_columns = " ((".$average_column.")/".$colcount.") AS average";

        $sql = "SELECT subject AS Subjects, $quarter_columns, $average_columns, ROUND((".$average_column.")/".$colcount.") AS final_grade 
                FROM 
                (
                    SELECT classes.id AS grade_level_id, subjects.name AS subject, subject_group_subjects.subject_id
                    FROM subject_groups
                    JOIN subject_group_subjects ON subject_group_subjects.subject_group_id = subject_groups.id
                    JOIN subjects ON subjects.id = subject_group_subjects.subject_id
                    JOIN subject_group_class_sections ON subject_group_class_sections.subject_group_id = subject_groups.id
                    JOIN class_sections ON class_sections.id = subject_group_class_sections.class_section_id
                    JOIN classes ON classes.id = class_sections.class_id
                    WHERE classes.id = ".$grade_level." 
                    AND subjects.graded = TRUE 
                    AND subject_groups.session_id = ".$school_year." 
                    GROUP BY classes.id, subjects.name
                    ORDER BY subject_groups.name, subjects.name ASC
                ) tblsubjects
                ".$subquery;
        
        // return($sql);
        $query = $this->db->query($sql);
        // print_r($this->db->last_query());die();
        return $query->result();
    }

    public function get_quarter_list() {
        $sql = "SELECT * FROM grading_quarter";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_class_record_quarterly($school_year, $grade_level, $section, $subject, $teacher) {
        $quarter_columns = "";        
        $resultdata = $this->get_quarter_list();
        $average_columns = "";
        $average_column = "";
        $subquery = "";
        $colcount = 0;

        foreach($resultdata as $row) {
            if (!empty($quarter_columns)) {
                $quarter_columns .= ", IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".$row->name."'";
                $average_column .= "+IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }
            else {
                $quarter_columns .= " IFNULL(tbl".$row->id.".quarterly_grade, 0) AS '".$row->name."'";
                $average_column .= "IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            }

            $subquery .= " LEFT JOIN 
                         (
                            SELECT school_year, quarter, tbl.student_id, grade_level, tbl.section_id, subject_id, teacher_id, 
                            CASE 
                            WHEN subjects.transmuted = 1 
                              THEN fn_transmuted_grade(ROUND(IFNULL(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 2)) 
                              ELSE CASE
                                     WHEN MOD(SUM(((total_scores/tot_highest_score)*100) * wspercent), 1) = 0.5
                                      THEN ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent) + 0.1)
                                      ELSE ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent))
                                   END
                            END AS quarterly_grade 
                            FROM
                            (
                              SELECT school_year, quarter, student_id, grade AS grade_level, section_id, subject_id, teacher_id, SUM(score) AS total_scores, 
                              SUM(highest_score) AS tot_highest_score, criteria_id, label AS criteria_label, (ws/100) AS wspercent
                              FROM vw_class_record
                              WHERE section_id  = ".$section." 
                              AND grade  = ".$grade_level." 
                              AND school_year = ".$school_year." 
                              AND quarter = ".$row->id." 
                              AND subject_id = ".$subject." 
                              AND teacher_id = ".$teacher." 
                              GROUP BY student_id, criteria_id, label
                            ) tbl
                            LEFT JOIN subjects ON subjects.id = tbl.subject_id
                            GROUP BY school_year, quarter, student_id
                         ) tbl".$row->id." ON tbl".$row->id.".student_id = students.id ";

            $colcount++;
        }

        $average_columns = " ((".$average_column.")/".$colcount.") AS average";

        $sql = "SELECT CONCAT(lastname, ', ', firstname, ' ', middlename) AS student_name, UPPER(gender) AS gender, $quarter_columns, $average_columns, ROUND((".$average_column.")/".$colcount.") AS final_grade 
                FROM students 
                LEFT JOIN student_session ON student_session.student_id = students.id 
                ".$subquery." 
                WHERE student_session.class_id = ".$grade_level." 
                AND student_session.section_id = ".$section." 
                AND student_session.session_id = ".$school_year." 
                ORDER BY gender DESC, student_name ASC";

        // return $sql;
        $query = $this->db->query($sql);
        // print_r($this->db->last_query());die();
        return $query->result();
    }

    public function get_teacher_list() {
        $sql = "SELECT id, CONCAT(TRIM(NAME), ' ', TRIM(surname)) AS teacher 
                FROM staff
                WHERE id IN (SELECT staff_id FROM staff_roles WHERE role_id = 2)
                ORDER BY teacher ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_student_conduct($_year, $_grade_level_id, $_section_id, $_student_id) {
        $sql = "SELECT 
                DISTINCT(grading_conduct_indicators.id),
                grading_conduct_deped_indicators.indicator AS deped_indicators, 
                grading_conduct_core_indicators.core_indicator AS core_indicator,
                grading_conduct_indicators.indicator AS indicators,
                fn_final_conduct($_year, 1, $_grade_level_id, $_section_id, $_student_id, grading_conduct_indicators.id) AS first_quarter,
                fn_final_conduct($_year, 2, $_grade_level_id, $_section_id, $_student_id, grading_conduct_indicators.id) AS second_quarter,
                fn_final_conduct($_year, 3, $_grade_level_id, $_section_id, $_student_id, grading_conduct_indicators.id) AS third_quarter,
                fn_final_conduct($_year, 4, $_grade_level_id, $_section_id, $_student_id, grading_conduct_indicators.id) AS fourth_quarter
                FROM grading_conduct_deped_indicators
                LEFT JOIN grading_conduct_core_indicators ON grading_conduct_core_indicators.deped_indicator_id = grading_conduct_deped_indicators.id
                LEFT JOIN grading_conduct_indicators ON grading_conduct_indicators.core_indicator_id = grading_conduct_core_indicators.id
                LEFT JOIN grading_conduct ON grading_conduct.indicator_id = grading_conduct_indicators.id
                AND grading_conduct.school_year = $_year 
                AND grading_conduct.grade = $_grade_level_id
                AND grading_conduct.section_id = $_section_id
                AND grading_conduct.student_id = $_student_id
                ORDER BY grading_conduct_indicators.id ASC";

        $query = $this->db->query($sql);
        // print_r($this->db->error());die();
        return $query->result();
    }

    public function get_student_conduct_numeric($_school_year, $_grade_level_id, $_section_id, $_student_id) {
        $sql = "SELECT tbl1.conduct_grade AS first_quarter, tbl2.conduct_grade AS second_quarter,
                tbl3.conduct_grade AS third_quarter, tbl4.conduct_grade AS fourth_quarter
                FROM
                (
                SELECT grading_conduct_numeric.student_id, fn_conduct_transmuted_grade(SUM(conduct_num) / COUNT(teacher_id)) AS 'conduct_grade' 
                FROM grading_conduct_numeric
                WHERE school_year = $_school_year
                AND QUARTER = 1
                AND grade_level = $_grade_level_id
                AND section_id = $_section_id
                AND student_id = $_student_id
                ) tbl1
                
                LEFT JOIN 
                (
                SELECT grading_conduct_numeric.student_id, fn_conduct_transmuted_grade(SUM(conduct_num) / COUNT(teacher_id)) AS 'conduct_grade' 
                FROM grading_conduct_numeric
                WHERE school_year = $_school_year
                AND QUARTER = 2
                AND grade_level = $_grade_level_id
                AND section_id = $_section_id
                AND student_id = $_student_id
                ) tbl2 ON tbl2.student_id = tbl1.student_id
                
                LEFT JOIN 
                (
                SELECT grading_conduct_numeric.student_id, fn_conduct_transmuted_grade(SUM(conduct_num) / COUNT(teacher_id)) AS 'conduct_grade' 
                FROM grading_conduct_numeric
                WHERE school_year = $_school_year
                AND QUARTER = 3
                AND grade_level = $_grade_level_id
                AND section_id = $_section_id
                AND student_id = $_student_id
                ) tbl3 ON tbl3.student_id = tbl1.student_id
                
                LEFT JOIN 
                (
                SELECT grading_conduct_numeric.student_id, fn_conduct_transmuted_grade(SUM(conduct_num) / COUNT(teacher_id)) AS 'conduct_grade' 
                FROM grading_conduct_numeric
                WHERE school_year = $_school_year
                AND QUARTER = 4
                AND grade_level = $_grade_level_id
                AND section_id = $_section_id
                AND student_id = $_student_id
                ) tbl4 ON tbl4.student_id = tbl1.student_id";

        // print_r($sql);die();

        $query = $this->db->query($sql);
        return $query->result();

        // $this->db->select('fn_conduct_transmuted_grade(SUM(conduct_num) / COUNT(teacher_id)) AS \'conduct_grade\'');
        // $this->db->from('grading_conduct_numeric');
        // $this->db->where('school_year', $_school_year);
        // $this->db->where('quarter', $_quarter);
        // $this->db->where('grade_level', $_grade_level_id);
        // $this->db->where('section_id', $_section_id);
        // $this->db->where('student_id', $_student_id);
        // $this->db->order_by('description');

        // // $result = $this->db->get()->result_array();
        // $result = $this->db->get()->row();
        // return $result->conduct_grade;
    }

    public function generate_Banig($_school_year, $_grade_level, $_section)
    {
        $quarter_columns = "";        
        $average_columns = "";
        $average_column = "";
        $subquery = "";
        $colcount = 0;

        $quarters = $this->get_quarter_list();
        foreach($quarters as $row) 
        {
            if (!empty($average_column)) 
                $average_column .= "+IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";
            else 
                $average_column .= "IFNULL(tbl" . $row->id . ".quarterly_grade, 0)";

            $subquery .= " LEFT JOIN 
                         (
                            SELECT school_year, quarter, tbl.student_id, grade_level, tbl.section_id, subject_id, teacher_id, 
                            CASE 
                            WHEN subjects.transmuted = 1 
                              THEN fn_transmuted_grade(ROUND(IFNULL(SUM(((total_scores/tot_highest_score)*100) * wspercent), 0), 2)) 
                              ELSE CASE
                                     WHEN MOD(SUM(((total_scores/tot_highest_score)*100) * wspercent), 1) = 0.5
                                      THEN ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent) + 0.1)
                                      ELSE ROUND(SUM(((total_scores/tot_highest_score)*100) * wspercent))
                                   END
                            END AS quarterly_grade 
                            FROM
                            (
                              SELECT school_year, quarter, student_id, grade AS grade_level, section_id, subject_id, teacher_id, SUM(score) AS total_scores, 
                              SUM(highest_score) AS tot_highest_score, criteria_id, label AS criteria_label, (ws/100) AS wspercent
                              FROM vw_class_record
                              WHERE section_id  = ".$_section." 
                              AND grade  = ".$_grade_level." 
                              AND school_year = ".$_school_year." 
                              AND subject_id = ~replace_with_subject_id~ 
                              AND quarter = ".$row->id." 
                              GROUP BY student_id, criteria_id, label
                            ) tbl
                            LEFT JOIN subjects ON subjects.id = tbl.subject_id
                            GROUP BY school_year, quarter, student_id
                         ) tbl".$row->id." ON tbl".$row->id.".student_id = students.id ";

            $colcount++;
        }

        $average_columns = " CEIL((".$average_column.")/".$colcount.") AS average";

        $columns_selected = "";
        $sql = "";
        $left_join_on = "";
        $table_alias = "maintbl";
        $subject_counter = 1;
        $quarter_sum = [];

        // $subject_columns .= ", IFNULL(tbl" . $row->subject_id . ".quarterly_grade, 0) AS '" .$row->subject. "'" ;
        $subjects = $this->get_subject_list($_grade_level, $_school_year);
        foreach($subjects as $row) 
        {
            if (!empty($sql))
            {
                $sql .= " LEFT JOIN ";
                $table_alias = "main_".$row->subject_id;
                $left_join_on = " ON ".$table_alias.".student_name_".$subject_counter." = maintbl.student_name_1 ";                
            }

            //-- get fields to show
            if (empty($columns_selected))
            {
                $columns_selected .= "student_name_".$subject_counter.",gender_".$subject_counter;
            }

            $quarter_columns = "";
            $arrptr = 0;
            foreach($quarters as $qrow) 
            {
                if (!empty($quarter_columns)) 
                    $quarter_columns .= ", IFNULL(tbl".$qrow->id.".quarterly_grade, 0) AS ".$qrow->name."_".$subject_counter;
                else 
                    $quarter_columns .= " IFNULL(tbl".$qrow->id.".quarterly_grade, 0) AS ".$qrow->name."_".$subject_counter;

                $quarter_sum[$arrptr] .= !empty($quarter_sum[$arrptr]) ? " + " : "";
                $quarter_sum[$arrptr] .= $qrow->name."_".$subject_counter;

                $columns_selected .= ",".$qrow->name."_".$subject_counter;

                $arrptr++;
            }

            $columns_selected .= ",average_".$subject_counter;
            
            $sql .= "(SELECT CONCAT(lastname, ', ', firstname, ' ', middlename) AS student_name_".$subject_counter.", UPPER(gender) AS gender_".$subject_counter.", $quarter_columns, ".$average_columns."_".$subject_counter."
                    FROM students 
                    LEFT JOIN student_session ON student_session.student_id = students.id 
                    ".str_replace('~replace_with_subject_id~', $row->subject_id, $subquery)." 
                    WHERE student_session.class_id = ".$_grade_level." 
                    AND student_session.section_id = ".$_section." 
                    AND student_session.session_id = ".$_school_year.") " . $table_alias . $left_join_on;

            $subject_counter++;
        }

        // $main_sql = "SELECT ".$columns_selected.", 
        //              ROUND(((~first_sum~)/~subject_count~), 2) as q1_ave, ROUND(((~second_sum~)/~subject_count~), 2) as q2_ave, ROUND(((~third_sum~)/~subject_count~), 2) as q3_ave, ROUND(((~fourth_sum~)/~subject_count~), 2) as q4_ave, 
        //              ROUND(((((~first_sum~)/~subject_count~) + ((~second_sum~)/~subject_count~) + ((~third_sum~)/~subject_count~) + ((~fourth_sum~)/~subject_count~)) / 4), 3) as comp_ave FROM ";

        $main_sql = "SELECT ".$columns_selected.", ROUND(((~first_sum~)/~subject_count~), 2) as q1_ave, ROUND(((~second_sum~)/~subject_count~), 2) as q2_ave, ROUND(((~third_sum~)/~subject_count~), 2) as q3_ave, ROUND(((~fourth_sum~)/~subject_count~), 2) as q4_ave FROM ";

        $main_sql = str_replace("~first_sum~", $quarter_sum[0], $main_sql);
        $main_sql = str_replace("~second_sum~", $quarter_sum[1], $main_sql);
        $main_sql = str_replace("~third_sum~", $quarter_sum[2], $main_sql);
        $main_sql = str_replace("~fourth_sum~", $quarter_sum[3], $main_sql);

        $main_sql = str_replace("~subject_count~", count($subjects), $main_sql);

        // print_r("SELECT ".$columns_selected.", q1_ave, q2_ave, q3_ave, q4_ave, ROUND(((q1_ave + q2_ave + q3_ave + q4_ave)/4), 3) AS computed_ave
        //          FROM (". $main_sql . $sql . ") supermain ORDER BY gender_1 DESC, student_name_1 ASC"); die();

        $query = $this->db->query("SELECT ".$columns_selected.", q1_ave, q2_ave, q3_ave, q4_ave, ROUND(((q1_ave + q2_ave + q3_ave + q4_ave)/4), 3) AS computed_ave
                                   FROM (". $main_sql . $sql . ") supermain ORDER BY gender_1 DESC, student_name_1 ASC");
        // $query = $this->db->query($main_sql . $sql . " ORDER BY maintbl.gender_1 DESC, maintbl.student_name_1 ASC");

        // print_r($this->db->last_query());die();
        // print_r(json_encode($query->result()));die();
        return $query->result();
    }
}