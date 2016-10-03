// 按钮等待时间
function btnWaitSeconds(el, text, time) {
    $(el).text('等待 ' + time + ' 秒');
    if (time > 0) {
        $(el).prop('disabled', true);
        setTimeout(function () {
            btnWaitSeconds(el, text, time - 1);
        }, 1000);
    } else {
        $(el).prop('disabled', false);
        $(el).text(text);
    }
}