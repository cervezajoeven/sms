var url = $("#url").val();
var stored_json = $("#stored_json").val();
var final_json = {};
var letters_array = ["A","B","C","D"];
var assigned = $("#assigned").val();
$(".sortable").sortable({
	stop:function(event,ui){
		renumbering();
	}
});
$(".option-container-clonable").hide();

var jstree = $('#jstree_demo_div').jstree({
    "checkbox" : {
      "keep_selected_style" : false
    },
    "plugins" : [ "checkbox" ]
});

function isEmpty(obj) {
  for(var prop in obj) {
    if(obj.hasOwnProperty(prop)) {
      return false;
    }
  }

  return JSON.stringify(obj) === JSON.stringify({});
}

function populate_key(option_type,data={}){
	var option_clone = $(".option-container-clonable").clone();
	
	switch (option_type){
		case "multiple_choice":
			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("multiple_choice");
			option_clone.attr("option_type","multiple_choice");
			option_clone.show();
			
			if(!isEmpty(data)){
				
			}

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
			// option_clone.find(".option_type").find("input").val(data.correct.split(",").join(" or "));
			option_clone.find(".option_type").find("input").css("width","100%");
			option_clone.find(".option_label_input").find("input").remove();
			option_clone.find(".remove_choice").remove();
			option_clone.find(".add_option").remove();
			$(".sortable").append(option_clone);
		break;
		case "long_answer":
			
			option_clone.removeClass("option-container-clonable");
			option_clone.addClass("option-container-actual");
			option_clone.addClass("long_answer");
			option_clone.show();
			option_clone.attr("option_type","long_answer");
			option_clone.find(".option_type").empty();
			option_clone.find(".add_option").remove();
			option_clone.find(".option_label_input").find("input").remove();
			option_clone.find(".remove_choice").remove();
			option_clone.find(".option_type").html('<textarea class="form-control"></textarea>');
			
			option_clone.find(".option_type").find("textarea").css("width","100%");
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
			populate_key(value.type,value);
			
			var checked_ids = [];
			if(assigned){

				$.each(assigned.split(","),function(key,value){
					checked_ids.push("student_"+value);
				});
				$.jstree.reference('#jstree_demo_div').select_node(checked_ids);
			}
			if(value.type=="short_answer"){
				$(".option-container-actual").eq(key).find(".option_type").find("input").val(value.correct.split(",").join(" or "));
				// option_clone.find(".option_type").find("input").val(data.correct.split(",").join(" or "));
				
				// console.log(value);
			}
			$.each(value.option_labels.split(","),function(split_key,split_value){
				
				var last_option = $(".option-container-actual").eq(key).find(".option").length;
				var option_clone = $(".option-container-actual").eq(key).find(".option").eq(last_option-1).clone();
				$(".option-container-actual").eq(key).find(".option").eq(last_option-1).after(option_clone);

			});
			if(value.type!="long_answer"){
				$.each(value.correct.split(","),function(correct_key,correct_value){

					if(value.type=="multiple_choice"||value.type=="multiple_answer"){
						// $( "#x" ).prop( "checked", true );
						if(correct_value=='1'){

							$(".option-container-actual").eq(key).find(".option_type").eq(correct_key).find("input").prop("checked",true);
						}else{
							// $(".option-container-actual").eq(key).find(".option_type").find("input").prop("checked",false);
						}

					}
					

				});
			}
			
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
$(".true_save").click(function(){
	var json = [];
	var options = $(".option-container-actual");
	$.each(options,function(key,value){
		var the_option_type = $(value).attr("option_type");
		
		if(the_option_type=="multiple_choice"||the_option_type=="multiple_answer"){
			var option_val = [];
			var answer_val = [];
			$.each($(value).find(".option"),function(option_key,option_value){
				 option_val.push($(option_value).find(".option_label_input").find("input").val());
				 if($(option_value).find(".option_type").find("input").eq(0).is(':checked')){
				 	answer_val.push("1");
				 }else{
				 	answer_val.push("0");
				 }
			});

			option_json = {
				"type":the_option_type,
				"correct":answer_val.join(","),
				"option_labels":option_val.join(","),
			};

		}else if(the_option_type=="short_answer"){
			
			var short_answer_val = $(value).find(".option").find("input").eq(0).val().split(" or ");

			option_json = {
				"type":the_option_type,
				"correct": short_answer_val.join(","),
				"option_labels":"",
			};
		}else{
			option_json = {
				"type":the_option_type,
				"option_labels":"",
			};
		}
		json.push(option_json);

		

	});

	var student_ids = [];
	$.each(jstree.jstree("get_checked",null,true),function(key,value){
		
		if(value.includes('student')){
			student_id = value.replace('student_','');
			
			student_ids.push(student_id);
		}
	});

	final_json = {id:$("#assessment_id").val(),sheet:JSON.stringify(json),assigned:student_ids.join(',')};
	
	$.ajax({
	    url: url,
	    type: "POST",
	    data: final_json,
	    // contentType: "application/json",
	    complete: function(response){
	    	console.log(response.responseText);
	    	// alert("Sucessfully Saved!");
	    }
	});
});
$('.file').hide();
$(".upload").click(function(){
	$('.file').click();
});
$(".file").change(function(){
	$("#upload_form").submit();
});
$(document).on("click",".remove_choice",function(){
	$(this).parent().parent().remove();

});
$(".assign_panel").hide();
$(".assign").click(function(){
	$(".assign_panel").toggle();
	$(".sortable").toggle();
});
