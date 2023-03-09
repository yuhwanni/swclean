function alertMsg (msg) {
    bootbox.alert({
        message: msg,
        backdrop: true
    });
}

function alertMsgReload (msg) {
    bootbox.alert({
        message: msg,
        backdrop: true,
        callback: function () {
            location.reload();
        }
    });
}

function alertMsgGo (msg, url) {
    bootbox.alert({
        message: msg,
        backdrop: true,
        callback: function () {
            location.href = url;
        }
    });
}

function confirmMsg (msg, callback) {
    bootbox.confirm(msg, eval(callback));
}

//윈도우 팝업창
function fnWinPopup(w_url, w_name, w_width, w_height) {
    var w_left = (screen.width - w_width) / 2;
    var w_top = (screen.height - w_height) / 2;
    var ChkWindow = window.open(
        w_url,
        w_name,
        'left=' +
        w_left +
        ', top=' +
        w_top +
        ', width=' +
        w_width +
        ', height=' +
        w_height +
        ', scrollbars=yes, statusbars=no'
    );
    ChkWindow.focus();
}

function getCookie(cname) {
    var name = cname + '=';
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}

// 쿠키값 설정
function setCookie(name, value, expiredays, domain) {
    let today = new Date();
    today.setDate(today.getDate() + expiredays);

    domain = domain ? '; domain=' + domain : '';

    document.cookie =
        name +
        '=' +
        escape(value) +
        '; path=/' +
        domain +
        '; expires=' +
        today.toGMTString() +
        ';';
}

function delCookie(name, domain) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';

    domain = domain ? '; domain=' + domain : '';
    // Google trans 때문에 추가.. TODO 도메인 주소 확인
    document.cookie =
        name + '=; Path=/' + domain + '; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function removeURLParameters(removeParams) {
    const deleteRegex = new RegExp(removeParams.join('=|') + '=')

    const params = location.search.slice(1).split('&');

    let search = []
    for (let i = 0; i < params.length; i++)
        if (deleteRegex.test(params[i]) === false) search.push(params[i]);


    if (search.length > 1) {
        let url = location.pathname + (search.length ? '?' + search.join('&') : '') + location.hash;
        window.history.replaceState({}, document.title, url);
    }
}

//url,data,dataT,func,form_id,type,ret, head, fileup
//ajaxProcess ({url:'',data:''})
function ajaxProcess() {
    let s = eval(arguments[0]);
    let data = '';
    let add_data = '';
    let ret = '';
    let load_bar = '';
    var formData;
    var option;

    if (!isUndefined(s.form_id)) {
        if (s.fileup) {
            var frm = $('#' + s.form_id)[0];
            formData = new FormData(frm);
        } else {
            add_data = $('#' + s.form_id).serialize();
        }
    }

    if (!isUndefined(s.data)) {
        if (s.fileup) {
            var obj = getParams(s.data);

            for (var key in obj) {
                formData.append(key, obj[key]);
            }
        } else {
            data = s.data;
        }
    }

    if (!isUndefined(s.load_bar)) {
        load_bar = s.load_bar;
    }

    if (add_data) data += '&' + add_data;

    //true: 비동기  false:동기
    let async = s.async ? true : false;

    if (s.fileup) {
        option = {
            type: 'POST',
            enctype: 'multipart/form-data',
            url: s.url,
            dataType: 'json',
            processData: false,
            contentType: false,
            async: async,
            beforeSend: function () {
                if(load_bar) {
                    loading("등록중입니다..");
                }
            },
            data: formData,
            timeout: 100000,
            success: function (result) {
                if (s.func != undefined) {
                    var fn = eval(s.func);
                    fn(result);
                }

                //if (async) { hideLoader(); }
                if(load_bar) { loading_end(); }
            },
            error: function (x, e) {
                if(load_bar) { loading_end(); }
                alertMsg('Ajax 요청 에러입니다. / ' + e + ' / STATUS : ' + x.status);
            },
        };
    } else {
        option = {
            type: 'POST',
            url: s.url,
            dataType: 'json',
            async: async,
            beforeSend: function () {
                if(load_bar) {
                    loading("등록중입니다..");
                }
            },
            data: data,
            timeout: 100000,
            success: function (result) {
                if (s.func != undefined) {
                    var fn = eval(s.func);
                    fn(result);
                }

                //if (async) { hideLoader(); }
                if(load_bar) { loading_end(); }
            },
            error: function (x, e) {
                if(load_bar) { loading_end(); }
                alertMsg(
                    'Ajax 요청 에러입니다. / ' + e + ' / STATUS : ' + x.status,
                    ''
                );
                if (async) {
                    hideLoader();
                }
            },
        };
    }

    let rst = '';
    if (async) {
        //showLoader();
    }
    rst = $.ajax(option);

    if (!async) {
        return eval('(' + rst.responseText + ')');
    }
}

