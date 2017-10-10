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
 * Добавление новой категории
 */
function newCategory() {
    var postData = getData('#blockNewCategory');

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=addnewcat",
        data: postData,
        dataType: "json",
        async: false,
        success: function (data) {
            if (data['success']) {
                alert(data['message']);
                $('#newCategoryName').val('');
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Обновление категории
 * @param itemId
 */
function updateCat(itemId) {
    var parentId = $('#parentId_' + itemId).val();
    var newName = $('#itemName_' + itemId).val();
    var postData = {itemId: itemId, parentId: parentId, newName: newName};

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=updatecategory",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (data['success']) {
                alert(data['message']);
            } else {
                alert(data['message']);
            }
        }
    })
}

/**
 * Добавление нового товара
 */
function addProduct() {
    var itemName = $('#newItemName').val();
    var itemPrice = $('#newItemPrice').val();
    var itemDesc = $('#newItemDesc').val();
    var itemCatId = $('#newItemCatId').val();

    var postData = {itemName: itemName, itemPrice: itemPrice, itemDesc: itemDesc, itemCatId: itemCatId};

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=addproduct",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            alert(data['message']);
            if (data['success']) {
                $('#newItemName').val('');
                $('#newItemPrice').val('');
                $('#newItemDesc').val('');
                $('#newItemCatId').val('');
            }
        }
    });
}

/**
 * Изменение данных продукта
 */
function updateProduct(itemId) {
    var itemName = $('#itemName_' + itemId).val();
    var itemPrice = $('#itemPrice_' + itemId).val();
    var itemDesc = $('#itemDesc_' + itemId).val();
    var itemCatId = $('#itemCatId_' + itemId).val();
    var itemStatus = $('#itemStatus_' + itemId).attr("checked");
    if (!itemStatus) {
        itemStatus = 1;
    } else {
        itemStatus = 0;
    }
    var postData = {
        itemId: itemId,
        itemName: itemName,
        itemPrice: itemPrice,
        itemCatId: itemCatId,
        itemDesc: itemDesc,
        itemStatus: itemStatus
    };

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=updateproduct",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            alert(data['message']);
        }
    })
}

/**
 * Обновление статуса заказа
 * @param itemId
 */
function updateOrderStatus(itemId) {
    var status = $('#itemStatus_' + itemId).attr("checked");
    if (!status) {
        status = 0;
    } else {
        status = 1;
    }
    var postData = {itemId: itemId, status: status}

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=setorderstatus",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (!data['success']) {
                alert(data['message']);
            }
        }
    });
}


function updateDatePayment(itemId) {
    var datePayment = $('#datePayment_' + itemId).val();
    var postData = {itemId: itemId, datePayment: datePayment};

    $.ajax({
        type: "POST",
        url: "/?controller=admin&action=setorderdatepayment",
        async: false,
        data: postData,
        dataType: "json",
        success: function (data) {
            if (!data['success']) {
                alert(data['message']);
            }
        }
    })
}