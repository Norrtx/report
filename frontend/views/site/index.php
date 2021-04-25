<?php
use conquer\jvectormap\JVectorMapWidget;
use yii\helpers\Url;
use frontend\assets\AppAsset;
AppAsset::register($this);
/* @var $this yii\web\View */
$POS_END = <<< JS
var rememberAddress = '';
function SupperateAddress() {
    rememberAddress = $('#Address').val().trim();
    var addressText = $("#Address").val().trim(); 
    var splitText = addressText; 
    splitText = splitText.replace(/\\n/g, " ");
    splitText = splitText.split("");
    var rememberNumber = "";
    var beginIndex = "";
    var endIndex = "";
    splitText.forEach(function(word, i) {
        if($.isNumeric(word) == true) {
            rememberNumber += word;
            if(rememberNumber.length == 1) {
                beginIndex = i;
            }
            endIndex = i;
        } else {
            if(word != " ") {
                if(rememberNumber.length >= 7 && rememberNumber.length <= 10) {
                } else {
                    rememberNumber = "";
                    beginIndex = "";
                    endIndex = "";
                }
            }
        }
        // if(exactlyNumber.length === 1 && exactlyNumber != '0') {
        // }
    });
    if(rememberNumber != "" && rememberNumber.length >= 7 && rememberNumber.length <= 10) {
        addressText = addressText.replace(addressText.substring(beginIndex, endIndex+1), "");
        $("#Phone").val(rememberNumber);
        $("#Address").val(addressText);
    }
 
//    return false;
    addressText = addressText.replace(/\\n/g, " ");
    addressText = addressText.split("");
    for (i in addressText){
    console.log(addressText);
    console.log(splitText);
        // if(splitText[i].length >= 7) {
        //     if (CheckPhoneNumber(splitText[i])==true) { 
        //         if(splitText[i] != ''){
        //             // isCustomerBan(splitText[i]);
        //         }
        //         // $('#Phone').val(splitText[i]);  
        //         delete(splitText[i]);
        //     } 
        // }
        if (CheckMail(addressText[i])==true){ 
            $('#Email').val(addressText[i]); 
            delete(addressText[i]); 
        }  
        if (CheckZipcode(addressText[i])==true) { 
            $('#Zipcode').val(addressText[i]);  
            delete(addressText[i]); 
        } 
    }
    if ($('#FullName').val().length == 0) {
        $('#FullName').val(addressText[0]+" "+addressText[1]);
        delete(addressText[0]); 
        delete(addressText[1]); 
    }    
    $('#Address').val(addressText.join(" ").trim()); 
    // $('#splitWord').hide();
}
// function CheckPhoneNumber(number) {
//     var exactlyNumber = '';
//     var splitWord = number.split('');
//     splitWord.forEach(function(word, i) {
//         if($.isNumeric(word) == true) {
//             exactlyNumber += word;
//         }
//         // if(exactlyNumber.length === 1 && exactlyNumber != '0') {
//         // }
//     });
//     if(exactlyNumber.length >= 7 && exactlyNumber.length <= 10) {
//         $('#Phone').val(exactlyNumber);
//         return true;
//     }
//     return false;
// } 

    function CheckMail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]  {1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; 
        return re.test(email); 
    }

    function CheckZipcode(zipcode) { 
        if ($.isNumeric(zipcode) && (zipcode.length == 5))return true; 
        else return false; 
    }
function UndoAddress() {
    if(rememberAddress != '') {
        $('#Address').val(rememberAddress);
    }
    $('#FullName').val("");
    $('#Phone').val("");
    $('#Email').val("");
    $('#Zipcode').val("");
    $('#splitWord').hide();
    $('#blacklistDiv').removeClass('in');
    $('#blacklistArea').html('');
}
JS;
$this ->registerJs($POS_END,static::POS_END);

?>
<div class="form-group">
    <div class="hr-line-dashed"></div>
    <!-- Customer info -->
    <input type="hidden" id="customer-id" name="Order[customer_id]">						
    <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <input type="text" id="FullName" class="form-control form-control-full input-sm input-require" name="Customer[name]" placeholder="ชื่อ - นามสกุล">
            </div>
        </div>
    </div>
    <div id="blacklistDiv" class="form-group collapse">
        <div class="row">
            <div class="col-lg-12" id="blacklistArea"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <input type="text" id="Phone" class="form-control form-control-full input-sm input-require" name="Customer[telephone]" title="เบอร์โทรศัพท์ต้องเป็นตัวเลขเท่านั้น!" placeholder="เบอร์โทรศัพท์" data-toggle="tooltip" data-placement="top">
                <div class="text-danger"></div>									
            </div>
            <div class="col-sm-6">
                <input type="text" id="Email" class="form-control form-control-full input-sm input-require" name="Customer[email]" placeholder="อีเมล์">						
                <!-- <span id="email-is-require" style="display: none;" class="text-danger"></span> -->
            </div>
        </div>
    </div>
    <div class="form-group">
        <textarea id="Address" class="form-control input-sm" name="Order[Buyer][Address]" rows="4" placeholder="ที่อยู่" style="resize: none; max-width: 100%;"></textarea>
    </div>
    <div class="form-group" id="splitWord" style="display: block;">
        <a href="javascript:SupperateAddress()" class="btn btn-sm btn-info"><i class="fa fa-arrows-alt"> </i>&nbsp;&nbsp;กระจายข้อมูล</a>
        <a id="undoAddress" href="javascript:undoAddress()" class="btn btn-sm btn-default" style="display: none;"><i class="fa fa-mail-reply"> </i>&nbsp;&nbsp;ยกเลิก</a>
    </div>
    <div class="form-group">
        <input type="text" id="Zipcode" class="form-control form-control-full input-sm input-require" name="CustomerAddress[zipcode]" placeholder="รหัสไปรษณีย์">		          
    </div>
</div>
                