$(document).ready(function(){
    $("td span").each(function(i){
        setClickable(this, i);
    })
});

function setClickable(obj, i) {
    $(obj).click(function() {
        if($(this).html()=="<i>NULL</i>") $(this).html("");
        var textarea = '<span><textarea style="width:98%">'+$(this).html()+'</textarea>';
        var button	 = '<span><br /><input value="Save" class="saveButton" type="button" name="'+$(this).attr("id")+'"> or <input value="Cancel" class="cancelButton" type="button" name="'+$(this).attr("id")+'"></span></span>';
        var revert = $(obj).html();
        
        $(obj).after(textarea+button).remove();
        $('.saveButton').click(function(){
            saveChanges(this, false, i);
        });
        $('.cancelButton').click(function(){
            if(!revert) revert="<i>NULL</i>";
            saveChanges(this, revert, i);
        });
    })
    .mouseover(function() {
        $(obj).addClass("editable");
    })
    .mouseout(function() {
        $(obj).removeClass("editable");
    });
}//end of function setClickable

function saveChanges(obj, cancel, n) {
    var t;
    if(!cancel) {
        $("#ajax-saving").show();
        t = $(obj).parent().siblings(0).val();
        //if(t=="") {alert("This field cannot be blank."); return false;}
        $.post($("#ajax_save_url").val(),{
            name: $(obj).attr("name"),
            value: t,
            success: function() {$("#ajax-saving").fadeOut("slow")}
        });
        if(t=="") {t="<i>NULL</i>";}
        
    }
    else {
        t = cancel; // revert content
    }
    
    $(obj).parent().parent().after('<span id="'+($(obj).attr("name"))+'">'+t+'</span>').remove();
    setClickable($("td span").get(n), n);
    return true;
    
}