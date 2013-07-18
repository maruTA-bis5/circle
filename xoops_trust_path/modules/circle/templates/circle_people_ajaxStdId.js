$(document).ready(function() {
$("#legacy_xoopsform_student_id").change(function() {
  $(this).val($(this).val().toUpperCase());
  var sid = $(this).val();
  $.ajax({
    "async":true,
    "cache":false,
    "data":{"q_student_id":sid},
    "dataType":"json",
    "url":"<{$xoops_url}>/modules/<{$xoops_dirname}>/includes/ajaxStdId.php",
    "success": function(data) {
        var idlist =[];
        if (data["response_status"] != 200) {
          idlist = undefined;
          processId2Name(undefined);
          return false;
        }
        var arr = data["answer_section"];
        for (i = 0; i < arr.length; i++) {
          idlist.push(arr[i]);
        }
        processId2Name(idlist);
    }
  });
});
});
function processId2Name(idList) {
  $("#legacy_xoopsform_title").attr("readonly", false);
  $("#legacy_xoopsform_title").attr("placeholder","");
  $("#legacy_xoopsform_title").attr("value","");
  if (idList==undefined||idList.length > 1) {
    $("#legacy_xoopsform_title").attr("placeholder","学生を一意に特定できません。学籍番号を確認してください。");
  } else {
    $("#legacy_xoopsform_title").attr("readonly", true);
    $("#legacy_xoopsform_title").attr("value",idList[0][2]);
  }
}
