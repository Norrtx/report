<?php
use conquer\jvectormap\JVectorMapWidget;
use yii\helpers\Url;
use frontend\assets\AppAsset;
AppAsset::register($this);
/* @var $this yii\web\View */
$POS_END = <<< JS
let subdistricts = require('./subdistricts.json')
rememberAddress = $('#Address').val().trim();
    var addressText = $("#Address").val().trim(); 
    
    var splitText = addressText; 
    splitText = splitText.split("");
    var rememberNumber = "";
    var beginIndex = "";
    var endIndex = "";
    var phonemobile = ["06","08","09"];
    var phonehome = ["02","03","04","05","07"];
const split = (addressText) => {
    try {
        const cleanText = removePrefix(addressText);
        let wordlist = cleanText.split(' ').filter(word => /[ก-๙]{2,}/.test(word));
        wordlist = [...new Set(wordlist)];
        const mainAddress = findSubdistrict(wordlist);
        const result = finalResult(cleanText, mainAddress);
        return result;
    } catch (error) {
        console.error(error);
    }
};
const removePrefix = (addressText) => {
    const prefixPattern = /(เขต|แขวง|จังหวัด|อำเภอ|ตำบล|อ\.|ต\.|จ\.|โทร\.?|เบอร์|ที่อยู่)/g;
    let string = addressText.replace(/\s+/g, ' ');
    string = string.replace(prefixPattern, '');
    return string;
}
const finalResult = (addressText, mainAddress) => {
    const namePattern = /(เด็กชาย|เด็กหญิง|ด\.ช\.|ด\.ญ\.|นาย|นาง|นางสาว|น\.ส\.|ดร\.|คุณ)([ก-๙]+\s[ก-๙]+(\sณ\s[ก-๙]+)?)/;
    const phonePattern = /(09|08|06)\d{1}(\d{7}|-\d{7}|-\d{3}-\d{4})/;

    let remainingTxt = addressText;

    const keyPattern = Object.values(mainAddress);
    keyPattern.forEach(key => {
        remainingTxt = remainingTxt.replace(key, '').trim();
    });

    const nameMatched = remainingTxt.match(namePattern);
    let name = '';
    if (nameMatched) {
        [name] = nameMatched
    }
    remainingTxt = remainingTxt.replace(name, '').trim();

    const phoneMatched = remainingTxt.match(phonePattern);
    let phone = '';
    if (phoneMatched) {
        [phone] = phoneMatched
    }
    remainingTxt = remainingTxt.replace(phone, '').trim();
    phone = phone.replace(/-/g, '');

    remainingTxt = remainingTxt.replace('()', '').trim();

    const address = remainingTxt.replace(/\s+/g, ' ').trim();

    return {
        name,
        phone,
        address,
        ...mainAddress
    }

}

const findSubdistrict = (wordlist) => {
    let results = [];

    for (let word of wordlist) {
        const filtered = subdistricts.filter(item => {
            return item.name.includes(word)
        });
        results = results.concat(filtered);
    }

    const bestMatched = findBestMatched(results).name.split(', ');

    return {
        subdistrict: bestMatched[0],
        district: removePrefix(bestMatched[1]),
        province: removePrefix(bestMatched[2]),
        zipcode: bestMatched[3]
    };
};

const findBestMatched = (filtered) => {
    let results = [];

    filtered.reduce((res, value) => {
        if (!res[value.name]) {
            res[value.name] = {
                count: 0,
                name: value.name
            };
            results.push(res[value.name])
        }
        res[value.name].count += 1
        return res;
    }, {});

    const firstMatch = results.sort((a, b) => {
        if (a.count > b.count) {
            return -1;
        }
        if (a.count > b.count) {
            return 1;
        }
        return 0;
    })[0];

    if (firstMatch.count === 1) {
        throw new Error('No Match Found');
    }

    return firstMatch;
}

module.exports = {
    split
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
                