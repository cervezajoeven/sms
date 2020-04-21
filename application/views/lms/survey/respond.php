<!DOCTYPE html>
<html>
	<head>
		<title>Control</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/boostrap.min.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/bootstrap-theme.min.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/fileinput.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/fileinput.min.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/jquery-ui.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_resources('lms/font-awesome.min.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_css('lms/lesson/slideshow/font-awesome.min.css')?>">
		<link rel="stylesheet" href="<?php echo $general_class->ben_resources('lms/survey.css')?>">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<div class = "container-fluid">
	      	<div class = "row row-height">
		        <div class = "col-sm-7 left">
		        	
	            	<iframe style="height: 100%;width: 100%;" id="optical_pdf" class="embed-responsive-item" src="<?php echo $general_class->ben_resources('pdfjs/web/viewer.html?file=').urlencode($general_class->ben_resources('uploads/survey/'.$general_class->data['survey_id'].'/'.$general_class->data['survey']['survey_file'])); ?>"></iframe>
		            	
		        </div>

		        <div class="col-sm-5 right">
		        	<div class="info col-sm-5">
		        		<!-- <div class="info-row">
		        			<div class="info-tab info-title col-sm-2">Name :</div>
		        			<div class="info-tab col-sm-4"><?php echo $data['account_profile']['first_name']; ?> <?php echo $data['account_profile']['last_name']; ?></div>
		        			<div class="info-tab info-title col-sm-2">Section :</div>
			        		<div class="info-tab col-sm-4">Apolinario</div>
		        		</div> -->

		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Date :</div>
			        		<div class="info-tab col-sm-9">February 21, 2020</div>
		        		</div>

		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Title :</div>
			        		<div class="info-tab col-sm-9"><?php echo $general_class->data['survey']['survey_name']?></div>
		        		</div>
		        		
		        		<div class="info-row save">
			        		<div class="info-tab col-sm-12" style="background-color: green;color: white;height: 30px;">
			        			<center>Submit</center>
			        		</div>
		        		</div>
		        	</div>
		        	<div class="clearfix"></div>
		        	<ul class="sortable ui-sortable">
		        		<li class="option-container option-container-clonable">
		        			<div class="numbering_option">1.</div>
		        			<div class="remove_option float-right">X</div>
		        			<div class="option">
		        				<div class="option_type">
		        					<input type="radio" name="" class="form-control">
		        				</div>
		        				<div class="option_label_container">
		        					<div class="option_label"></div>
		        					<div class="option_label_input">
		        						<input type="text" name="" value="A" class="form-control">
		        					</div>
		        				</div>		        				

		        			</div>
		        			
		        			<div class="add_option">
		        				<div class="option_type">
		        					
		        				</div>
		        				<div class="option_label_container">
		        					
		        					<div class="">
		        						<center>
		        							<input type="button" name="" class="form-control btn btn-success" style="margin-top: 10px;" value="Add Option">
		        						</center>
		        						
		        					</div>
		        				</div>		        				

		        			</div>
		        		</li>
		        		
		        	</ul>
		            
		        </div>
	      	</div>
	    </div>
	</body>
</html>
<script type="text/javascript" src="<?php echo $general_class->ben_resources('lms/jquery-1.12.4.js')?>"></script>
<script type="text/javascript" src="<?php echo $general_class->ben_resources('lms/jquery-ui.js')?>"></script>
<!-- <script type="text/javascript" src="<?php echo $general_class->ben_resources('lms/survey.js')?>"></script> -->
<script type="text/javascript">

	var url = "<?php echo $general_class->ben_link('general/survey/update_survey_sheet'); ?>";
	var stored_json = '<?php echo $general_class->data["survey"]["sheet"]; ?>';
	var account_id = '<?php echo $general_class->session->userdata("id"); ?>';
	var final_json = {};
	
	// $(".sortable").sortable({
	// 	stop:function(event,ui){
	// 		renumbering();
	// 	}
	// });

	
	$(".option-container-clonable").hide();

	function populate_key(option_type){
		var option_clone = $(".option-container-clonable").clone();
		switch (option_type){
			case "multiple_choice":
				option_clone.removeClass("option-container-clonable");
				option_clone.addClass("option-container-actual");
				option_clone.addClass("multiple_choice");
				option_clone.attr("option_type","multiple_choice");
				option_clone.show();
				$(".sortable").append(option_clone);
			break;
			case "multiple_answer":
				option_clone.removeClass("option-container-clonable");
				option_clone.addClass("option-container-actual");
				option_clone.addClass("multiple_choice");
				option_clone.attr("option_type","multiple_answer");
				option_clone.show();
				option_clone.find(".option_type").find("input").attr("type","checkbox");
				$(".sortable").append(option_clone);
			break;
			case "short_answer":
				option_clone.removeClass("option-container-clonable");
				option_clone.addClass("option-container-actual");
				option_clone.addClass("short_answer");
				option_clone.show();
				option_clone.attr("option_type","short_answer");
				option_clone.find(".option_type").find("input").attr("type","text");
				option_clone.find(".option_type").find("input").css("width","100%");
				option_clone.find(".option_label_input").find("input").remove();
				option_clone.find(".add_option").remove();
				$(".sortable").append(option_clone);
			break;
			case "long_answer":
				option_clone.removeClass("option-container-clonable");
				option_clone.addClass("option-container-actual");
				option_clone.addClass("short_answer");
				option_clone.show();
				option_clone.attr("option_type","long_answer");
				option_clone.find(".option_type").empty();
				option_clone.find(".option_type").html('<textarea class="form-control"></textarea>');
				option_clone.find(".option_type").find("textarea").css("width","100%");
				option_clone.find(".option_label_input").find("input").remove();
				option_clone.find(".add_option").remove();
				$(".sortable").append(option_clone);
			break;
		}
	}

	function renumbering(){
		var total_number = $(".option-container-actual");
		$.each(total_number,function(key,value){
			$(value).find(".numbering_option").text(key+1);
			$(value).find(".option_type").find("input").attr("name","option_"+key+1);
			// new Cleave($(value).find(".option_type").find("input"), {
			//     numeral: true,
			// });
			$(value).find(".option_type").find("input").on('keypress', function (event) {
			    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			    if (!regex.test(key)) {
			       event.preventDefault();
			       return false;
			    }
			});
			$(value).find(".option_type").find("textarea").on('keypress', function (event) {
			    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			    if (!regex.test(key)) {
			       event.preventDefault();
			       return false;
			    }
			});
		});
	}
	$(document).ready(function(){
		if(stored_json){
			$.each(JSON.parse(stored_json),function(key,value){
				populate_key(value.type);
				$.each(value.option_labels.split(","),function(split_key,split_value){
					var last_option = $(".option-container-actual").eq(key).find(".option").length;
					var option_clone = $(".option-container-actual").eq(key).find(".option").eq(last_option-1).clone();
					$(".option-container-actual").eq(key).find(".option").eq(last_option-1).after(option_clone);
				});
				var the_last = $(".option-container-actual").eq(key).find(".option").length;
				$.each(value.option_labels.split(","),function(value_key,value_value){
					$(".option-container-actual").eq(key).find(".option").eq(value_key).find(".option_label_input").find("input").val(value_value);
					
				});
				$(".option-container-actual").eq(key).find(".option").eq(the_last-1).remove();


				
			});
			renumbering();
		}
		

	});
	$(document).on("click",".remove_option",function(){
		$(this).parent().remove();
		renumbering();

	});
	$(".info-key").click(function(){
		var option_type = $(this).attr("option_type");
		populate_key(option_type);
		
		renumbering();
	});
	$(document).on("click",".add_option",function(){
		var last_option = $(this).parent().find(".option").length;
		var option_clone = $(this).siblings(".option").eq(last_option-1).clone();
		$(this).parent().find(".option").eq(last_option-1).after(option_clone);

	});
	$(".save").click(function(){
		var json = [];
		var options = $(".option-container-actual");
		$.each(options,function(key,value){
			var the_option_type = $(value).attr("option_type");
			
			if(the_option_type=="multiple_choice"||the_option_type=="multiple_answer"){
				var option_val = [];
				$.each($(value).find(".option"),function(option_key,option_value){
					console.log();
					if($(option_value).find(".option_type").find("input").is(":checked")){
					 	option_val.push(1);
					}else{
						option_val.push(0);
					}
				});
				option_json = {
					"type":the_option_type,
					"answer":option_val.join(","),
				};
			}else if(the_option_type=="long_answer"){
				var option_val = [];
				$.each($(value).find(".option"),function(option_key,option_value){
					
					option_val.push($(option_value).find(".option_type").find("textarea").val());
					
				});
				option_json = {
					"type":the_option_type,
					"answer":option_val.join(","),
				};
			}else if(the_option_type=="short_answer"){
				var option_val = [];
				$.each($(value).find(".option"),function(option_key,option_value){
					
					option_val.push($(option_value).find(".option_type").find("input").val());
					
				});
				option_json = {
					"type":the_option_type,
					"answer":option_val.join(","),
				};
			}
			json.push(option_json);

			
			
		});
		final_json = {survey_id:"<?php echo $general_class->data['survey_id'] ?>",respond:JSON.stringify(json),account_id:account_id};

		$.ajax({
		    url: url,
		    type: "POST",
		    data: final_json,
		    // contentType: "application/json",
		    complete: function(response){
		    	console.log(response);
		    	alert("Sucessfully Submitted!");
		    	window.location.replace("<?php echo $general_class->ben_link('general/survey/assigned') ?>/");
		    }
		});
	});

	$(".add_option").remove();
	$(".option_type").find("input").addClass();
	$(document).find(".option_label_input").find("input").attr("disabled","");
	$(document).find(".remove_option").remove();
	

</script>