function isUndefined(data) {
    return data === undefined ? true : false;
}

function showLoader() {
    $('.loading_dimmer').show();
}

function hideLoader() {
    $('.loading_dimmer').hide();
}

function isNull(data) {
    if(data == undefined || data == "undefined" || data == "" || data == "null" || data == null) {
        return true;
    } else {
        return false;
    }
}

function commonRst(d) {
    let msgTxt = '';
    switch (d.rst) {
        case 'S':
            msgTxt = '적용 되었습니다.';
            break;
        case 'SC':
            msgTxt = d.msg; //사용자 정의 완료메세지
            break;
        case 'E0':
            msgTxt = '정보가 부족합니다.';
            break;
        case 'E1':
            msgTxt = '작업 실패!';
            break;
        case 'E10':
            msgTxt = d.err;
            break;
        case 'E100':
            msgTxt = '작업권한이 없습니다.';
            break;
    }

    if (msgTxt && (d.rst == 'S' || d.rst == 'SC')) {
        msgTxt = d.msgTxt ? d.msgTxt : msgTxt;
        let url = d.url ? d.url : '';
        let type = d.type ? d.type : '';
        if (url) {
            alertMsgGo(msgTxt,url);
        } else {
            alertMsgReload(msgTxt);
        }
    } else if (msgTxt) {
        alertMsg(msgTxt);
    }
}

function commonRst2(d) {
    let msgTxt = '';

    if(!isUndefined(d.resp.success)) {
        switch (d.resp.success) {
            case true:
            case false:
                msgTxt = d.resp.msg;
                break;
        }
    }

    if (msgTxt && (d.rst == 'S' || d.rst == 'SC')) {
        msgTxt = d.msgTxt ? d.msgTxt : msgTxt;
        let url = d.url ? d.url : '';
        let type = d.type ? d.type : '';
        if (url) {
            alertMsgGo(msgTxt,url);
        } else {
            alertMsgReload(msgTxt);
        }
    } else if (msgTxt) {
        alertMsg(msgTxt);
    }
}

//모달 팝업 열기
function funcModalOpen(
    url,
    data,
    size = 'D',
    method = 'POST',
    target = 'modal-content'
) {
    let id = '';
    switch (size) {
        case 'L':
            id = 'modalBinLg';
            break;
        case 'M':
            id = 'modalBinM';
            break;
        case 'D':
            id = 'modalBin';
            break;
        case 'I':
            id = 'modalBinDefault';
            break;
    }
    if (method == 'GET') {
        $.get(url, function (data, status) {
            $('#' + id)
                .find('.' + target)
                .html(data);
            $('#' + id).modal('show');
        });
    }

    if (method == 'POST') {
        $('#' + id)
            .find('.' + target)
            .load(url, data, function () {
                $('#' + id).modal('show');
            });
    }
}

//로딩바
function loading(msg) {
    $.blockUI({
        message: '<i class="icon-spinner4 spinner"></i> ' + msg,
        overlayCSS: {
            backgroundColor: '#1b2024',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            border: 0,
            color: '#fff',
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function loading_end() {
    $.unblockUI();
}