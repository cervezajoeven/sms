<?php

if (!defined('BASEPATH')) {
   exit('No direct script access allowed');
}

class Homework_model extends MY_model
{

   public function __construct()
   {
      parent::__construct();
      $this->load->model('general_model');

      $this->current_session = $this->setting_model->getCurrentSession();
      $this->writedb = $this->load->database('write_db', TRUE);
   }

   public function add($data)
   {
      $this->writedb->trans_start(); # Starting Transaction
      $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
      //=======================Code Start===========================
      if (isset($data["id"]) && $data["id"] > 0) {
         $this->writedb->where("id", $data["id"])->update("homework", $data);
         $message   = UPDATE_RECORD_CONSTANT . " On homework id " . $data['id'];
         $action    = "Update";
         $record_id = $insert_id = $data['id'];
         $this->log($message, $record_id, $action);
      } else {

         $this->writedb->insert("homework", $data);
         $insert_id = $this->writedb->insert_id();
         $message   = INSERT_RECORD_CONSTANT . " On homework id " . $insert_id;
         $action    = "Insert";
         $record_id = $insert_id;
         $this->log($message, $record_id, $action);
      }
      //echo $this->db->last_query();die;
      //======================Code End==============================

      $this->writedb->trans_complete(); # Completing transaction
      /* Optional */

      if ($this->writedb->trans_status() === false) {
         # Something went wrong.
         $this->writedb->trans_rollback();
         return false;
      } else {
         return $insert_id;
      }
      // return $insert_id;
   }

   public function get($id = null)
   {
      $class                    = $this->class_model->get();
      $carray = array();
      foreach ($class as $key => $value) {
         $carray[] = $value['id'];
         $sections = $this->section_model->getClassBySection($value['id']);

         foreach ($sections as $sec => $secdata) {
            $section_array[] = $secdata['section_id'];
         }
      }

      if (!empty($id)) {
         $this->db->select("`homework`.*,subject_group_subjects.subject_id,subject_group_subjects.id as `subject_group_subject_id`,subjects.name as subject_name,subject_groups.id as subject_groups_id,subject_groups.name,(select count(*) as total from submit_assignment where submit_assignment.homework_id=homework.id) as assignments");
         $this->db->join("classes", "classes.id = homework.class_id");
         $this->db->join("sections", "sections.id = homework.section_id");
         $this->db->join("subject_group_subjects", "subject_group_subjects.id = homework.subject_group_subject_id");
         $this->db->join("subjects", "subjects.id = subject_group_subjects.subject_id");

         $this->db->join("subject_groups", "subject_group_subjects.subject_group_id=subject_groups.id");
         $this->db->where('homework.session_id', $this->current_session);
         $this->db->where("homework.id", $id);

         $query = $this->db->get("homework");
         // $query = $this->db->where("id", $id)->get("homework");
         return $query->row_array();
      } else {

         // $query = $this->db->select("homework.*,homework_evaluation.date,classes.class,sections.section,subjects.name")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join("subjects", "subjects.id = homework.subject_id", "left")->join("homework_evaluation", "homework.id = homework_evaluation.homework_id", "left")->group_by("homework.id")->get("homework");

         $this->db->select("`homework`.*,classes.class,sections.section,subject_group_subjects.subject_id,subject_group_subjects.id as `subject_group_subject_id`,subjects.name as subject_name,subject_groups.id as subject_groups_id,subject_groups.name,(select count(*) as total from submit_assignment where submit_assignment.homework_id=homework.id) as assignments");
         $this->db->join("classes", "classes.id = homework.class_id");
         $this->db->join("sections", "sections.id = homework.section_id");
         $this->db->join("subject_group_subjects", "subject_group_subjects.id = homework.subject_group_subject_id");
         $this->db->join("subjects", "subjects.id = subject_group_subjects.subject_id");
         $this->db->join("subject_groups", "subject_group_subjects.subject_group_id=subject_groups.id");
         $this->db->where('homework.session_id', $this->current_session);
         if (!empty($carray)) {
            $this->db->where_in('classes.id', $carray);
         }
         if (!empty($section_array)) {
            $this->db->where_in('sections.id', $section_array);
         }
         $query = $this->db->get("homework");
         return $query->result_array();
      }
   }

