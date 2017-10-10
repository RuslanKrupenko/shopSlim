/**
 *  Функция добавления товара в карзину
 *  @param integer itemId идентификатор товара
 *  @return в случае успеха обновляются данные на странице
 */
function addToCart(itemId) {
    console.log("js - addToCart()");
    $.ajax({
        type: "POST",
        async: false,
        url: "/?controller=cart&action=addtocart&id=" + itemId,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                $("#cartCntItems").html(data['cntItems']);

                $("#addCart_" + itemId).hide();
                $("#removeCart_" + itemId).show();
            }
        }
    });
}

function removeFromCart(itemId) {
    console.log("js - removeFromCart()");
    $.ajax({
        type: "POST",
        async: false,
        url: "/?controller=cart&action=removefromcart&id=" + itemId,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                $("#cartCntItems").html(data['cntItems']);

                $("#removeCart_" + itemId).hide();
                $("#addCart_" + itemId).show();
            }
        }
    });
}

/**
 * Подсчет стоимости купленного товара
 * @param itemId ID товара
 */
function conversionPrice(itemId) {
    var newCnt = $("#itemCnt_" + itemId).val();
    var itemPrice = $("#itemPrice_" + itemId).attr("value");
    var itemRealPrice = newCnt * itemPrice;

    $("#itemRealPrice_" + itemId).html(itemRealPrice);
}

/**
 * Обработка данных из формы регистрации
 */
function getData(obj_form) {
    var hData = {};
    $("input, textarea, select", obj_form).each(function () {
        if (this.name && this.name != '') {
            hData[this.name] = this.value;
            console.log("hData['" + this.name + "'] = " + hData[this.name]);
        }
    });
    return hData;
}

/**
 * Ajax запрос, отправка данных для регистрации пользователя
 */
function registerNewUser() {
    var postData = getData("#registerBox");

    $.ajax({
        type: "POST",
        async: false,
        url: "/?controller=user&action=register",
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                alert("Регистрация прошла успешно!");

                $("#registerBox").hide();
                $("#userLink").attr("href", "/?controller=user");
                $("#userLink").html(data['userName']);
                $("#userBox").show();

                $("#loginBox").hide();
                $("#btnSaveOrder").show();
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Авторизация полььзователя
 */
function login() {
    var email = $("#loginEmail").val();
    var pwd = $("#loginPwd").val();

    var postData = "email=" + email + "&pwd=" + pwd;

    $.ajax({
        type: "POST",
        url: "/?controller=user&action=login",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                $("#registerBox").hide();
                $("#loginBox").hide();

                $("#userLink").attr("href", "/?controller=user");
                $("#userLink").html(data['displayName']);
                $("#userBox").show();

                // заполняем поля на странице заказа
                $('#name').val(data['name']);
                $('#phone').val(data['phone']);
                $('#address').val(data['address']);

                $('#btnSaveOrder').show();
            } else {
                alert(data['message']);
            }
        }
    })
}

function showRegisterBox() {
    $("#registerHidden").toggle();
}

/**
 * Обновлениие данных пользоваателя
 */
function updateUserData() {
    console.log("js - updateUserData()");
    var phone = $("#newPhone").val();
    var name = $("#newName").val();
    var address = $("#newAddress").val();
    var pwd1 = $("#newPwd1").val();
    var pwd2 = $("#newPwd2").val();
    var curPwd = $("#curPwd").val();

    var postData = {
        "phone": phone,
        "name": name,
        "address": address,
        "pwd1": pwd1,
        "pwd2": pwd2,
        "curPwd": curPwd
    };

    $.ajax({
        type: "POST",
        url: "/?controller=user&action=update",
        data: postData,
        dataType: "json",
        async: false,
        success: function (data) {
            if (data['success']) {
                console.log(1);
                $("#userLink").html(data['userName']);
                alert(data['message']);
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Сохранить заказ
 */
function saveOrder() {
    var postData = getData('form');
    $.ajax({
        type: "POST",
        async: false,
        url: "/?controller=cart&action=saveorder",
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                alert(data['message']);
                document.location = '/';
            } else {
                alert(data['message']);
            }
        }
    });
}

function showProducts(id) {
    var objName = "#purchasesForOrderId_" + id;
    if ($(objName).css('display') != 'table-row') {
        console.log(1);
        $(objName).show();
    } else {
        $(objName).hide();
    }
}