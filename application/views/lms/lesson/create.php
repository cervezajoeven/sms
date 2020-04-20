<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LMS Lesson Creator</title>
        <link rel="stylesheet" href="<?php echo $resources.'jquery-ui.css' ?>">
        <link rel="stylesheet" href="<?php echo $resources.'lesson.css' ?>">
        <link rel="stylesheet" href="<?php echo $resources.'jquery.magnify.css' ?>">
        <link rel="stylesheet" href="<?php echo $resources.'font-awesome.min.css' ?>">
        <link rel="stylesheet" href="<?php echo $resources.'fontawesome/css/all.css' ?>">
        <link href="https://vjs.zencdn.net/7.7.5/video-js.css" rel="stylesheet" />

        <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
        <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
    </head>
    <body>
        
        <input type="hidden" id="site_url" value="<?php echo site_url('lms/lesson/update'); ?>" name="">
        <input type="hidden" id="url" value="<?php echo site_url('lms/lesson/'); ?>" name="">
        <input type="hidden" id="lesson_id" value="<?php echo $id; ?>" name="">

        <div class="edit_area">

            <div class="part left">
                <div class="navigation">

                    <div class="title_container">
                        <input type="text" class="title" placeholder="Lesson Name Here..." value="<?php echo $lesson['lesson_name']?>" name="">
                        
                    </div>
                    <div class="folders_container">
                        <div class="folder folder_active">
                            <!-- <input type="text" placeholder="Engage" value="Engage" name=""> -->
                            <span>Engage</span>
                        </div>
                        <div class="folder">
                            <!-- <input type="text" placeholder="Explore" value="Explore" name=""> -->
                            <span>Explore</span>
                        </div>
                        <div class="folder">
                            <!-- <input type="text" placeholder="Explain" value="Explain" name=""> -->
                            <span>Explain</span>
                        </div>
                        <div class="folder">
                            <!-- <input type="text" placeholder="Extend" value="Extend" name=""> -->
                            <span>Extend</span>
                        </div>
                        <div class="folder">
                            <!-- <input type="text" placeholder="Extend" value="Extend" name=""> -->
                            <span>Evaluation</span>
                        </div>
                        <div class="folder">
                            <!-- <input type="text" placeholder="LAS" value="LAS" name=""> -->
                            <span>LAS</span>
                        </div>
                    </div>
                    
                </div>
                
                <div class="folder_container">

                    <ul id="folder_1" class="folder_contents connectedSortable">
                        
                    </ul>
                </div>
                <div class="folder_container">
                    <ul id="folder_2" class="folder_contents connectedSortable">
                        
                    </ul>
                </div>
                <div class="folder_container">
                    <ul id="folder_3" class="folder_contents connectedSortable">
                        
                    </ul>
                </div>
                <div class="folder_container">
                    <ul id="folder_4" class="folder_contents connectedSortable">
                        
                    </ul>
                </div>
                <div class="folder_container">
                    <ul id="folder_5" class="folder_contents connectedSortable">
                        
                    </ul>
                </div>
                <div id="" class="slider close learning_plan_slider">
                    <div class="slider_container">
                        <h2>Learning Plan</h2>
                        <p>Upload Learning Plan Here</p>
                        <input type="file" name="" />
                    </div>
                </div>
                <div id="" class="slider close objective_slider">
                    <div class="slider_container">
                        <h2>Objective</h2>
                        <p>Write your objective here.</p>
                        <textarea></textarea>
                    </div>
                </div>
                <div id="" class="slider close assign_slider" style="background-color: rgb(84, 130, 53);">
                    <div class="slider_container">
                        <h2>Assign to Students</h2>
                    </div>
                </div>
                <div id="" class="slider close discussion_slider">

                    <div class="slider_container">
                    
                        <h2>Discuss with Students</h2>
                    </div>
                </div>
                <div id="" class="slider close settings_slider">
                    <div class="slider_container">
                        <h2>Settings</h2>
                    </div>
                </div>
                <div class="footer">

                    <div class="actions_container">
                        <div class="actions">
                            <a href="<?php echo site_url('lms/blackboard/index'); ?>">
                                <button class="action_button close_action"><i class="fas fa-times-circle"></i>Close</button>
                            </a>
                        </div>
                        <div class="actions">
                            <button id="learning_plan" class="trigger action_button"><i class="fab fa-leanpub"></i>Learning Plan</button>
                        </div>
                        <div class="actions">
                            <button id="objective" class="trigger action_button"><i class="fas fa-bullseye"></i>Objective</button>
                        </div>
                        <div class="actions">
                            <button id="slideshow" class="action_button slideshow_action"><i class="fas fa-video"></i>Slideshow</button>
                        </div>
                        <div class="actions">
                            <button id="assign" class="trigger action_button assign_action"><i class="fas fa-chalkboard-teacher"></i>Assign</button>
                        </div>
                        <div class="actions">
                            <button id="discussion" class="trigger action_button"><i class="fas fa-school"></i>Discussion</button>
                        </div>
                        <div class="actions">
                            <button id="settings" class="trigger action_button"><i class="fas fa-cogs"></i>Settings</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="part right">
                <div class="navigation">
                    <div class="title_container">
                        <input type="text" disabled="" value="Campus LMS Resources Search" name="">

                    </div>
                    <div class="search_container">
                        
                        <input type="text" id="search_portal" placeholder="Content Search" name="search_portal">
                        <button class="submit_button"><img src="<?php echo $resources.'images/search.png' ?>"></button>
                    </div>
                </div>
                
                <ul id="result_container" class="connectedSortable">
                    
                    <li class="ui-state-default content search_content content_hidden" result_id="">
                        <div class="content_header theme">
                            <span>Default</span>
                            <img class="content_close" src="<?php echo $resources.'images/close.png' ?>">
                        </div>
                        <div class="content_body">
                            <div class="download_status_container">
                                <span>Checking...</span>
                            </div>
                            <img src="<?php echo $resources.'images/website.png' ?>">
                            
                        </div>
                        
                        <div class="content_footer theme">
                            <span>Default Description</span>
                        </div>
                        
                    </li>
                   
                </ul>
                

            </div>

            <div class="part extremeright">
                <div class="extremeright_filler">

                </div>
                <div class="search_container">

                </div>
                <div class="extremeright_icon icon_active" portal="youtube">
                    <center>
                        <img src="<?php echo $resources.'images/youtube.png' ?>">
                    </center>
                </div>
                
                <div class="extremeright_icon" portal="google_image">
                    <center>
                        <img src="<?php echo $resources.'images/google-photos.svg' ?>">
                    </center>
                </div>

                <div class="extremeright_icon" portal="google">
                    <center>
                        <img src="<?php echo $resources.'images/google.svg' ?>">
                    </center>
                </div>

                <div class="extremeright_icon" portal="mycms">
                    <center>
                        <img src="<?php echo $resources.'images/mycms.png' ?>">
                    </center>
                </div>
                <div class="extremeright_icon" portal="cms">
                    <center>
                        <img src="<?php echo $resources.'images/cms.png' ?>">
                    </center>
                </div>
            </div>
            
        </div>
        

        <div class="student_view student_view_close">
            <div class="student_view_container">
                <div class="student_view_navigation">
                    <div class="student_view_buttons button_navigation blue previous"><i class="fas fa-chevron-left"></i> Previous</div>
                    <div class="student_view_buttons student_view_title">Title</div>
                    <div class="student_view_buttons button_navigation blue next">Next <i class="fas fa-chevron-right"></i></div>
                    
                
                </div>
                <div class="student_view_slides" id="student_view_slides">
                    <div class="slide slide_clone" style="display: none;">
                        <div class="dimmer"></div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/da/Panthera_tigris_tigris_Tidoba_20150306.jpg">
                    </div>
                    
                </div>
                <div class="student_view_content" >

                    <iframe class="content_type student_view_content_iframe" src="https://www.youtube.com/embed/" frameborder="0" ></iframe>
                    <img class="content_type image_content" src="" data-magnify="gallery" data-caption="Image Caption 1" data-src="1.jpg" />
                    <video src="" class="video_content" width="100%" controls controlsList="nodownload"></video>
                </div>
                
            </div>
            <div class="student_view_right">
                
                <div class="student_view_navigation">
                    <div class="student_view_buttons close_action close_student_view"><i class="fas fa-times-circle"></i> Close Slideshow</div>
                    
                
                </div>
            </div>
        </div>

        <script src="<?php echo $resources.'jquery-1.12.4.js'?>"></script>
        <script src="<?php echo $resources.'jquery.magnify.js'?>"></script>
        <script src="<?php echo $resources.'jquery-ui.js'?>"></script>
        <script src="<?php echo $resources.'jquery.mousewheel.min.js'?>"></script>
        <script src="<?php echo $resources.'lesson.js'?>"></script>
        <script src="https://vjs.zencdn.net/7.7.5/video.js"></script>

    </body>
</html>