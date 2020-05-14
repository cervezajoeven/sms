<!DOCTYPE html>
<html>
	<head>
		<title>Control</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="<?php echo $resources.'boostrap.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'bootstrap-theme.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'fileinput.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'fileinput.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'jquery-ui.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'font-awesome.min.css'?>">
		<link rel="stylesheet" href="<?php echo $resources.'survey.css'?>">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>

		<div class = "container-fluid">
	      	<div class = "row row-height">
		        <div class = "col-sm-7 left">
		        	<form enctype="multipart/form-data" method="POST" action="<?php echo site_url('lms/survey/upload/'.$survey['id']); ?>">
		        		<a href="<?php echo site_url('lms/survey/index/'); ?>"><button type="button" class="form-control btn btn-danger">Back</button></a>
		        		<input type="file" required="" class="form-control" accept="application/pdf" name="survey_form">
		        		<input type="submit" class="form-control btn btn-success">
		        	</form>
		        	
	            	<iframe style="height: 100%;width: 100%;" id="optical_pdf" class="embed-responsive-item" src="<?php echo $resources.'pdfjs/web/viewer.html?file='.urlencode(site_url('uploads/lms_survey/'.$survey['id'].'/'.$survey['survey_file'])); ?>"></iframe>
		            	
		        </div>

		        <div class="col-sm-5 right">
		        	<div class="info col-sm-5">
		        	
		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Date :</div>
			        		<div class="info-tab col-sm-9">February 21, 2020</div>
		        		</div>

		        		<div class="info-row">
			        		<div class="info-tab info-title col-sm-3">Title :</div>
			        		<div class="info-tab col-sm-9"><?php echo $survey['survey_name']?></div>
		        		</div>
		        		<div class="info-row">
			        		<div class="info-tab info-key col-sm-3" option_type="multiple_choice">Multiple Choice</div>
			        		<!-- <div class="info-tab info-key col-sm-3" option_type="short_answer">Answers</div> -->
			        		<div class="info-tab info-key col-sm-6" option_type="long_answer"><center>Comments/Suggestions</center></div>
			        		<div class="info-tab info-key col-sm-3" option_type="multiple_answer">Multiple Answer</div>
		        		</div>
		        		<div class="info-row">
			        		<div class="info-tab col-sm-6 save">
			        			<center>Save</center>
			        		</div>
			        		<div class="info-tab col-sm-6 assign">
			        			<center>Assign</center>
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
<script type="text/javascript" src="<?php echo $resources.'jquery-1.12.4.js'?>"></script>
<script type="text/javascript" src="<?php echo $resources.'jquery-ui.js'?>"></script>
<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave.min.js"></script>
<script type="text/javascript" src="https://nosir.github.io/cleave.js/dist/cleave-phone.i18n.js"></script>
<!-- <script type="text/javascript" src="<?php echo $resources.'survey.js'?>"></script> -->
<script type="text/javascript">

	var url = "<?php echo site_url('lms/survey/update'); ?>";
	var stored_json = '<?php echo $survey['sheet']; ?>';
	var final_json = {};
	
	$(".sortable").sortable({
		stop:function(event,ui){
			renumbering();
		}
	});
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
					 option_val.push($(option_value).find(".option_label_input").find("input").val());
				});
				option_json = {
					"type":the_option_type,
					"option_labels":option_val.join(","),
				};
			}else{
				option_json = {
					"type":the_option_type,
					"option_labels":"",
				};
			}
			json.push(option_json);

			
			
		});
		final_json = {id:"<?php echo $survey['id'] ?>",sheet:JSON.stringify(json)};
		$.ajax({
		    url: url,
		    type: "POST",
		    data: final_json,
		    // contentType: "application/json",
		    complete: function(response){
		    	console.log(response.responseText);
		    	alert("Sucessfully Saved!");
		    }
		});
	});

</script>