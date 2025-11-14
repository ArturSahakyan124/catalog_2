function sendRequestPromise(url, method, data) {
    const isFormData = data instanceof FormData;

    return new Promise((resolve, reject) => {
        $.ajax({
            url,
            type: method,
            data: data,
            dataType: 'json',
            processData: !isFormData,
            contentType: !isFormData ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
            cache: false,
            success: function (response) {
                // выводим весь ответ сервера в консоль
                console.log('AJAX success response:', response);

                if (response.success || response.status) {
                    resolve(response);
                } else {
                    reject(new Error(response.message || JSON.stringify(response)));
                }
            },
            error: function (xhr) {
                // выводим текст ответа сервера и объект XHR
                console.error('AJAX failed, xhr:', xhr);
                let msg = xhr.responseText || 'AJAX error';
                $('.msg').removeClass('none').text
