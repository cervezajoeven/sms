<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('form-builder');
        $this->load->config('app-config');
        $this->load->library(array('mailer', 'form_builder'));
        $this->load->helper(array('directory', 'customfield', 'custom', 'email'));
        $this->load->model(array('frontcms_setting_model', 'complaint_Model', 'Visitors_model', 'onlinestudent_model', 'customfield_model'));
        $this->blood_group = $this->config->item('bloodgroup');
        $this->load->library('Ajax_pagination');
        $this->load->library('module_lib');
        $this->banner_content         = $this->config->item('ci_front_banner_content');
        $this->perPage                = 12;
        $ban_notice_type              = $this->config->item('ci_front_notice_content');
        $this->data['banner_notices'] = $this->cms_program_model->getByCategory($ban_notice_type, array('start' => 0, 'limit' => 5));
    }

    public function show_404()
    {
        $this->load->view('errors/error_message');
    }

    public function index()
    {
        $setting                     = $this->frontcms_setting_model->get();
        $this->data['active_menu']   = 'home';
        $this->data['page_side_bar'] = $setting->is_active_sidebar;
        $home_page                   = $this->config->item('ci_front_home_page_slug');
        $result                      = $this->cms_program_model->getByCategory($this->banner_content);
        $this->data['page']          = $this->cms_page_model->getBySlug($home_page);

        if (!empty($result)) {
            $this->data['banner_images'] = $this->cms_program_model->front_cms_program_photos($result[0]['id']);
        }

        $this->load_theme('home');
    }

    public function page($slug)
    {
        $page = $this->cms_page_model->getBySlug($slug);
        if (!$page) {
            $this->data['page'] = $this->cms_page_model->getBySlug('404-page');
        } else {

            $this->data['page'] = $this->cms_page_model->getBySlug($slug);
        }

        if ($page['is_homepage']) {
            redirect('frontend');
        }
        $this->data['active_menu']       = $slug;
        $this->data['page_side_bar']     = $this->data['page']['sidebar'];
        $this->data['page_content_type'] = "";
        if (!empty($this->data['page']['category_content'])) {
            $content_array = $this->data['page']['category_content'];
            reset($content_array);
            $first_key            = key($content_array);
            $totalRec             = count($this->cms_program_model->getByCategory($content_array[$first_key]));
            $config['target']     = '#postList';
            $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page']   = $this->perPage;
            $config['link_func']  = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            //get the posts data
            $this->data['page']['category_content'][$first_key] = $this->cms_program_model->getByCategory($content_array[$first_key], array('limit' => $this->perPage));

            $this->data['page_content_type']                    = $content_array[$first_key];
            //load the view
        }
        $this->data['page_form'] = false;

        if (strpos($page['description'], '[form-builder:') !== false) {
            $this->data['page_form'] = true;
            $start                   = '[form-builder:';
            $end                     = ']';
           
            $form_name = $this->customlib->getFormString($page['description'], $start, $end);
           
            $form = $this->config->item($form_name);

            $this->data['form_name'] = $form_name;
            $this->data['form']      = $form;

            if (!empty($form)) {
                foreach ($form as $form_key => $form_value) {
                    if (isset($form_value['validation'])) {
                        $display_string = ucfirst(preg_replace('/[^A-Za-z0-9\-]/', ' ', $form_value['id']));
                        $this->form_validation->set_rules($form_value['id'], $display_string, $form_value['validation']);
                    }
                }
                if ($this->form_validation->run() == false) {

                } else {
                    $setting = $this->frontcms_setting_model->get();

                    $response_message = $form['email_title']['mail_response'];
                    $record           = $this->input->post();

                    if ($record['form_name'] == 'contact_us') {
                        $email     = $this->input->post('email');
                        $name      = $this->input->post('name');
                        $cont_data = array(
                            'name'    => $name . " (" . $email . ")",
                            'source'  => 'Online',
                            'email'   => $this->input->post('email'),
                            'purpose' => $this->input->post('subject'),
                            'date'    => date('Y-m-d'),
                            'note'    => $this->input->post('description') . " (Sent from online front site)",
                        );
                        $visitor_id = $this->Visitors_model->add($cont_data);
                    }

                    if ($record['form_name'] == 'complain') {
                        $complaint_data = array(
                            'complaint_type' => 'General',
                            'source'         => 'Online',
                            'name'           => $this->input->post('name'),
                            'email'          => $this->input->post('email'),
                            'contact'        => $this->input->post('contact_no'),
                            'date'           => date('Y-m-d'),
                            'description'    => $this->input->post('description'),
                        );
                        $complaint_id = $this->complaint_Model->add($complaint_data);
                    }

                    $email_subject = $record['email_title'];
                    $mail_body     = "";
                    unset($record['email_title']);
                    unset($record['submit']);
                    foreach ($record as $fetch_k_record => $fetch_v_record) {
                        $mail_body .= ucwords($fetch_k_record) . ": " . $fetch_v_record;
                        $mail_body .= "<br/>";
                    }
                    if (!empty($setting) && $setting->contact_us_email != "") {

                        $this->mailer->send_mail($setting->contact_us_email, $email_subject, $mail_body);
                    }

                    $this->session->set_flashdata('msg', $response_message);
                    redirect('page/' . $slug, 'refresh');
                }
            }
        }

        $this->load_theme('pages/page');
    }

    public function ajaxPaginationData()
    {
        $page              = $this->input->post('page');
        $page_content_type = $this->input->post('page_content_type');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['page_content_type'] = $page_content_type;
        //total rows count
        $totalRec = count($this->cms_program_model->getByCategory($page_content_type));
        //pagination configuration
        $config['target']     = '#postList';
        $config['base_url']   = base_url() . 'welcome/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $config['link_func']  = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        //get the posts data
        $data['category_content'] = $this->cms_program_model->getByCategory($page_content_type, array('start' => $offset, 'limit' => $this->perPage));
        //load the view
        $this->load->view('themes/default/pages/ajax-pagination-data', $data, false);
    }

    public function read($slug)
    {

        $this->data['active_menu'] = 'home';
        $page                      = $this->cms_program_model->getBySlug($slug);

        $this->data['page_side_bar']  = $page['sidebar'];
        $this->data['featured_image'] = $page['feature_image'];
        $this->data['page']           = $page;
        $this->load_theme('pages/read');
    }

    public function getSections()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $class_id = $this->input->post('class_id');
            $data     = $this->section_model->getClassBySectionAll($class_id);
            echo json_encode($data);
        }
    }

    public function admission()
    {
        if($this->module_lib->hasActive('online_admission')) {
            $this->data['active_menu'] = 'home';
            $page                      = array('title' => 'Online Admission Form', 'meta_title' => 'online admission form', 'meta_keyword' => 'online admission form', 'meta_description' => 'online admission form');

            $this->data['page_side_bar'] = false;
            $this->data['featured_image'] = false;
            $this->data['page'] = $page;
            ///============
            $this->data['form_admission'] = $this->setting_model->getOnlineAdmissionStatus();

            ///////===
            $genderList = $this->customlib->getGender();
            $this->data['genderList'] = $genderList;
            $this->data['title'] = 'Add Student';
            $this->data['title_list'] = 'Recently Added Student';

            $data["student_categorize"] = 'class';
            $session = $this->setting_model->getCurrentSession();
        
            $class = $this->class_model->getAll();
            $this->data['classlist'] = $class;
            $userdata = $this->customlib->getUserData();

            $category = $this->category_model->get();
            $this->data['categorylist'] = $category;        
            $this->data['schoolname'] = $this->setting_model->getCurrentSchoolName();

            $enrollment_type = $this->input->post('enrollment_type');

            if ($enrollment_type == 'old') 
            {                
                $this->form_validation->set_rules('studentidnumber', $this->lang->line('required'), 'trim|required|xss_clean');
            }                
            else 
            {
                $this->form_validation->set_rules('father_name', $this->lang->line('required'), 'trim|required|xss_clean');
                
                $this->form_validation->set_rules('father_occupation', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_name', $this->lang->line('required'), 'trim|required|xss_clean');
                
                $this->form_validation->set_rules('mother_occupation', $this->lang->line('required'), 'trim|required|xss_clean');
                
                $this->form_validation->set_rules('father_company_name', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_company_position', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_mobile', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_nature_of_business', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_dob', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_citizenship', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_religion', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_highschool', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_college', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_college_course', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_prof_affiliation', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_prof_affiliation_position', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('father_tech_prof', $this->lang->line('required'), 'trim|required|xss_clean');

                $this->form_validation->set_rules('mother_company_name', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_company_position', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_mobile', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_nature_of_business', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_dob', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_citizenship', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_religion', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_highschool', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_college', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_college_course', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_prof_affiliation', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_prof_affiliation_position', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('mother_tech_prof', $this->lang->line('required'), 'trim|required|xss_clean');

                $this->form_validation->set_rules('marriage', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('dom', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('church', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('family_together', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('parents_away', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('parents_civil_status', $this->lang->line('required'), 'trim|required|xss_clean');

                $this->form_validation->set_rules('guardian_is', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_name', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_phone', $this->lang->line('required'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('guardian_email', $this->lang->line('required'), 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_rules('guardian_occupation', $this->lang->line('required'), 'trim|required|valid_email|xss_clean');
                $this->form_validation->set_rules('guardian_address', $this->lang->line('required'), 'trim|required|valid_email|xss_clean');
                
            }

            $this->form_validation->set_rules('enrollment_type', $this->lang->line('required'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('mode_of_payment', $this->lang->line('required'), 'trim|required|xss_clean');            
            $this->form_validation->set_rules('email', $this->lang->line('required'), 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('firstname', $this->lang->line('required'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('lastname', $this->lang->line('required'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('gender', $this->lang->line('genrequiredder'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('dob', $this->lang->line('required'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('class_id', $this->lang->line('required'), 'trim|required|xss_clean');
            
            // if (empty($_FILES['document']['name']))
            // {
            //     $this->form_validation->set_rules('document', $this->lang->line('document'), 'required');
            // }

            if ($this->form_validation->run() == false) {
                $this->load_theme('pages/admission');
            } 
            else 
            {
                //==============
                $document_validate = true;
                $file_validate    = $this->config->item('file_validate');

                if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                    $file_type         = $_FILES["document"]['type'];
                    $file_size         = $_FILES["document"]["size"];
                    $file_name         = $_FILES["document"]["name"];
                    $allowed_extension = $file_validate['allowed_extension'];
                    $ext               = pathinfo($file_name, PATHINFO_EXTENSION);
                    $allowed_mime_type = $file_validate['allowed_mime_type'];
                    // var_dump($file_type);
                    // var_dump($file_size);
                    // var_dump($file_name);
                    // var_dump($allowed_extension);
                    // var_dump($allowed_mime_type);die;

                    if ($files = filesize($_FILES['document']['tmp_name'])) {                    
                        if (!in_array($file_type, $allowed_mime_type)) {
                            $this->data['error_message'] = 'File Type Not Allowed';
                            $document_validate           = false;
                        }

                        if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                            $this->data['error_message'] = 'Extension Not Allowed';
                            $document_validate           = false;
                        }
                        if ($file_size > $file_validate['upload_size']) {
                            $this->data['error_message'] = 'File should be less than' . number_format($file_validate['upload_size'] / 1048576, 2) . " MB";
                            $document_validate           = false;
                        }
                    }
                }

                //=====================
                if ($document_validate) {
                    $class_id   = $this->input->post('class_id');
                    $section_id = $this->onlinestudent_model->GetSectionID('No Section'); //--Assign "No Section" for online admissions

                    //--Get Class_Section_ID
                    $class_section_id = $this->onlinestudent_model->GetClassSectionID($class_id, $section_id);
                    $current_session = $this->setting_model->getCurrentSession();

                    if ($enrollment_type == 'old')
                    {
                        $old_student_data = $this->student_model->GetStudentByRollNo($this->input->post('studentidnumber'));
                        //var_dump($old_student_data);die;
                        //$old_student_data = $this->student_model->GetStudentByLRNNo($this->input->post('studentidnumber'));
                        //var_dump($this->input->post('studentidnumber'));die;
                        $has_admission = $this->onlinestudent_model->HasPendingAdmission($old_student_data->firstname, $old_student_data->lastname, date('Y-m-d', strtotime($old_student_data->dob)));
                        //var_dump($has_admission);die;

                        $data = array(
                            'roll_no'             => $old_student_data->roll_no,
                            'lrn_no'              => $old_student_data->lrn_no,
                            'firstname'           => $old_student_data->firstname,
                            'lastname'            => $old_student_data->lastname,
                            'mobileno'            => $old_student_data->mobileno,
                            'guardian_is'         => $old_student_data->guardian_is,
                            'dob'                 => $this->input->post('dob') != '' ? date('Y-m-d', strtotime($this->input->post('dob'))) : date('Y-m-d', strtotime($old_student_data->dob)),
                            'current_address'     => $old_student_data->current_address,
                            'permanent_address'   => $old_student_data->permanent_address,
                            'father_name'         => $old_student_data->father_name,
                            'father_phone'        => $old_student_data->father_phone,
                            'father_occupation'   => $old_student_data->father_occupation,
                            'mother_name'         => $old_student_data->mother_name,
                            'mother_phone'        => $old_student_data->mother_phone,
                            'mother_occupation'   => $old_student_data->mother_occupation,
                            'guardian_occupation' => $old_student_data->guardian_occupation,
                            'guardian_email'      => $old_student_data->guardian_email == '' ? $this->input->post('email') : $old_student_data->guardian_email,
                            'gender'              => $this->input->post('gender') != '' ? $this->input->post('gender') : $old_student_data->gender,
                            'guardian_name'       => $old_student_data->guardian_name,
                            'guardian_relation'   => $old_student_data->guardian_relation,
                            'guardian_phone'      => $old_student_data->guardian_phone,
                            'guardian_address'    => $old_student_data->guardian_address,
                            'admission_date'      => date('Y/m/d'),
                            'measurement_date'    => date('Y/m/d'),
                            'mode_of_payment'     => $this->input->post('mode_of_payment'),
                            'enrollment_type'     => $enrollment_type,                        
                            'middlename'          => $old_student_data->middlename,
                            'email'               => $this->input->post('email'),
                            'class_section_id'    => $class_section_id,

                            'father_company_name'              => $old_student_data->father_company_name,
                            'father_company_position'          => $old_student_data->father_company_position,
                            'father_nature_of_business'        => $old_student_data->father_nature_of_business,
                            'father_mobile'                    => $old_student_data->father_mobile,
                            'father_dob'                       => date('Y-m-d', strtotime($old_student_data->father_dob)),
                            'father_citizenship'               => $old_student_data->father_citizenship,
                            'father_religion'                  => $old_student_data->father_religion,
                            'father_highschool'                => $old_student_data->father_highschool,
                            'father_college'                   => $old_student_data->father_college,
                            'father_college_course'            => $old_student_data->father_college_course,
                            'father_post_graduate'             => $old_student_data->father_post_graduate,
                            'father_post_course'               => $old_student_data->father_post_course,
                            'father_prof_affiliation'          => $old_student_data->father_prof_affiliation,
                            'father_prof_affiliation_position' => $old_student_data->father_prof_affiliation_position,
                            'father_tech_prof'                 => $old_student_data->father_tech_prof,
                            'father_tech_prof_other'           => $old_student_data->father_tech_prof_other,

                            'mother_company_name'              => $old_student_data->mother_company_name,
                            'mother_company_position'          => $old_student_data->mother_company_position,
                            'mother_nature_of_business'        => $old_student_data->mother_nature_of_business,
                            'mother_mobile'                    => $old_student_data->mother_mobile,
                            'mother_dob'                       => date('Y-m-d', strtotime($old_student_data->mother_dob)),
                            'mother_citizenship'               => $old_student_data->mother_citizenship,
                            'mother_religion'                  => $old_student_data->mother_religion,
                            'mother_highschool'                => $old_student_data->mother_highschool,
                            'mother_college'                   => $old_student_data->mother_college,
                            'mother_college_course'            => $old_student_data->mother_college_course,
                            'mother_post_graduate'             => $old_student_data->mother_post_graduate,
                            'mother_post_course'               => $old_student_data->mother_post_course,
                            'mother_prof_affiliation'          => $old_student_data->mother_prof_affiliation,
                            'mother_prof_affiliation_position' => $old_student_data->mother_prof_affiliation_position,
                            'mother_tech_prof'                 => $old_student_data->mother_tech_prof,
                            'mother_tech_prof_other'           => $old_student_data->mother_tech_prof_other,

                            'marriage'                   => $old_student_data->marriage,
                            'dom'                        => $old_student_data->dom,
                            'church'                     => $old_student_data->church,
                            'family_together'            => $old_student_data->family_together,
                            'parents_away'               => $old_student_data->parents_away,
                            'parents_away_state'         => $old_student_data->parents_away_state,
                            'parents_civil_status'       => $old_student_data->parents_civil_status,
                            'parents_civil_status_other' => $old_student_data->parents_civil_status_other,

                            'session_id' => $current_session,
                        );

                        if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                            $time     = md5($_FILES["document"]['name'] . microtime());
                            $fileInfo = pathinfo($_FILES["document"]["name"]);
                            $doc_name = $time . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["document"]["tmp_name"], "./uploads/student_documents/online_admission_doc/" . $doc_name);
    
                            $data['document'] = $doc_name;
                        }

                        // var_dump($data);die;

                        //if ($has_admission == NULL)
                        if (sizeOf($has_admission) <= 0)
                        {
                            $insert_id = $this->onlinestudent_model->add($data);
                            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                        }
                        else 
                        {
                            if ($current_session > (int)$has_admission->session_id && (int)$old_student_data->session_id != $current_session)
                            {
                                $insert_id = $this->onlinestudent_model->add($data);
                                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                            }
                            else 
                            {
                                if ((int)$old_student_data->session_id == $current_session)
                                {
                                    $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$old_student_data->firstname.' '.$old_student_data->lastname.' '.$this->lang->line('already_enrolled') . '</div>');
                                }
                                else if ($has_admission->is_enroll == '0')
                                    $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$old_student_data->firstname.' '.$old_student_data->lastname.' '.$this->lang->line('has_pending_admission') . '</div>');
                                // else 
                                //     $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$old_student_data->firstname.' '.$old_student_data->lastname.' '.$this->lang->line('already_enrolled') . '</div>');                        
                            }
                        }
                    }
                    else 
                    {
                        $has_admission = $this->onlinestudent_model->HasPendingAdmission($this->input->post('firstname'), $this->input->post('lastname'), date('Y-m-d', strtotime($this->input->post('dob'))));

                        $data = array(
                            'firstname'           => $this->input->post('firstname'),
                            'lastname'            => $this->input->post('lastname'),
                            'mobileno'            => $this->input->post('mobileno'),
                            'guardian_is'         => $this->input->post('guardian_is'),
                            'dob'                 => date('Y-m-d', strtotime($this->input->post('dob'))),
                            'current_address'     => $this->input->post('current_address'),
                            'permanent_address'   => $this->input->post('permanent_address'),
                            'father_name'         => $this->input->post('father_name'),
                            'father_phone'        => $this->input->post('father_phone'),
                            'father_occupation'   => $this->input->post('father_occupation'),
                            'mother_name'         => $this->input->post('mother_name'),
                            'mother_phone'        => $this->input->post('mother_phone'),
                            'mother_occupation'   => $this->input->post('mother_occupation'),
                            'guardian_occupation' => $this->input->post('guardian_occupation'),
                            'guardian_email'      => $this->input->post('guardian_email'),
                            'gender'              => $this->input->post('gender'),
                            'guardian_name'       => $this->input->post('guardian_name'),
                            'guardian_relation'   => $this->input->post('guardian_relation'),
                            'guardian_phone'      => $this->input->post('guardian_phone'),
                            'guardian_address'    => $this->input->post('guardian_address'),
                            'admission_date'      => date('Y/m/d'),
                            'measurement_date'    => date('Y/m/d'),
                            'mode_of_payment'     => $this->input->post('mode_of_payment'),
                            'enrollment_type'     => $enrollment_type,                        
                            'middlename'          => $this->input->post('middlename'),
                            'email'               => $this->input->post('email'),
                            'class_section_id'    => $class_section_id,
                            'lrn_no'              => $this->input->post('lrn_no'),

                            'father_company_name'              => $this->input->post('father_company_name'),
                            'father_company_position'          => $this->input->post('father_company_position'),
                            'father_nature_of_business'        => $this->input->post('father_nature_of_business'),
                            'father_mobile'                    => $this->input->post('father_mobile'),
                            'father_dob'                       => date('Y-m-d', strtotime($this->input->post('father_dob'))),
                            'father_citizenship'               => $this->input->post('father_citizenship'),
                            'father_religion'                  => $this->input->post('father_religion'),
                            'father_highschool'                => $this->input->post('father_highschool'),
                            'father_college'                   => $this->input->post('father_college'),
                            'father_college_course'            => $this->input->post('father_college_course'),
                            'father_post_graduate'             => $this->input->post('father_post_graduate'),
                            'father_post_course'               => $this->input->post('father_post_course'),
                            'father_prof_affiliation'          => $this->input->post('father_prof_affiliation'),
                            'father_prof_affiliation_position' => $this->input->post('father_prof_affiliation_position'),
                            'father_tech_prof'                 => $this->input->post('father_tech_prof'),
                            'father_tech_prof_other'           => $this->input->post('father_tech_prof_other'),

                            'mother_company_name'              => $this->input->post('mother_company_name'),
                            'mother_company_position'          => $this->input->post('mother_company_position'),
                            'mother_nature_of_business'        => $this->input->post('mother_nature_of_business'),
                            'mother_mobile'                    => $this->input->post('mother_mobile'),
                            'mother_dob'                       => date('Y-m-d', strtotime($this->input->post('mother_dob'))),
                            'mother_citizenship'               => $this->input->post('mother_citizenship'),
                            'mother_religion'                  => $this->input->post('mother_religion'),
                            'mother_highschool'                => $this->input->post('mother_highschool'),
                            'mother_college'                   => $this->input->post('mother_college'),
                            'mother_college_course'            => $this->input->post('mother_college_course'),
                            'mother_post_graduate'             => $this->input->post('mother_post_graduate'),
                            'mother_post_course'               => $this->input->post('mother_post_course'),
                            'mother_prof_affiliation'          => $this->input->post('mother_prof_affiliation'),
                            'mother_prof_affiliation_position' => $this->input->post('mother_prof_affiliation_position'),
                            'mother_tech_prof'                 => $this->input->post('mother_tech_prof'),
                            'mother_tech_prof_other'           => $this->input->post('mother_tech_prof_other'),

                            'marriage'                   => $this->input->post('marriage'),
                            'dom'                        => date('Y-m-d', strtotime($this->input->post('dom'))),
                            'church'                     => $this->input->post('church'),
                            'family_together'            => $this->input->post('family_together'),
                            'parents_away'               => $this->input->post('parents_away'),
                            'parents_away_state'         => $this->input->post('parents_away_state'),
                            'parents_civil_status'       => $this->input->post('parents_civil_status'),
                            'parents_civil_status_other' => $this->input->post('parents_civil_status_other'),

                            'session_id' => $current_session,
                        );

                        if (isset($_FILES["document"]) && !empty($_FILES['document']['name'])) {
                            $time     = md5($_FILES["document"]['name'] . microtime());
                            $fileInfo = pathinfo($_FILES["document"]["name"]);
                            $doc_name = $time . '.' . $fileInfo['extension'];
                            move_uploaded_file($_FILES["document"]["tmp_name"], "./uploads/student_documents/online_admission_doc/" . $doc_name);
    
                            $data['document'] = $doc_name;
                        }

                        if (sizeOf($has_admission) <= 0)
                        {
                            $insert_id = $this->onlinestudent_model->add($data);
                            $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                        }
                        else {
                            if ($current_session > (int)$has_admission->session_id)
                            {
                                $insert_id = $this->onlinestudent_model->add($data);
                                $this->session->set_flashdata('msg', '<div class="alert alert-success">' . $this->lang->line('success_message') . '</div>');
                            }
                            else 
                            {
                                if ($has_admission->is_enroll == '0')
                                    $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$has_admission->firstname.' '.$has_admission->lastname.' '.$this->lang->line('has_pending_admission') . '</div>');
                                else 
                                    $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$has_admission->firstname.' '.$has_admission->lastname.' '.$this->lang->line('already_enrolled') . '</div>');
                            }
                        }                        
                    }
                    
                    redirect($_SERVER['HTTP_REFERER'], 'refresh');
                }
                else 
                {
                    $this->session->set_flashdata('msg', '<div class="alert alert-info">'.$this->data['error_message'].'</div>');
                }

                $this->load_theme('pages/admission');
            }
        }
    }

    public function GetStudentDetails($idnumber)
    {
        $data = $this->student_model->GetStudentInfo($idnumber);
        echo json_encode($data);
    }
}
