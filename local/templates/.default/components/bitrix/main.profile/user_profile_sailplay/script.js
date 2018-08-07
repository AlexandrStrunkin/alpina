function removeElement(arr, sElement)
{
    var tmp = new Array();
    for (var i = 0; i<arr.length; i++) if (arr[i] != sElement) tmp[tmp.length] = arr[i];
    arr=null;
    arr=new Array();
    for (var i = 0; i<tmp.length; i++) arr[i] = tmp[i];
    tmp = null;
    return arr;
}

function SectionClick(id)
{
    var div = document.getElementById('user_div_'+id);
    if (div.className == "profile-block-hidden")
    {
        opened_sections[opened_sections.length]=id;
    }
    else
    {
        opened_sections = removeElement(opened_sections, id);
    }

    document.cookie = cookie_prefix + "_user_profile_open=" + opened_sections.join(",") + "; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";
    div.className = div.className == 'profile-block-hidden' ? 'profile-block-shown' : 'profile-block-hidden';
}

$(function(){
 //   $("input[name=PERSONAL_PHONE]").mask("+7(999)999-99-99");
    $("input[name=EMAIL]").blur(function(){
        $("input[name=LOGIN]").val($("input[name=EMAIL]").val());
    })

    $(".saved_card_line li").on("click", function(){
    	if ($(this).data("delete-card")) {
    		$.ajax({
	            type: "POST",
	            url: "/ajax/delete_recurrent_card.php",
	            data: {}
	        }).done(function() {
				$(".recurrent_card_exists").hide();
				$(".empty_recurrent_card").show();
	        });
    	}
    })

    BX.addCustomEvent('onAjaxSuccess', function(){});
})
$(function(){
    $('body').on('click', '.top-section__edit-acc-inner', function(){
        $('.account-form').show();
    })
    $('body').on('click', '.account-form__close', function(){
        $('.account-form').hide();
    })
})
// �������� �����, ��� ����������� ����� ������ ��� ����������� ����� ���������� �������
$(document).ready(function(){
    $(".account-form").on('submit', function(){
        (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail($(".account-form").find("input[name='EMAIL']").val());});
        $.ajax({
            type: "POST",
            url: "/ajax/change_socservices_external_id.php",
            data: function(data){
                  console.log(data);
            }
        })
    });
});
