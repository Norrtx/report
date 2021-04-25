<?php
use frontend\assets\AppAsset;
AppAsset::register($this);
/* @var $this yii\web\View */
$POS_END = <<< JS
var rememberAddress = '';
function SupperateAddress() {
    rememberAddress = $('#Address').val().trim();
    var addressText = $("#Address").val().trim(); 
    addressText = addressText.replace(/\\n/g, " ");
    var splitText = addressText;
    splitText = splitText.split("");
    var rememberNumber = "";
    var beginIndex = "";
    var endIndex = "";
    var phoneMobile = ["06","08","09"];
    var phoneHome = ["032","034","035","036","037","038","039","042","043","044","045","053","054","055","056","073","074","075","076","077"];
    var phoneBkk = ["02"];
    var countryCodes = ["+30","+1671","+502","+974","+592","+245","+506","+269","+53","+996","+599","+965","+995","+962","+253","+235","+56","+378","+685","+212","+963","+249","+211","+597",
    "+262","+243","+1868","+676","+670","+90","+216","+688","+240","+992","+423","+47","+264","+505","+64","+44","+687","+683","+55","+246","+673","+267","+387","+880","+359","+1246","973","+1242","+257","+226",
    "+855","+233","+241","+224","+242","+686","+86","+966","+263","+81","+674","+92","+976","+222","+60","+370","+218","+41","+254","+221","+977","+229","+49","+260","+255","+595","258","+357","+66","+234",
    "+227","+231","+354","+507","+675","+970","+680","+33","+95","+872","+47","+679","+358","+63","+975","+1664","+382","+230","+373","+960","+389","+261","+596","+265","+223","+853","+350","+256","+380",
    "+250","+352","+371","+856","+590","+379","+678","+681","+94","+268","+46","+971","+699","+44","+82","+420","+251","+236","+65","+34","+421","+386","+682","+128","+500","+692","+1670","+134","+298","+61",
    "+677","+358","+43","+61","+376","+93","+297","+54","+374","+994","+39","+91","+62","+964","+972","+98","+20","+998","+598","+1684","+504","+36","+852","+1473","+850","+44","+299","+61","+187","+672","+356",
    "+247","+1345","+238","+1869","+508","+590","+1758","+1784","+290","+381","+239","+232","+248","+45","+1649","+993","+31","+599","+375","+501","+32","+1441","+51","+594","+689","+52","+967","+961","+266",
    "+84","+58","+44","+593","+291","+503","+372","+220","+237","+1264","+244","+1268","+27","+213","+355","+385","+57","+377","+252","+252","+1767","+690","+228","+591","+599","+351","+48","+377","+212","+40",
    "+968","+886","+691","+353","+225","+509"];
    var countryCode = ["+1","+7"]
    var phoneCheck = false;
    var truelyPhoneNumber = "";
    var donePhone = false;
    var status_firstIndex = false;
    splitText.forEach(function(word, i) {
        var allowedSymbol = ["-", " ",")"];
        if(donePhone == false ){
            if($.isNumeric(word) == true || word == "+") {         
                rememberNumber += word;
                if(word == "+"){
                    status_firstIndex = true;
                }
                if(phoneCheck == true && truelyPhoneNumber == "") {
                    endIndex = i;
                    console.log(endIndex,"endIndex");
                }
                if(rememberNumber.charAt(0) == "+" && status_firstIndex == true) {
                    if(rememberNumber.length == 5 && phoneCheck == false) {
                        var symbol = rememberNumber.substring(0, 5);            
                        if(countryCodes.indexOf(symbol) != -1) {
                            rememberNumber = rememberNumber.replace(symbol, "0");
                            phoneCheck = true;
                            beginIndex = (i - 4);                        
                        }   
                        console.log(symbol,"symbol5");
                        console.log(rememberNumber,"rememberNumber5");
                    } else if(rememberNumber.length == 4 && phoneCheck == false) {
                        var symbol = rememberNumber.substring(0, 4);                      
                        if(countryCodes.indexOf(symbol) != -1) {
                            rememberNumber = rememberNumber.replace(symbol, "0");
                            phoneCheck = true;
                            beginIndex = (i - 3);
                            console.log(beginIndex,endIndex,"beginIndex4"); 
                        }
                        console.log(symbol,"symbol4");
                        console.log(rememberNumber,"rememberNumber4");
                    } else if(rememberNumber.length == 3 && phoneCheck == false) {
                        var symbol = rememberNumber.substring(0, 3);              
                        if(countryCodes.indexOf(symbol) != -1) {
                            rememberNumber = rememberNumber.replace(symbol, "0");
                            phoneCheck = true;
                            beginIndex = (i - 2);
                            console.log(beginIndex,"beginIndex3");                        
                        } 
                        console.log(symbol,"symbol3");
                        console.log(rememberNumber,"rememberNumber3");
                    } 
                } 
                console.log(rememberNumber,"rememberNumberNEW+");
                if(rememberNumber.charAt(0) == "0" && status_firstIndex == false) {
                    if(rememberNumber.length == 2) {
                        var twoCode = rememberNumber.substring(0, 2);
                        if(phoneBkk.indexOf(twoCode) != -1 || phoneMobile.indexOf(twoCode) != -1) {
                            phoneCheck = true;
                            beginIndex = (i - 1);
                            console.log(beginIndex,endIndex,"beginIndex4"); 
                        }
                    } else if(rememberNumber.length == 3 && phoneCheck == false) {
                        var threeCode = rememberNumber.substring(0, 3);
                        if(phoneHome.indexOf(threeCode) != -1) {
                            phoneCheck = true;
                            beginIndex = (i - 2);
                        }
                    }                   
                } else {
                    console.log(rememberNumber, "not correct rerememberNumber0");       
                }   
                console.log(rememberNumber,"rememberNumberNEW0");
                console.log(status_firstIndex,"status_firstIndex0");               
            } else if (rememberNumber.length > 0 && (rememberNumber.charAt(0) == "+" || rememberNumber.charAt(0) == "0")  && allowedSymbol.indexOf(word) != -1) {
                    console.log(rememberNumber.length,rememberNumber.charAt(0),'JO');
                    //in phone number loop shoulde be skip in allowed symbol
                    if(rememberNumber.length > 8){
                        donePhone = true;
                        phoneCheck = false;                   
                        truelyPhoneNumber = rememberNumber;
                        console.log(truelyPhoneNumber, "not truelyPhoneNumber");
                    }            
            } else if(rememberNumber.length > 0) {
                if(phoneCheck == true) {
                    truelyPhoneNumber = rememberNumber;
                    phoneCheck = false;
                    console.log(truelyPhoneNumber, "notb truelyPhoneNumber");
                }
                rememberNumber = "";
            } else {
                //when rememberNumber.length == 0
            }
        }
    });
    console.log( rememberAddress," rememberAddress");
    rememberNumber = rememberNumber+" 1";
    console.log( rememberNumber," rememberAddress+1");
    if (rememberNumber.length > 0 && (rememberNumber.charAt(0) == "+" || rememberNumber.charAt(0) == "0") ) {
        console.log(rememberNumber.length,rememberNumber.charAt(0),'rememberNumber.lengthOUT');
        //in phone number loop shoulde be skip in allowed symbol
        if(rememberNumber.length > 8){
            var last = rememberNumber.length-2;
            rememberNumber = rememberNumber.substring(0,last);
            truelyPhoneNumber = rememberNumber;
            console.log(truelyPhoneNumber, "not truelyPhoneNumber");
        }          
    }
        console.log(rememberNumber,"rememberNumberNEW+1");  
    if(truelyPhoneNumber != "") {
        console.log(truelyPhoneNumber,"truelyPhoneNumber");
        console.log(addressText,"addressText");
        console.log(addressText.substring(beginIndex, (endIndex +1 )),"Substringindex");
        console.log(beginIndex, 'beginIndex');
        console.log(endIndex, 'endIndex');
        addressText = addressText.replace(addressText.substring(beginIndex, endIndex+1 ), "");
        $("#Phone").val(truelyPhoneNumber);
        $("#Address").val(addressText);  
    }
    rememberNumber = "";
    beginIndex = "";
    endIndex = "";
    addressText = addressText.split(" ");
    console.log(addressText);
    var telPattern = ["tel","Tel","call","Call","เบอร์โทร","เบอร์","โทร","tell.","Tell.","tell","Tell","tel.","Tel.",
    "call.","Call.","เบอร์โทร.","เบอร์.","โทร.","tel-","Tel-","call-","Call-","เบอร์โทร-","เบอร์-","โทร-","tel ","Tel ",
    "call ","Call ","เบอร์โทร ","เบอร์ ","โทร ","tel.(","Tel.(","call.(","Call.(","เบอร์โทร.(","เบอร์.(","โทร.(","(",
    "tel(","Tel(","call(","Call(","เบอร์โทร(","เบอร์(","โทร(",];
    addressText.forEach(function(word, i){
        var key_address = telPattern.indexOf(word);
        if(key_address != -1) {
            console.log(i+"----------------------" + word);
            addressText.splice(addressText.indexOf(word),1);                  
        }       
    });
    console.log(addressText,"addressText");    
    for (i in addressText){     
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
    $('#splitWord').hide();
    $('#undoAddress').show();
}
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
    $('#splitWord').show();
    $('#undoAddress').hide();
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
            <div class="col-sm-3">
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
    <div class="form-group" style="display: block;">
        <a  id="splitWord" href="javascript:SupperateAddress()" class="btn btn-sm btn-info"><i class="fa fa-arrows-alt"> </i>&nbsp;&nbsp;Split</a>
        <a id="undoAddress" href="javascript:UndoAddress()" class="btn btn-sm btn-info"style="display: none;"><i class="fa fa-arrows-alt"> </i>&nbsp;&nbsp;Undo</a>
    </div>
    <div class="form-group">
        <input type="text" id="Zipcode" class="form-control form-control-full input-sm input-require" name="CustomerAddress[zipcode]" placeholder="รหัสไปรษณีย์">		          
    </div>
</div>
                