   public function get_homeworkDocById($homework_id)
   {
      //$query = $this->db->select('students.*,submit_assignment.docs,submit_assignment.message,submit_assignment.url_link, submit_assignment.created_at')->from('submit_assignment')->join('students', 'students.id=submit_assignment.student_id', 'inner')->where('submit_assignment.homework_id', $homework_id)->get();
      $this->db->select('students.*,submit_assignment.docs,submit_assignment.message,submit_assignment.url_link, submit_assignment.created_at');
      $this->db->join('students', 'students.id=submit_assignment.student_id', 'right');
      $this->db->where('submit_assignment.homework_id', $homework_id);
      $query = $this->db->get('submit_assignment');

      return $query->result_array();
   }

   public function get_homeworkDocById2($homework_id, $classid, $sectionid, $sessionid)
   {
      $sql   = "select * from
               (
               select students.id, students.firstname, students.lastname, students.admission_no, submit_assignment.docs,submit_assignment.message,submit_assignment.url_link, submit_assignment.created_at, submit_assignment.homework_id, homework_evaluation.score, homework_evaluation.remarks, student_session.id as session_id
               from students
               join student_session on student_session.student_id = students.id
               left join submit_assignment on submit_assignment.student_id = students.id
               left join homework_evaluation on homework_evaluation.homework_id = submit_assignment.homework_id and homework_evaluation.student_session_id = student_session.id
               where student_session.class_id = $classid
               and student_session.section_id = $sectionid
               and student_session.session_id = $sessionid
               and students.id not in (select student_id from submit_assignment where homework_id = $homework_id)
               
               union 
               
               select students.id, students.firstname, students.lastname, students.admission_no, submit_assignment.docs,submit_assignment.message,submit_assignment.url_link, submit_assignment.created_at, submit_assignment.homework_id, homework_evaluation.score, homework_evaluation.remarks, student_session.id as session_id
               from students
               left join student_session on student_session.student_id = students.id
               left join submit_assignment on submit_assignment.student_id = students.id
               left join homework_evaluation on homework_evaluation.homework_id = submit_assignment.homework_id and homework_evaluation.student_session_id = student_session.id
               where submit_assignment.homework_id = $homework_id
               and student_session.class_id = $classid
               and student_session.section_id = $sectionid
               and student_session.session_id = $sessionid
               ) tbl
               order by lastname";

      // print_r($sql);
      // die();
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   public function search_homework($class_id, $section_id, $subject_group_id, $subject_id)
   {
      if ((!empty($class_id)) && (!empty($section_id)) && (!empty($subject_id)) && (!empty($subject_group_id))) {

         $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id, 'subject_groups.id' => $subject_group_id, 'subject_group_subjects.id' => $subject_id));
      } else if ((!empty($class_id)) && (!empty($section_id)) && (!empty($subject_group_id))) {

         $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id, 'subject_groups.id' => $subject_group_id));
      } else if ((!empty($class_id)) && (empty($section_id)) && (empty($subject_id))) {

         $this->db->where(array('homework.class_id' => $class_id));
      } else if ((!empty($class_id)) && (!empty($section_id)) && (empty($subject_id))) {

         $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id));
      }

      $this->db->select("`homework`.*,classes.class,sections.section,subject_group_subjects.subject_id,subject_group_subjects.id as `subject_group_subject_id`,subjects.name as subject_name,subject_groups.id as subject_groups_id,subject_groups.name,(select count(*) as total from submit_assignment where submit_assignment.homework_id=homework.id) as assignments");
      $this->db->join("classes", "classes.id = homework.class_id");
      $this->db->join("sections", "sections.id = homework.section_id");
      $this->db->join("subject_group_subjects", "subject_group_subjects.id = homework.subject_group_subject_id");
      $this->db->join("subjects", "subjects.id = subject_group_subjects.subject_id");
      $this->db->join("subject_groups", "subject_group_subjects.subject_group_id=subject_groups.id");
      $this->db->where('subject_groups.session_id', $this->current_session);
      $this->db->order_by('homework.homework_date', 'DESC');
      $query = $this->db->get("homework");

      // print_r($this->db->last_query());
      // die();

      return $query->result_array();
   }

   public function getRecord($id = null)
   {

      $query = $this->db->select("homework.*,classes.class,sections.section,subjects.name,subject_groups.name as subject_group")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join('subject_group_subjects', 'homework.subject_group_subject_id=subject_group_subjects.id')->join("subjects", "subjects.id = subject_group_subjects.subject_id", "left")->join('subject_groups', 'subject_group_subjects.subject_group_id=subject_groups.id')->where("homework.id", $id)->get("homework");

      return $query->row_array();
   }

   public function getStudents($id)
   {
      $sql = "SELECT IFNULL(homework_evaluation.id,0) as homework_evaluation_id,IFNULL(homework_evaluation.score,0) as homework_evaluation_score,IFNULL(homework_evaluation.remarks,'') as homework_evaluation_remarks,student_session.*,students.firstname,students.lastname,students.admission_no from student_session inner JOIN (SELECT homework.id as homework_id,homework.class_id,homework.section_id,homework.session_id FROM `homework` WHERE id= " . $this->db->escape($id) . " ) as home_work on home_work.class_id=student_session.class_id and home_work.section_id=student_session.section_id and home_work.session_id=student_session.session_id inner join students on students.id=student_session.student_id and students.is_active='yes' left join homework_evaluation on homework_evaluation.student_session_id=student_session.id  and students.is_active='yes' and homework_evaluation.homework_id=" . $this->db->escape($id) . "   order by students.lastname asc";

      // $sql = "select students.id,students.firstname,students.lastname,students.admission_no from students where students.id in (select student_session.student_id from student_session where student_session.class_id = " . $this->db->escape($class_id) . " and student_session.section_id = " . $this->db->escape($section_id) . " GROUP by student_session.student_id and student_session.session_id=$this->current_session) and students.is_active = 'yes'";
      $query = $this->db->query($sql);
      // print_r($this->db->last_query());
      // die();
      return $query->result_array();
   }

   public function getStudentHomeworkEval($homeworkid, $studentid)
   {
      $sql = "SELECT IFNULL(homework_evaluation.id,0) as homework_evaluation_id,IFNULL(homework_evaluation.score,0) as homework_evaluation_score,IFNULL(homework_evaluation.remarks,'') as homework_evaluation_remarks,student_session.*,students.firstname,students.lastname,students.admission_no from student_session inner JOIN (SELECT homework.id as homework_id,homework.class_id,homework.section_id,homework.session_id FROM `homework` WHERE id= " . $this->db->escape($homeworkid) . " ) as home_work on home_work.class_id=student_session.class_id and home_work.section_id=student_session.section_id and home_work.session_id=student_session.session_id inner join students on students.id=student_session.student_id and students.is_active='yes' left join homework_evaluation on homework_evaluation.student_session_id=student_session.id  and students.is_active='yes' and homework_evaluation.homework_id=" . $this->db->escape($homeworkid) . " where student_session.student_id = " . $this->db->escape($studentid) . " order by students.lastname asc";

      // $sql = "select students.id,students.firstname,students.lastname,students.admission_no from students where students.id in (select student_session.student_id from student_session where student_session.class_id = " . $this->db->escape($class_id) . " and student_session.section_id = " . $this->db->escape($section_id) . " GROUP by student_session.student_id and student_session.session_id=$this->current_session) and students.is_active = 'yes'";
      $query = $this->db->query($sql);
      print_r($this->db->last_query());
      die();
      return $query->result_array();
   }

   public function delete($id)
   {
      $this->writedb->trans_start(); # Starting Transaction
      $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
      //=======================Code Start===========================
      $this->writedb->where("id", $id)->delete("homework");

      $this->writedb->where("homework_id", $id)->delete("homework_evaluation");
      $this->writedb->where("homework_id", $id)->delete("submit_assignment");

      $message   = DELETE_RECORD_CONSTANT . " On homework id " . $id;
      $action    = "Delete";
      $record_id = $id;
      $this->log($message, $record_id, $action);
      //======================Code End==============================
      $this->writedb->trans_complete(); # Completing transaction
      /* Optional */
      if ($this->writedb->trans_status() === false) {
         # Something went wrong.
         $this->writedb->trans_rollback();
         return false;
      } else {
         //return $return_value;
      }
   }

   public function addEvaluations($insert_prev, $insert_array, $homework_id, $evaluation_date, $evaluated_by, $score_array = array(), $remarks_array = array())
   {
      $this->writedb->trans_start(); # Starting Transaction
      $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
      //=======================Code Start===========================
      $homework = array('evaluation_date' => $evaluation_date, 'evaluated_by' => $evaluated_by);
      $this->writedb->where("id", $homework_id)->update("homework", $homework);
      if (!empty($insert_array)) {
         foreach ($insert_array as $insert_student_key => $insert_student_value) {
            $insert_student = array(
               'homework_id'        => $homework_id,
               'student_session_id' => $insert_student_value,
               'score' =>  $score_array[$insert_student_value],
               'remarks' => $remarks_array[$insert_student_value],
               'status'             => 'Complete',
            );
            $this->writedb->insert("homework_evaluation", $insert_student);
            $insert_prev[] = $this->writedb->insert_id();
         }
      }

      $this->writedb->where('homework_id', $homework_id);
      $this->writedb->where_not_in('id', $insert_prev);
      $this->writedb->delete('homework_evaluation');
      //======================Code End==============================
      $this->writedb->trans_complete(); # Completing transaction
      /* Optional */
      if ($this->writedb->trans_status() === false) {
         # Something went wrong.
         $this->writedb->trans_rollback();
         return false;
      } else {
         return true;
      }
   }

   public function addEvaluation($homework_id, $student_session_id, $score, $remarks)
   {
      $this->writedb->trans_start(); # Starting Transaction
      $this->writedb->trans_strict(false); # See Note 01. If you wish can remove as well
      //=======================Code Start===========================

      $evaluation_date = $this->customlib->dateFormatToYYYYMMDD(date("Y/m/d H:i:s"));
      $evaluated_by = $this->customlib->getStaffID();

      $this->writedb->where('homework_id', $homework_id);
      $this->writedb->where('student_session_id', $student_session_id);
      $this->writedb->delete('homework_evaluation');

      $homework = array('evaluation_date' => $evaluation_date, 'evaluated_by' => $evaluated_by);
      $this->writedb->where("id", $homework_id)->update("homework", $homework);

      $insert_student = array(
         'homework_id' => $homework_id,
         'student_session_id' => $student_session_id,
         'score' =>  $score,
         'remarks' => $remarks,
         'status' => 'Complete',
      );

      $this->writedb->insert("homework_evaluation", $insert_student);
      $insert_prev[] = $this->writedb->insert_id();
      //======================Code End==============================
      $this->writedb->trans_complete(); # Completing transaction
      /* Optional */
      if ($this->writedb->trans_status() === false) {
         # Something went wrong.
         $this->writedb->trans_rollback();
         return false;
      } else {
         return true;
      }
   }

   public function searchHomeworkEvaluation($class_id, $section_id, $subject_id)
   {

      if ((!empty($class_id)) && (!empty($section_id)) && (!empty($subject_id))) {

         $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id, 'homework.subject_id' => $subject_id));
      } else if ((!empty($class_id)) && (empty($section_id)) && (empty($subject_id))) {

         $this->db->where(array('homework.class_id' => $class_id));
      } else if ((!empty($class_id)) && (!empty($section_id)) && (empty($subject_id))) {

         $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id));
      }


      $query = $this->db->select('homework.*,classes.class,sections.section,subjects.name')
         ->join('classes', 'classes.id = homework.class_id')
         ->join('sections', 'sections.id = homework.section_id')
         ->join('subjects', 'subjects.id = homework.subject_id')
         ->where_in('homework.id', 'select homework_evaluation.homework_id from homework_evaluation join homework on (homework_evaluation.homework_id = homework.id) group by homework_evaluation.homework_id')
         ->get('homework');


      return $query->result_array();
   }

   public function getEvaluationReport($id)
   {

      $query = $this->db->select("homework.*,homework_evaluation.student_id,homework_evaluation.id as evalid,homework_evaluation.date,homework_evaluation.status,classes.class,subjects.name,sections.section,(select count(*) as total from submit_assignment sa where sa.homework_id=homework.id) as assignments")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join("subjects", "subjects.id = homework.subject_id")->join("homework_evaluation", "homework.id = homework_evaluation.homework_id")->where("homework.id", $id)->get("homework");

      return $query->result_array();
   }

   public function getEvaStudents($id, $class_id, $section_id)
   {

      $query = $this->db->select("students.*,homework_evaluation.student_id,homework_evaluation.date,homework_evaluation.status,classes.class,subjects.name,sections.section")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join("subjects", "subjects.id = homework.subject_id")->join("homework_evaluation", "homework.id = homework_evaluation.homework_id")->join("students", "students.id = homework_evaluation.student_id", "left")->where("homework.id", $id)->get("homework");
      return $query->result_array();
   }

   public function delete_evaluation($prev_students)
   {

      if (!empty($prev_students)) {

         $this->writedb->where_in("id", $prev_students)->delete("homework_evaluation");
      }
   }

   public function count_students($class_id, $section_id)
   {

      $query = $this->db->select("student_session.student_id")->join("student_session", "students.id = student_session.student_id")->where(array('student_session.class_id' => $class_id, 'student_session.section_id' => $section_id, 'students.is_active' => "yes", 'student_session.session_id' => $this->current_session))->group_by("student_session.student_id")->get("students");

      return $query->num_rows();
   }

   public function count_evalstudents($id, $class_id, $section_id)
   {


      $array['homework.id'] = $id;
      $array['homework.session_id'] = $this->current_session;
      $array['students.is_active'] = 'yes';

      $query = $this->db->select("count(*) as total")->join("homework_evaluation", "homework_evaluation.homework_id = homework.id")->join('student_session', 'student_session.id=homework_evaluation.student_session_id')->join('students', 'students.id=student_session.student_id')->where($array)->get("homework");
      return $query->row_array();
   }

   public function get_homeworkDoc($student_id)
   {
      return $this->db->select('*')->from('submit_assignment')->where('student_id', $student_id)->get()->result_array();
   }

   public function get_homeworkDocByhomework_id($homework_id)
   {
      return $this->db->select('*')->from('submit_assignment')->where('homework_id', $homework_id)->get()->result_array();
   }

   public function getStudentHomeworkWithStatus($class_id, $section_id, $student_session_id)
   {
      $sql   = "SELECT DISTINCT(homework.id), `homework`.*,IFNULL(homework_evaluation.id,0) as homework_evaluation_id,IFNULL(homework_evaluation.score,0) as homework_evaluation_score,IFNULL(homework_evaluation.remarks,'') as homework_evaluation_remarks, `classes`.`class`, `sections`.`section`, `subject_group_subjects`.`subject_id`, 
                  `subject_group_subjects`.`id` as `subject_group_subject_id`, `subjects`.`name` as `subject_name`, `subject_groups`.`id` as `subject_groups_id`, `subject_groups`.`name`, 
                  `staff`.`name`, `staff`.`surname`, submit_assignment.id AS submit_id, CASE WHEN ISNULL(submit_assignment.id) THEN 'No' ELSE 'Yes' END AS submitted
                  FROM `homework` 
                  LEFT JOIN homework_evaluation on homework_evaluation.homework_id=homework.id and homework_evaluation.student_session_id=" . $this->db->escape($student_session_id) .
         " LEFT JOIN submit_assignment ON homework.id = submit_assignment.homework_id AND submit_assignment.student_id = (SELECT student_id FROM student_session WHERE id = " . $this->db->escape($student_session_id) . ") 
                  JOIN `classes` ON `classes`.`id` = `homework`.`class_id` 
                  JOIN `sections` ON `sections`.`id` = `homework`.`section_id` 
                  JOIN `subject_group_subjects` ON `subject_group_subjects`.`id` = `homework`.`subject_group_subject_id` 
                  JOIN `subjects` ON `subjects`.`id` = `subject_group_subjects`.`subject_id` 
                  JOIN `subject_groups` ON `subject_group_subjects`.`subject_group_id`=`subject_groups`.`id` 
                  JOIN `staff` ON `staff`.`id` = `homework`.`staff_id` 
                  WHERE `homework`.`class_id` = " . $this->db->escape($class_id) . " AND `homework`.`section_id` = " . $this->db->escape($section_id) .
         " AND `homework`.`session_id` = " . $this->current_session . " order by homework.homework_date desc";
      // print_r($sql);
      // var_dump($sql);die();
      $query = $this->db->query($sql);
      return $query->result_array();
   }

   // public function getStudentHomeworkWithStatusEMN($class_id, $section_id, $student_session_id)
   // {
   //     $sql   = "SELECT DISTINCT(homework.id), `homework`.*,IFNULL(homework_evaluation.id,0) as homework_evaluation_id, `classes`.`class`, `sections`.`section`, `subject_group_subjects`.`subject_id`, 
   //               `subject_group_subjects`.`id` as `subject_group_subject_id`, `subjects`.`name` as `subject_name`, `subject_groups`.`id` as `subject_groups_id`, `subject_groups`.`name`, submit_assignment.id as submit_id
   //               FROM `homework` 
   //               LEFT JOIN homework_evaluation on homework_evaluation.homework_id=homework.id and homework_evaluation.student_session_id=" . $this->db->escape($student_session_id) . 
   //               " LEFT JOIN submit_assignment ON homework.id = submit_assignment.homework_id 
   //               JOIN `classes` ON `classes`.`id` = `homework`.`class_id` 
   //               JOIN `sections` ON `sections`.`id` = `homework`.`section_id` 
   //               JOIN `subject_group_subjects` ON `subject_group_subjects`.`id` = `homework`.`subject_group_subject_id` 
   //               JOIN `subjects` ON `subjects`.`id` = `subject_group_subjects`.`subject_id` 
   //               JOIN `subject_groups` ON `subject_group_subjects`.`subject_group_id`=`subject_groups`.`id` 
   //               WHERE `homework`.`class_id` = " . $this->db->escape($class_id) . " AND `homework`.`section_id` = " . $this->db->escape($section_id) . " AND `homework`.`session_id` = ".$this->current_session." order by homework.homework_date desc";
   //     // print_r($sql);
   //     var_dump($sql);die();
   //     $query = $this->db->query($sql);
   //     return $query->result_array();
   // }

   public function getStudentHomework($class_id, $section_id)
   {

      $this->db->select("`homework`.*,classes.class,sections.section,subject_group_subjects.subject_id,subject_group_subjects.id as `subject_group_subject_id`,subjects.name as subject_name,subject_groups.id as subject_groups_id,subject_groups.name,(select count(*) as total from submit_assignment where submit_assignment.homework_id=homework.id) as assignments");
      $this->db->join("classes", "classes.id = homework.class_id");
      $this->db->join("sections", "sections.id = homework.section_id");
      $this->db->join("subject_group_subjects", "subject_group_subjects.id = homework.subject_group_subject_id");
      $this->db->join("subjects", "subjects.id = subject_group_subjects.subject_id");
      $this->db->join("subject_groups", "subject_group_subjects.subject_group_id=subject_groups.id");
      $this->db->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id));
      $this->db->where('homework.session_id', $this->current_session);
      $query = $this->db->get("homework");
      return $query->result_array();

      // $query = $this->db->select("homework.*,subjects.name,sections.section,classes.class")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join("subjects", "subjects.id = homework.subject_id")->where(array('homework.class_id' => $class_id, 'homework.section_id' => $section_id))->get("homework");
      // return $query->result_array();
   }

   public function get_HomeworkSubject($subjectgroup_id)
   {
      return $this->db->select('subjects.name as subject,subjects.code')->from('subject_group_subjects')->join('subjects', 'subject_group_subjects.subject_id=subjects.id')->where('subject_group_subjects.subject_group_id', $subjectgroup_id)->get()->result_array();
   }


   public function upload_docs($data)
   {

      $this->db->where('homework_id', $data['homework_id']);
      $this->db->where('student_id', $data['student_id']);
      $q = $this->db->get('submit_assignment');

      if ($q->num_rows() > 0) {
         $this->writedb->where('homework_id', $data['homework_id']);
         $this->writedb->where('student_id', $data['student_id']);
         $this->writedb->update('submit_assignment', $data);
         // print_r($this->writedb->last_query());
         // die();
      } else {

         $this->writedb->insert('submit_assignment', $data);
         // print_r($this->writedb->last_query());
         // die();
      }
   }

   // public function upload_docs($data)
   // {

   //     if (isset($data['id']) && $data['id'] != null) {

   //         $this->db->where("id", $data["id"])->update("submit_assignment", $data);
   //         return $data['id'];
   //     } else {

   //         $this->db->insert("submit_assignment", $data);
   //         return $this->db->insert_id();
   //     }
   // }

   public function get_upload_docs($array)
   {
      return $this->db->select('*')->from('submit_assignment')->where($array)->get()->result_array();
   }

   public function getEvaluationReportForStudent($id, $student_id)
   {

      $query = $this->db->select("homework.*,homework_evaluation.student_id,homework_evaluation.id as evalid,homework_evaluation.date,homework_evaluation.status,homework_evaluation.student_id,classes.class,sections.section")->join("classes", "classes.id = homework.class_id")->join("sections", "sections.id = homework.section_id")->join("homework_evaluation", "homework.id = homework_evaluation.homework_id")->where("homework.id", $id)->get("homework");
      //->where("homework_evaluation.student_id", $student_id)
      $result = $query->result_array();

      foreach ($result as $key => $value) {

         if ($value["student_id"] == $student_id) {

            return $value;
         } else {

            $data = array('date' => $value["date"], 'status' => 'Incomplete');
            return $data;
         }
      }

      //return $query->result_array();
   }

   public function get_homeworkDocBystudentId($homework_id, $student_id)
   {
      $where = array('submit_assignment.homework_id' => $homework_id, 'submit_assignment.student_id' => $student_id);
      $query = $this->db->select('students.*,submit_assignment.docs,submit_assignment.message')->from('submit_assignment')->join('students', 'students.id=submit_assignment.student_id', 'inner')->where($where)->get();
      return $query->result_array();
   }

   public function check_assignment($homework_id, $student_id)
   {
      $status = $this->db->select('*')->from('submit_assignment')->where(array('homework_id' => $homework_id, 'student_id' => $student_id))->get()->num_rows();
      return $status;
   }
}
