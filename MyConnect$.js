function post(phpFileName, options, callback, errorCallback) {
    $.ajax({
        url: `${phpFileName}.php`,
        type: 'post',
        data: JSON.stringify(options),
        dataType: 'json',
        success: callback,
        error: errorCallback
    })
}
