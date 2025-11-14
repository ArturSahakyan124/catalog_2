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
                if (response.status) resolve(response);
                else reject(new Error(response.message || 'Request failed'));
            },
            error: function (xhr) {
                reject(new Error(xhr.responseText || 'AJAX error'));
            }
        });
    });
}
